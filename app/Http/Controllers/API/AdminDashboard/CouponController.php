<?php

namespace App\Http\Controllers\API\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Coupon as CouponResource;
use App\Http\Controllers\API\BaseController as BaseController;


class CouponController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $coupons = Coupon::orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $coupons = Coupon::orderBy('created_at','desc')->paginate(10);
            $page_count = $coupons->lastPage();
        }
       
        
        $success['coupons']=CouponResource::collection($coupons);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع الكوبونات بنجاح','Coupons returned successfully');
    }

    
    public function create(Request $request)
    {
        $input = $request->all();
        
        $validator_en =  Validator::make($input ,[
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'string|required|unique:coupons,name',
            'type' => 'required|in:percent,fixed,product',
            'discount' => 'numeric|required',
            'top_discount' => 'numeric|required_if:type,==,percent',
            'provider_id' => 'numeric|required',
            'product_id' => 'numeric|required_if:type,==,product',
            'end_date' => 'required|date',
            //'num_of_use' => 'numeric|required',
            'active' => 'required|in:0,1',
        ],[
            'image.required' => 'A image is required.',
            'image.image' => 'A image must be an image.',
            'image.mimes' => 'A image must be a file of type:jpeg,png,jpg,gif,svg.',
            'image.max' => 'A image must not be greater than 2048 kilobytes.',
            'name.required' => 'A name is required.',
            'name.unique' => 'A name has already been taken.',
            'name.string' => 'A name must be a string.',
            'type.required' => 'A type is required.',
            'type.in' => 'The selected type is invalid.',
            'discount.required' => 'A discount is required.',
            'discount.numeric' => 'A discount ust be a number.',
            'provider_id.required' => 'A provider is required.',
            'provider_id.numeric' => 'A provider ust be a number.',
            'top_discount.required_if' => 'A top discount is required when type is percent.',
            'top_discount.numeric' => 'A top discount ust be a number.',
            'product_id.required_if' => 'A product is required when type is product.',
            'product_id.numeric' => 'A product ust be a number.',
            'end_date.required' => 'A end_date is required.',
            'end_date.date' => 'A end_date must be a date.',
            //'num_of_use.required' => 'A num_of_use is required.',
            //'num_of_use.numeric' => 'A num_of_use must be a number.',
            'active.required' => 'A active is required.',
            'active.in' => 'The selected active is invalid.',
        ]);

        $validator =  Validator::make($input ,[
            'image' => 'image|required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'string|required|unique:coupons,name',
            'type' => 'required|in:percent,fixed',
            'discount' => 'numeric|required',
            'top_discount' => 'numeric|required_if:type,==,percent',
            'end_date' => 'required|date',
            //'num_of_use' => 'numeric|required',
            'active' => 'required|in:0,1',
        ],[
            'image.required' => 'حقل الصورة مطلوب.',
            'image.image' => 'حقل الصورة يجب ان يكون صورة.',
            'image.mimes' => 'يجب أن يكون حقل الصورة ملفًا من نوع:jpeg,png,jpg,gif,svg.',
            'image.max' => 'يجب أن لا يتجاوز حجم الملف 2048 كيلوبايت .',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.unique' => 'حقل الاسم مستخدم من قبل.',
            'name.string' => 'يجب ان يكون حقل الاسم نص.',
            'type.required' => 'حفل النوع مطلوب.',
            'type.in' => 'قيمة حقل النوع غير صحيح.',
            'discount.required' => 'حقل مبلغ الخصم مطلوب.',
            'discount.numeric' => 'يجب ان يكون حقل الخصم رقم.',
            'top_discount.required_if' => 'حقل الحد الاقصى للخصم مطلوب اذا كان حقل النوع percent.',
            'top_discount.numeric' => 'يجب ان يكون حقل الحد الاقصى للخصم رقم.',
            'end_date.required' => 'حقل تاريخ الانتهاء مطلوب.',
            'end_date.date' => 'يجب ان يكون حقل تاريخ الانتهاء تاريخ.',
            //'num_of_use.required' => 'حقل عدد مرات الاستخدام مطلوب.',
           // 'num_of_use.numeric' => 'يجب ان يكون حقل عدد مرات الاستخدام رقم.',
            'active.required' => 'حقل التفعيل مطلوب.',
            'active.in' => 'قيمة حقل التفعيل غير صحيح.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        
        $coupon = new Coupon();
        $coupon->image = $request->image;
        $coupon->name = $request->name;
        $coupon->type = $request->type;
        $coupon->discount = $request->discount;
        $coupon->top_discount = $request->top_discount;
        $coupon->end_date = $request->end_date;
        $coupon->provider_id = $request->provider_id;
        $coupon->product_id = $request->product_id;
        $coupon->num_of_use = 1;
        $coupon->active = $request->active;
        $coupon->save();
         
        $success['coupon']=new CouponResource($coupon);
        $success['status']= 200;    

        return $this->sendResponse($success,'تم اضافة كوبون جديد بنجاح','Coupon created Successfully');
    }

    public function status($status, $id)
    {
        $coupon = Coupon::find($id);
       
        if(is_null($coupon)){
            return $this->sendError('الكوبون غير موجود','Coupon not Found!',404);
        }
        if($status == 'delete'){
           
            $coupon->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف الكوبون بنجاح','Coupon deleted successfully');
        
        }
        elseif($status == 'activate'){
           
            $coupon->active = 1;
            $coupon->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل الكوبون بنجاح','Coupon activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $coupon->active = 0;
            $coupon->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل الكوبون بنجاح','Coupon deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
        
    }


}