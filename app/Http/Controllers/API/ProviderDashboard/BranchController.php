<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use App\Models\BranchImage;
use App\Models\BranchOption;
use Illuminate\Http\Request;
use App\Models\Branch;
use Validator;
use App\Http\Resources\Branch as BranchResource;
use App\Http\Controllers\API\BaseController as BaseController;


class BranchController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $branchs = Branch::where('provider_id',auth("sanctum")->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $branchs = Branch::where('provider_id',auth("sanctum")->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $branchs->lastPage();
        }
       
        
        $success['branchs']=BranchResource::collection($branchs);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع الأفرع بنجاح','Branchs returned successfully');
    }

   
    public function create(Request $request)
    {
        $input = $request->all();
    
        $validator_en =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'phonenumber' => 'string|required|max:255',
            'address' => 'string|required',
            'city_id' => 'numeric|required|exists:cities,id',
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
            'phonenumber' => 'string|required|max:255',
            'city_id' => 'numeric|required|exists:cities,id',
            'address' => 'string|required',
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
        
        $branch = new Branch();
        $branch->name = $request->name;
        $branch->phonenumber = $request->phonenumber;
        $branch->city_id = $request->city_id;
        $branch->address = $request->address;
        $branch->provider_id = auth("sanctum")->user()->provider_id;
        $branch->save();

        $success['branch']=new BranchResource(Branch::find($branch->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم اضافة فرع جديد بنجاح','Branch created Successfully');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
    
        $branch = Branch::find($id);
        
        $validator_en =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'phonenumber' => 'string|required|max:255',
            'city_id' => 'numeric|required|exists:cities,id',
            'address' => 'string|required',
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
            'city_id' => 'numeric|required|exists:cities,id',
            'address' => 'string|required',
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
        
        
        $branch->name = $request->name;
        $branch->phonenumber = $request->phonenumber;
        $branch->city_id = $request->city_id;
        $branch->address = $request->address;
        $branch->save();
         
        $success['branch']=new BranchResource(Branch::find($branch->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم تعديل فرع بنجاح','Branch updated Successfully');
    }

    public function status($status, $id)
    {
        $branch = Branch::find($id);
       
        if(is_null($branch)){
            return $this->sendError('الفرع غير موجود','Branch not Found!',404);
        }
        if($status == 'delete'){
           $branch->images()->delete();
           $branch->options()->delete();
           $branch->enhancements()->delete();
            $branch->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف الفرع بنجاح','Branch deleted successfully');
        
        }
        elseif($status == 'activate'){
           
            $branch->active = 1;
            $branch->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل الفرع بنجاح','Branch activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $branch->active = 0;
            $branch->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل الفرع بنجاح','Branch deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
        
    }


}