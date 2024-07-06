<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Validator;
use App\Http\Resources\ProductCategory as ProductCategoryResource;
use App\Http\Controllers\API\BaseController as BaseController;


class ProductCategoryController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $categories = ProductCategory::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $categories = ProductCategory::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $categories->lastPage();
        }
       
        
        $success['product_categories']=ProductCategoryResource::collection($categories);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع التصنيفات بنجاح','Categories returned successfully');
    }

   
    public function create(Request $request)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'string|required|max:255',
        ],[
            'image.required' => 'A image is required.',
            'image.image' => 'A image must be an image.',
            'image.mimes' => 'A image must be a file of type:jpeg,png,jpg,gif,svg.',
            'image.max' => 'A image must not be greater than 2048 kilobytes.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
        ]);

        $validator =  Validator::make($input ,[
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'string|required|max:255',
        ],[
            'image.required' => 'حقل الصورة مطلوب.',
            'image.image' => 'حقل الصورة يجب ان يكون صورة.',
            'image.mimes' => 'يجب أن يكون حقل الصورة ملفًا من نوع:jpeg,png,jpg,gif,svg.',
            'image.max' => 'يجب أن لا يتجاوز حجم الملف 2048 كيلوبايت .',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'يجب ان يكون حقل الاسم نص.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        
        $category = new ProductCategory();
        $category->image = $request->image;
        $category->name = $request->name;
        $category->provider_id = auth()->user()->provider_id;
        $category->save();
         
        $success['category']=new ProductCategoryResource(ProductCategory::find($category->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم اضافة تصنيف جديد بنجاح','Category created Successfully');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'string|required|max:255',
        ],[
            'image.required' => 'A image is required.',
            'image.image' => 'A image must be an image.',
            'image.mimes' => 'A image must be a file of type:jpeg,png,jpg,gif,svg.',
            'image.max' => 'A image must not be greater than 2048 kilobytes.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
        ]);

        $validator =  Validator::make($input ,[
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'string|required|max:255',
        ],[
            'image.required' => 'حقل الصورة مطلوب.',
            'image.image' => 'حقل الصورة يجب ان يكون صورة.',
            'image.mimes' => 'يجب أن يكون حقل الصورة ملفًا من نوع:jpeg,png,jpg,gif,svg.',
            'image.max' => 'يجب أن لا يتجاوز حجم الملف 2048 كيلوبايت .',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'يجب ان يكون حقل الاسم نص.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        
        $category = ProductCategory::find($id);
        if(!is_null($request->image)){
            $category->image = $request->image;
        }
        $category->name = $request->name;
        $category->save();
         
        $success['category']=new ProductCategoryResource($category);
        $success['status']= 200;    

        return $this->sendResponse($success,'تم تعديل التصنيف بنجاح','Category updated Successfully');
    }

    public function status($status, $id)
    {
        $category = ProductCategory::find($id);
       
        if(is_null($category)){
            return $this->sendError('التصنيف غير موجود','Category not Found!',404);
        }
        if($status == 'delete'){
           
            $category->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف التصنيف بنجاح','Category deleted successfully');
        
        }
        elseif($status == 'activate'){
           
            $category->active = 1;
            $category->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل التصنيف بنجاح','Category activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $category->active = 0;
            $category->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل التصنيف بنجاح','Category deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
        
    }


}