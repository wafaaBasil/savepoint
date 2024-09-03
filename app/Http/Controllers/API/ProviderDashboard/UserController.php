<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use App\Models\UserImage;
use App\Models\UserOption;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\API\BaseController as BaseController;


class UserController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $users = User::where('provider_id',auth("sanctum")->user()->provider_id)->where('user_type','provider_employee')->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $users = User::where('provider_id',auth("sanctum")->user()->provider_id)->where('user_type','provider_employee')->orderBy('created_at','desc')->paginate(10);
            $page_count = $users->lastPage();
        }
       
        
        $success['users']=UserResource::collection($users);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المستخدمين بنجاح','Users returned successfully');
    }

   
    public function create(Request $request)
    {
        $input = $request->all();
    
        $validator_en =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'phonenumber' => 'string|required|max:255',
            'email' => 'email|required|unique:users,email',
            'branch_id' => 'numeric|required|exists:branches,id',
            'active' => 'required|boolean',
            'password' => ['required','confirmed','string','min:6'],
        ],[
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
            'phonenumber.required' => 'A phone number is required.',
            'phonenumber.max' => 'A phone number must not be greater than 255.',
            'phonenumber.string' => 'A phone number must be a string.',
            'email.required' => 'A email is required.',
            'email.email' => 'A email must be a email.',
            'branch_id.required' => 'A branch is required.',
            'branch_id.numeric' => 'A branch must be a number.',
            'branch_id.exists' => 'A branch not valid.',
            'active.required' => 'A active is required.',
            'active.boolean' => 'The active must be a boolean.',
        ]);

        $validator =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'phonenumber' => 'string|required|max:255',
            'email' => 'email|required|unique:users,email',
            'branch_id' => 'numeric|required|exists:branches,id',
            'active' => 'required|boolean',
            'password' => ['required','confirmed','string','min:6'],
        ],[
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'حقل الاسم يجب ان يكون نص.',
            'phonenumber.required' => 'حقل رقم الجوال مطلوب.',
            'phonenumber.max' => 'يجب أن لا يتجاوز طول رقم الجوال 255.',
            'phonenumber.string' => 'حقل رقم الجوال يجب ان يكون نص.',
            'email.required' => 'حقل البريد الالكتروني مطلوب.',
            'email.email' => 'حقل البريد الالكتروني يجب ان يكون بريد الكتروني.',
            'branch_id.required' => 'حقل الفرع مطلوب.',
            'branch_id.numeric' => 'حقل الفرع يجب ان يكون رقم.',
            'branch_id.exists' => 'حقل الفرع غير صحيح.',
            'active.required' => 'حقل التفعيل مطلوب.',
            'active.boolean' => 'قيمة حقل التفعيل يجب ان تكون boolean.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->branch_id = $request->branch_id;
        $user->provider_id = auth("sanctum")->user()->provider_id;
        $user->active = $request->active;
        $user->password = $request->password;
        $user->user_type = 'provider_employee';
        $user->save();

        $success['user']=new UserResource(User::find($user->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم اضافة مستخدم جديد بنجاح','User created Successfully');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
    
        $user = User::find($id);
        
        if(is_null($user) || $user->user_type != 'provider_employee'){
            return $this->sendError('المستخدم غير موجود','User not Found!',404);
        }

        $validator_en =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'phonenumber' => 'string|required|max:255|unique:users,phonenumber',
            'email' => 'email|required|unique:users,email,'.$user->id.',id',
            'branch_id' => 'numeric|required|exists:branches,id',
            'active' => 'required|boolean',
            'password' => ['nullable','confirmed','string','min:6'],
        ],[
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
            'phonenumber.required' => 'A phone number is required.',
            'phonenumber.max' => 'A phone number must not be greater than 255.',
            'phonenumber.string' => 'A phone number must be a string.',
            'email.required' => 'A email is required.',
            'email.email' => 'A email must be a email.',
            'branch_id.required' => 'A branch is required.',
            'branch_id.numeric' => 'A branch must be a number.',
            'branch_id.exists' => 'A branch not valid.',
            'active.required' => 'A active is required.',
            'active.boolean' => 'The active must be a boolean.',
        ]);

        $validator =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'phonenumber' => 'string|required|max:255|unique:users,phonenumber',
            'email' => 'email|required|unique:users,email,'.$user->id.',id',
            'branch_id' => 'numeric|required|exists:branches,id',
            'active' => 'required|boolean',
            'password' => ['nullable','confirmed','string','min:6'],
        ],[
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'حقل الاسم يجب ان يكون نص.',
            'phonenumber.required' => 'حقل رقم الجوال مطلوب.',
            'phonenumber.max' => 'يجب أن لا يتجاوز طول رقم الجوال 255.',
            'phonenumber.string' => 'حقل رقم الجوال يجب ان يكون نص.',
            'email.required' => 'حقل البريد الالكتروني مطلوب.',
            'email.email' => 'حقل البريد الالكتروني يجب ان يكون بريد الكتروني.',
            'branch_id.required' => 'حقل الفرع مطلوب.',
            'branch_id.numeric' => 'حقل الفرع يجب ان يكون رقم.',
            'branch_id.exists' => 'حقل الفرع غير صحيح.',
            'active.required' => 'حقل التفعيل مطلوب.',
            'active.boolean' => 'قيمة حقل التفعيل يجب ان تكون boolean.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->branch_id = $request->branch_id;
        $user->active = $request->active;
        if(!is_null($user->password)){
            $user->password = $request->password;
        }
        $user->save();
         
        $success['user']=new UserResource(User::find($user->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم تعديل مستخدم بنجاح','User updated Successfully');
    }

    public function status($status, $id)
    {
        $user = User::find($id);
       
        if(is_null($user) || $user->user_type != 'provider_employee'){
            return $this->sendError('المستخدم غير موجود','User not Found!',404);
        }
        if($status == 'delete'){
           $user->images()->delete();
           $user->options()->delete();
           $user->enhancements()->delete();
            $user->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف المستخدم بنجاح','User deleted successfully');
        
        }
        elseif($status == 'activate'){
           
            $user->active = 1;
            $user->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل المستخدم بنجاح','User activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $user->active = 0;
            $user->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل المستخدم بنجاح','User deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
        
    }


}