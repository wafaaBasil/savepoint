<?php
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PasswordReset;
use App\Models\User;
use Validator;
use Illuminate\Support\Str;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\API\BaseController as BaseController;

class PasswordResetController extends BaseController
{

    protected $code, $smsVerifcation;
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    public function create(Request $request)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
        ],[
            'phonenumber.required' => 'A phone number is required',
            'phonenumber.numeric' => 'A phone number is number',
            'phonenumber.size' => 'A phone number is 9 digits',
        ]);

        $validator =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
        ],[
            'phonenumber.required' => 'رقم الجوال مطلوب',
            'phonenumber.numeric' => 'رقم الجوال عبارة عن رقم',
            'phonenumber.size' => 'رقم الجوال 9 خانات',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }

        $user = User::where('phonenumber', $request->phonenumber)->first();
        if (!$user){
            return $this->sendError('المستخدم غير موجود','We cant find a user with that username.',404);
        }
        
        $passwordReset = PasswordReset::updateOrCreate(
            ['phonenumber' => $user->phonenumber],
            [
                'phonenumber' => $user->phonenumber,
                'token' => Str::random(60)
             ]
        );
        
        if ($user && $passwordReset){
                $user->generateCode();
              /*   $data = array(
                'code'   =>   $user->code,
            );*/
            
            //$request->code = $user->code;
            //$request->phonenumber =$user->phonenumber;
            
            //$this->sendSms($request); // send and return its response
        }

        $success['status']= 200;
        $success['user']= new UserResource($user);
        return $this->sendResponse($success,'تم ارسال الرسالة بنجاح','SMS send successfully');
    }
    
     
    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->first();
        if (!$passwordReset){
            return $this->sendError(' خطأ في توكين استعادة كلمة المرور','This password reset token is invalid.',404);
        }
        if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
            $passwordReset->delete();
            return $this->sendError('خطأ في توكين استعادة كلمة المرور','This password reset token is invalid.',404);
        }
        
        $success['status']= 200;
        $success['passowrdReset']= $passwordReset;
        return $this->sendResponse($success,'توكين استعادة كلمة المرور صحيح','This password reset token is valid.');
    }
     /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */
    public function reset(Request $request)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
            'password' => ['required','confirmed','string','min:6'],
            'token' => 'required|string',
        ],[
            'phonenumber.required' => 'A phone number is required',
            'phonenumber.numeric' => 'A phone number is number',
            'phonenumber.size' => 'A phone number is 9 digits',
            'token.required' => 'A token is required',
            'token.string' => 'A token is string',
            'password.required' => 'A password is required',
            'password.string' => 'A password is string',
            'password.min' => 'The password field must be at least 6 characters.',
        ]);

        $validator =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
            'password' => ['required','confirmed','string','min:6'],
            'token' => 'required|string',
        ],[
            'phonenumber.required' => 'رقم الجوال مطلوب',
            'phonenumber.numeric' => 'رقم الجوال عبارة عن رقم',
            'phonenumber.size' => 'رقم الجوال 9 خانات',
            'token.required' => 'التوكين مطلوب',
            'token.string' => 'التوكين عبارة عن نص',
            'password.required' => 'كلمة المرور مطلوب',
            'password.string' => 'كلمة المرور عبارة عن نص',
            'password.min' => 'يجب أن يكون طول نص كلمة المرور على الأقل 6 حروف',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }

        
       
        $user = User::where('phonenumber', $request->phonenumber)->first();
        if (!$user){
            return $this->sendError('المستخدم غير موجود','We cant find a user with that username.',404);
        }
        
        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['phonenumber', $user->phonenumber]
        ])->first();
        if (!$passwordReset)
            return $this->sendError('خطأ في توكين استعادة كلمة المرور','This password reset token is invalid.',404);
        
        
        $user = User::where('phonenumber', $passwordReset->phonenumber)->first();
        if (!$user)
            return $this->sendError('المستخدم غير موجود','We cant find a user with that e-mail address.',404);
            
        $user->password = $request->password;
        $user->save();
        $passwordReset->delete();

        
        $success['status']= 200;
        $success['user']= new UserResource($user);
        return $this->sendResponse($success,'تم استعادة كلمة المرور بنجاح','The password reset success.');
    }

    /////////////////////////////////////////////////// SMS
    public function verifyContact(Request $request)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
            'code' => 'required|numeric',
        ],[
            'phonenumber.required' => 'A phone number is required',
            'phonenumber.numeric' => 'A phone number is number',
            'phonenumber.size' => 'A phone number is 9 digits',
            'code.required' => 'A code is required',
            'code.numeric' => 'A code is number',
        ]);

        $validator =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
            'code' => 'required|numeric',
        ],[
            'phonenumber.required' => 'رقم الجوال مطلوب',
            'phonenumber.numeric' => 'رقم الجوال عبارة عن رقم',
            'phonenumber.size' => 'رقم الجوال 9 خانات',
            'code.required' => 'الكود مطلوب',
            'code.numeric' => 'الكود عبارة عن رقم',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }

          
        $user = User::where('phonenumber', $request->phonenumber)->first();
        
        if($request->code == $user->code)
        {
            $passwordReset = PasswordReset::where('phonenumber',$user->phonenumber)->first();
            $user->resetCode();
            $success['status']= 200;
            $success['user']= new UserResource($user);
            $success['token']= $passwordReset->token;
            return $this->sendResponse($success,'تم التحقق','verified');
        }
        else
        {
            $success['status']= 200;
            return $this->sendResponse($success,'لم يتم التحقق','not verified');
        }
    }
    
    public function sendSms($request)
    {
        
        try
        {

 $data_string = json_encode($request); 
            
            
            $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://rest.gateway.sa/api/SendSMS',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{ 
        "api_id":"'.env("GETWAY_API", null).'", 
        "api_password":"'.env("GETWAY_PASSWORD", null).'", 
        "sms_type": "T", 
        "encoding":"T", 
        "sender_id": "MASHAHER", 
        "phonenumber": "'.$request->phonenumber.'", 
        "textmessage":"'.$request->code.'", 

  	"templateid": null, 
  	"V1": null, 
  	"V2": null, 
  	"V3": null, 
  	"V4": null, 
  	"V5": null,
"ValidityPeriodInSeconds": 60,
"uid":"xyz",
"callback_url":"https://xyz.com/",
"pe_id":"xyz",
"template_id":"xyz"

        
        } 
        ',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
$decoded = json_decode($response);
if ($decoded->status =="S" ) {
    return true;
}
    
            return $this->sendError("فشل ارسال الرسالة","Failed Send Message",422);


            
        }
        catch (Exception $e)
        {
            return $this->sendError($e->getMessage(),$e->getMessage(),422);
        }
        
    }
    
    
}
