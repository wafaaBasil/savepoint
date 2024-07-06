<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enhancement;
use Validator;
use App\Http\Resources\Enhancement as EnhancementResource;
use App\Http\Controllers\API\BaseController as BaseController;


class EnhancementController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $enhancements = Enhancement::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $enhancements = Enhancement::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $enhancements->lastPage();
        }
       
        
        $success['enhancements']=EnhancementResource::collection($enhancements);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع الاضافات بنجاح','enhancements returned successfully');
    }

   
    public function create(Request $request)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'price' => 'numeric|required',
        ],[
            'price.required' => 'A price is required.',
            'price.numeric' => 'A price must be an number.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
        ]);

        $validator =  Validator::make($input ,[
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'numeric|required',
        ],[
            'image.required' => 'حقل السعر مطلوب.',
            'image.image' => 'حقل السعر يجب ان يكون رقم.',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'يجب ان يكون حقل الاسم نص.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        
        $enhancement = new Enhancement();
        $enhancement->image = $request->image;
        $enhancement->name = $request->name;
        $enhancement->provider_id = auth()->user()->provider_id;
        $enhancement->save();
         
        $success['enhancement']=new EnhancementResource($enhancement);
        $success['status']= 200;    

        return $this->sendResponse($success,'تم اضافة تصنيف جديد بنجاح','Enhancement created Successfully');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'name' => 'string|required|max:255',
            'price' => 'numeric|required',
        ],[
            'price.required' => 'A price is required.',
            'price.numeric' => 'A price must be an number.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
        ]);

        $validator =  Validator::make($input ,[
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'numeric|required',
        ],[
            'image.required' => 'حقل السعر مطلوب.',
            'image.image' => 'حقل السعر يجب ان يكون رقم.',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'يجب ان يكون حقل الاسم نص.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        
        $enhancement = Enhancement::find($id);
        $enhancement->name = $request->name;
        $enhancement->price = $request->price;
        $enhancement->save();
         
        $success['enhancement']=new EnhancementResource($enhancement);
        $success['status']= 200;    

        return $this->sendResponse($success,'تم تعديل الاضافة بنجاح','Enhancement updated Successfully');
    }

    public function status($status, $id)
    {
        $enhancement = Enhancement::find($id);
       
        if(is_null($enhancement)){
            return $this->sendError('الاضافة غير موجود','Enhancement not Found!',404);
        }
        if($status == 'delete'){
           
            $enhancement->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف الاضافة بنجاح','Enhancement deleted successfully');
        
        }
        elseif($status == 'activate'){
           
            $enhancement->active = 1;
            $enhancement->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل الاضافة بنجاح','Enhancement activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $enhancement->active = 0;
            $enhancement->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل الاضافة بنجاح','Enhancement deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
        
    }


}