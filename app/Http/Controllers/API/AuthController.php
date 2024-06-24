<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\App;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class AuthController  extends BaseController
{
     protected $code;
     

    
    public function login(Request $request)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
            'password' => 'string|required',
            'device_token' => 'string|required',
        ],[
            'phonenumber.required' => 'A phone number is required',
            'password.required' => 'A password is required',
            'device_token.required' => 'A device token is required',
            'phonenumber.numeric' => 'A phone number is number',
            'phonenumber.size' => 'A phone number is 9 digits',
            'password.string' => 'A password is string',
            'device_token.string' => 'A device token is string',
        ]);

        $validator =  Validator::make($input ,[
            'phonenumber' => 'numeric|required|digits:9',
            'password' => 'string|required',
            'device_token' => 'string|required',
        ],[
            'phonenumber.required' => 'رقم الجوال مطلوب',
            'password.required' => 'كلمة المرور مطلوبة',
            'device_token.required' => 'رمز الجهاز مطلوبة',
            'phonenumber.numeric' => 'رقم الجوال عبارة عن رقم',
            'phonenumber.size' => 'رقم الجوال 9 خانات',
            'password.string' => 'كلمة المرور عبارة عن نص',
            'device_token.string' => 'رمز الجهاز عبارة عن نص',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        
        if (!auth()->guard()->attempt(['phonenumber'=> $request->phonenumber, 'password' => $request->password])) {
            return $this->sendError('خطأ في اسم المستخدم أو كلمة المرور','Invalid Credentials',404);
        }
      
        
        $user = auth()->user();
                
         $user->update(['device_token'=>$request->device_token]);
         
        $success['user_type']=$user->user_type;
        $success['user']=new UserResource($user);
        $success['token']= $user->createToken('authToken')->accessToken;
        $success['status']= 200;    

        return $this->sendResponse($success,'تم تسجيل الدخول بنجاح','Login Successfully');
    }

    
    public function logout()
    {
       
        if(is_null(auth("api")->user())){
          //return  response()->json(['error' => 'Unauthenticated.'], 401);
          return $this->sendError('غير مصرح به','Unauthenticated',401);
        }
        
         $user = auth("api")->user()->token();
        auth("api")->user()->update([
            'device_token' => ""
            ]);
        $user->revoke();

        $success['status']= 200;
        return $this->sendResponse($success,'تم تسجيل الخروج بنجاح','User logout Successfully');

    }
}
