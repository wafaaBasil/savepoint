<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\App;
use App\Http\Resources\User as UserResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Token;

class RegisterController  extends BaseController
{
     protected $code;
     

    
     public function register_provider(Request $request)
     {
         $input = $request->all();
     
         $validator_en =  Validator::make($input ,[
             'name' => 'string|required|max:255',
             'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
             'type' => 'string|required|in:restaurant,cafe',
             'commercial_register' => 'required',
             'overview' => 'string|required',
             'email' => 'string|required|unique:providers,email',
             'phonenumber' => 'string|required|unique:providers,phonenumber',
             'manager_name' => 'string|required|max:255',
             'manager_phonenumber' => 'string|required|max:255',
             'account_name' => 'string|required|max:255',
             'account_phonenumber' => 'string|required|unique:users,phonenumber',
             'account_email' => 'email|required|unique:users,email',
             'account_password' => 'string|required|max:255',
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
         ]);
 
         $validator =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'logo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'string|required|in:restaurant,cafe',
            'commercial_register' => 'required',
            'overview' => 'string|required',
            'email' => 'string|required|unique:providers,email',
            'phonenumber' => 'string|required|unique:providers,phonenumber',
            'manager_name' => 'string|required|max:255',
            'manager_phonenumber' => 'string|required|max:255',
            'account_name' => 'string|required|max:255',
            'account_phonenumber' => 'string|required|unique:users,phonenumber',
            'account_email' => 'email|required|unique:users,email',
            'account_password' => 'string|required|max:255',
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
         
         $provider = new Provider();
         $provider->name = $request->name;
         $provider->type = $request->type;
         $provider->logo = $request->logo;
         $provider->commercial_register = $request->commercial_register;
         $provider->overview = $request->overview;
         $provider->email = $request->email;
         $provider->phonenumber = $request->phonenumber;
         $provider->manager_name = $request->manager_name;
         $provider->manager_phonenumber = $request->manager_phonenumber;
         $provider->save();

         $user = new User();
         $user->name = $request->account_name;
         $user->phonenumber = $request->account_phonenumber;
         $user->email = $request->account_email;
         $user->password = $request->account_password;
         $user->user_type = 'provider_admin';
         $user->provider_id = $provider->id;
         $user->save();
 
 
         $success['user']=new UserResource(User::find($user->id));
         $success['status']= 200;    
 
         return $this->sendResponse($success,'تم تسجيل حساب جديد بنجاح','Provider Registered Successfully');
     }
}
