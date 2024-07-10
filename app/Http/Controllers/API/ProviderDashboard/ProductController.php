<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use App\Http\Resources\Product as ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;


class ProductController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $products = Product::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $products = Product::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $products->lastPage();
        }
       
        
        $success['products']=ProductResource::collection($products);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المنتجات بنجاح','Products returned successfully');
    }

   
    public function create(Request $request)
    {
        $input = $request->all();
    
        $validator_en =  Validator::make($input ,[
            'images' => 'required',
            'images.*.image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*.main' => 'boolean|required',
            'options.*.name' => 'string|required|max:255',
            'options.*.content' => 'string|nullable',
            'options.*.price' => 'nullable',
            'enhancements.*' => 'numeric|required|exists:enhancements,id',
            'name' => 'string|required|max:255',
            'name_ar' => 'string|required|max:255',
            'details' => 'string|required',
            'categories.*' => 'numeric|required|exists:product_categories,id',
            'earned_points' => 'numeric|required',
            'purchase_points' => 'numeric|required',
            'price' => 'required',
            'offer_price' => 'nullable',
            'calories'=>'string|nullable',
        ],[
            'images.required' => 'A images is required.',
            'images.*.image.required' => 'A image is required.',
            'images.*.image.image' => 'A image must be an image.',
            'images.*.image.mimes' => 'A image must be a file of type:jpeg,png,jpg,gif,svg.',
            'images.*.image.max' => 'A image must not be greater than 2048 kilobytes.',
            'images.*.main.required' => 'A main is required.',
            'images.*.main.boolean' => 'A main must be a boolean.',
            'options.*.name.required' => 'A name is required.',
            'options.*.name.string' => 'A name must be a string.',
            'options.*.name.max' => 'A name must not be greater than 255.',
            'options.*.content.string' => 'A content must be a string.',
            'enhancements.required' => 'A enhancements is required.',
            'enhancements.*.required' => 'A enhancements is required.',
            'enhancements.*.numeric' => 'A enhancements must be a number.',
            'enhancements.*.exists' => 'A enhancements not valid.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
            'name_ar.required' => 'A name (ar) is required.',
            'name_ar.max' => 'A name (ar) must not be greater than 255.',
            'name_ar.string' => 'A name (ar) must be a string.',
            'details.required' => 'A details is required.',
            'details.string' => 'A details must be a string.',
            'categories.required' => 'A categories is required.',
            'categories.*.required' => 'A categories is required.',
            'categories.*.numeric' => 'A categories must be a number.',
            'categories.*.exists' => 'A categories not valid.',
            'earned_points.required' => 'A earned points is required.',
            'earned_points.numeric' => 'A earned points must be a number.',
            'purchase_points.required' => 'A purchase points is required.',
            'purchase_points.numeric' => 'A purchase points must be a number.',
            'price.required' => 'A price is required.',
            'calories.string' => 'A calories must be a string.',
        ]);

        $validator =  Validator::make($input ,[
            'images' => 'required',
            'images.*.image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*.main' => 'boolean|required',
            'options.*.name' => 'string|required|max:255',
            'options.*.content' => 'string|nullable',
            'options.*.price' => 'nullable',
            'enhancements.*' => 'numeric|required|exists:enhancements,id',
            'name' => 'string|required|max:255',
            'name_ar' => 'string|required|max:255',
            'details' => 'string|required',
            'categories.*' => 'numeric|required|exists:product_categories,id',
            'earned_points' => 'numeric|required',
            'purchase_points' => 'numeric|required',
            'price' => 'required',
            'offer_price' => 'nullable',
            'calories'=>'string|nullable',
        ],[
            'images.required' => 'حقل الصور مطلوب.',
            'images.*.image.required' => 'حقل الصورة مطلوب.',
            'images.*.image.image' => 'حقل الصورة يجب ان يكون صورة.',
            'images.*.image.mimes' => 'يجب أن يكون حقل الصورة ملفًا من نوع:jpeg,png,jpg,gif,svg.',
            'images.*.image.max' => 'يجب أن لا يتجاوز حجم الملف 2048 كيلوبايت .',
            'images.*.main.required' => 'حقل الرئيسية مطلوب.',
            'images.*.main.boolean' => 'حقل الرئيسية يجب ان يكون boolean.',
            'options.*.name.required' => 'حقل الاسم مطلوب.',
            'options.*.name.string' => 'حقل الاسم يجب ان يكون نص.',
            'options.*.name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'options.*.content.string' => 'حقل المحتوى يجب ان يكون نص.',
            'enhancements.required' => 'حقل الاضافات مطلوب.',
            'enhancements.*.required' => 'حقل الاضافات مطلوب.',
            'enhancements.*.numeric' => 'حقل الاضافات يجب ان يكون رقم.',
            'enhancements.*.exists' => 'حقل الاضافات غير صحيح.',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'حقل الاسم يجب ان يكون نص.',
            'name_ar.required' => 'حقل الاسم مطلوب.',
            'name_ar.max' => 'يجب أن لا يتجاوز طول الاسم 255.',
            'name_ar.string' => 'حقل الاسم يجب ان يكون نص.',
            'details.required' => 'حقل المحتوى مطلوب.',
            'details.string' => 'حقل الاسم يجب ان يكون نص.',
            'categories.required' => 'حقل الاضافات مطلوب.',
            'categories.*.required' => 'حقل الاضافات مطلوب.',
            'categories.*.numeric' => 'حقل الاضافات يجب ان يكون رقم.',
            'categories.*.exists' => 'حقل الاضافات غير صحيح.',
            'earned_points.required' => 'حقل النقاط التي تحصل عليها مطلوب.',
            'earned_points.numeric' => 'حقل النقاط التي تحصل عليها يجب ان يكون رقم.',
            'purchase_points.required' => 'حقل النقاط اللازم دفعها مطلوب.',
            'purchase_points.numeric' => 'حقل النقاط اللازم دفعها يجب ان يكون رقم.',
            'price.required' => 'حقل السعر مطلوب.',
            'calories.string' => 'حقل السعرات الحرارية يجب ان يكون نص.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        $product = new Product();
        $product->name = $request->name;
        $product->name_ar = $request->name_ar;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->details = $request->details;
        $product->calories = $request->calories;
        $product->earned_points = $request->earned_points;
        $product->purchase_points = $request->purchase_points;
        $product->provider_id = auth()->user()->provider_id;
        $product->save();
        $product->categories()->attach($request->categories);
        $product->enhancements()->attach($request->enhancements);

        foreach($request->images as $image){
            $new_image = new ProductImage();
            $new_image->image = $image['image'];
            $new_image->main = $image['main'];
            $new_image->product_id = $product->id;
            $new_image->save();
        }

        foreach($request->options as $option){
            $new_option = new ProductOption();
            $new_option->name = $option['name'];
            $new_option->content = $option['content'];
            $new_option->price = $option['price'];
            $new_option->product_id = $product->id;
            $new_option->save();
        }
        
         
        $success['product']=new ProductResource(Product::find($product->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم اضافة منتج جديد بنجاح','Product created Successfully');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
    
        $validator_en =  Validator::make($input ,[
            'images' => 'required',
            'images.*.id' => 'numeric|nullable',
            'images.*.image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*.main' => 'boolean|required',
            'options' => 'nullable',
            'options.*.id' => 'numeric|nullable',
            'options.*.name' => 'string|required|max:255',
            'options.*.content' => 'string|nullable',
            'options.*.price' => 'nullable',
            'enhancements' => 'required',
            'enhancements.*' => 'numeric|required|exists:enhancements,id',
            'name' => 'string|required|max:255',
            'name_ar' => 'string|required|max:255',
            'details' => 'string|required',
            'categories' => 'required',
            'categories.*' => 'numeric|required|exists:product_categories,id',
            'earned_points' => 'numeric|required',
            'purchase_points' => 'numeric|required',
            'price' => 'required',
            'offer_price' => 'nullable',
            'calories'=>'string|nullable',
        ],[
            'images.required' => 'A images is required.',
            'images.*.image.image' => 'A image must be an image.',
            'images.*.image.mimes' => 'A image must be a file of type:jpeg,png,jpg,gif,svg.',
            'images.*.image.max' => 'A image must not be greater than 2048 kilobytes.',
            'images.*.main.required' => 'A main is required.',
            'images.*.main.boolean' => 'A main must be a boolean.',
            'options.required' => 'A options is required.',
            'options.*.name.required' => 'A name is required.',
            'options.*.name.string' => 'A name must be a string.',
            'options.*.name.max' => 'A name must not be greater than 255.',
            'options.*.content.required' => 'A content is required.',
            'options.*.content.string' => 'A content must be a string.',
            'options.*.price.required' => 'A price is required.',
            'enhancements.required' => 'A enhancements is required.',
            'enhancements.*.required' => 'A enhancements is required.',
            'enhancements.*.numeric' => 'A enhancements must be a number.',
            'enhancements.*.exists' => 'A enhancements not valid.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
            'name_ar.required' => 'A name (ar) is required.',
            'name_ar.max' => 'A name (ar) must not be greater than 255.',
            'name_ar.string' => 'A name (ar) must be a string.',
            'details.required' => 'A details is required.',
            'details.string' => 'A details must be a string.',
            'categories.required' => 'A categories is required.',
            'categories.*.required' => 'A categories is required.',
            'categories.*.numeric' => 'A categories must be a number.',
            'categories.*.exists' => 'A categories not valid.',
            'earned_points.required' => 'A earned points is required.',
            'earned_points.numeric' => 'A earned points must be a number.',
            'purchase_points.required' => 'A purchase points is required.',
            'purchase_points.numeric' => 'A purchase points must be a number.',
            'price.required' => 'A price is required.',
            'calories.string' => 'A calories must be a string.',
        ]);

        $validator =  Validator::make($input ,[
            'images' => 'required',
            'images.*.id' => 'numeric|nullable',
            'images.*.image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*.main' => 'boolean|required',
            'options.*.id' => 'numeric|nullable',
            'options.*.name' => 'string|required|max:255',
            'options.*.content' => 'string|nullable',
            'options.*.price' => 'nullable',
            'enhancements.*' => 'numeric|required|exists:enhancements,id',
            'name' => 'string|required|max:255',
            'name_ar' => 'string|required|max:255',
            'details' => 'string|required',
            'categories.*' => 'numeric|required|exists:product_categories,id',
            'earned_points' => 'numeric|required',
            'purchase_points' => 'numeric|required',
            'price' => 'required',
            'offer_price' => 'nullable',
            'calories'=>'string|nullable',
        ],[
            'images.required' => 'حقل الصور مطلوب.',
            'images.*.image.image' => 'حقل الصورة يجب ان يكون صورة.',
            'images.*.image.mimes' => 'يجب أن يكون حقل الصورة ملفًا من نوع:jpeg,png,jpg,gif,svg.',
            'images.*.image.max' => 'يجب أن لا يتجاوز حجم الملف 2048 كيلوبايت .',
            'images.*.main.required' => 'حقل الرئيسية مطلوب.',
            'images.*.main.boolean' => 'حقل الرئيسية يجب ان يكون boolean.',
            'options.required' => 'حقل الخيارات مطلوب.',
            'options.*.name.required' => 'حقل الاسم مطلوب.',
            'options.*.name.string' => 'حقل الاسم يجب ان يكون نص.',
            'options.*.name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'options.*.content.required' => 'حقل المحتوى مطلوب.',
            'options.*.content.string' => 'حقل المحتوى يجب ان يكون نص.',
            'options.*.price.required' => 'حقل السعر مطلوب.',
            'enhancements.required' => 'حقل الاضافات مطلوب.',
            'enhancements.*.required' => 'حقل الاضافات مطلوب.',
            'enhancements.*.numeric' => 'حقل الاضافات يجب ان يكون رقم.',
            'enhancements.*.exists' => 'حقل الاضافات غير صحيح.',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'حقل الاسم يجب ان يكون نص.',
            'name_ar.required' => 'حقل الاسم مطلوب.',
            'name_ar.max' => 'يجب أن لا يتجاوز طول الاسم 255.',
            'name_ar.string' => 'حقل الاسم يجب ان يكون نص.',
            'details.required' => 'حقل المحتوى مطلوب.',
            'details.string' => 'حقل الاسم يجب ان يكون نص.',
            'categories.required' => 'حقل الاضافات مطلوب.',
            'categories.*.required' => 'حقل الاضافات مطلوب.',
            'categories.*.numeric' => 'حقل الاضافات يجب ان يكون رقم.',
            'categories.*.exists' => 'حقل الاضافات غير صحيح.',
            'earned_points.required' => 'حقل النقاط التي تحصل عليها مطلوب.',
            'earned_points.numeric' => 'حقل النقاط التي تحصل عليها يجب ان يكون رقم.',
            'purchase_points.required' => 'حقل النقاط اللازم دفعها مطلوب.',
            'purchase_points.numeric' => 'حقل النقاط اللازم دفعها يجب ان يكون رقم.',
            'price.required' => 'حقل السعر مطلوب.',
            'calories.string' => 'حقل السعرات الحرارية يجب ان يكون نص.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        $product = Product::find($id);
        $product->name = $request->name;
        $product->name_ar = $request->name_ar;
        $product->details = $request->details;
        $product->price = $request->price;
        $product->offer_price = $request->offer_price;
        $product->calories = $request->calories;
        $product->earned_points = $request->earned_points;
        $product->purchase_points = $request->purchase_points;
        $product->provider_id = auth()->user()->provider_id;
        $product->save();
        $product->categories()->sync($request->categories);
        $product->enhancements()->sync($request->enhancements);

        $images_id = ProductImage::where('product_id', $id)->pluck('id')->toArray();
    foreach ($images_id as $imgid) {
      if (!(in_array($imgid, array_column($request->images, 'id')))) {
        ProductImage::find($imgid)->delete();
      }
    }

    foreach ($request->images as $image) {
        if(isset($image['image'])){
            ProductImage::updateOrCreate([
                'id' => $image['id'],
              ], [
                'image' => $image['image'],
                'main' => $image['main'],
                'product_id' => $product->id
              ]);
        }else{
            ProductImage::updateOrCreate([
                'id' => $image['id'],
              ], [
                'main' => $image['main'],
                'product_id' => $product->id
              ]);
        }
      
    }
    

    $options_id = ProductOption::where('product_id', $id)->pluck('id')->toArray();
    foreach ($options_id as $oid) {
      if (!(in_array($oid, array_column($request->options, 'id')))) {
        ProductOption::find($oid)->delete();
      }
    }

    foreach ($request->options as $option) {
        ProductOption::updateOrCreate([
        'id' => $option['id'],
      ], [
        'name' => $option['name'],
        'content' => $option['content'],
        'price' => $option['price'],
        'product_id' => $product->id
      ]);
    }
        
         
        $success['product']=new ProductResource(Product::find($product->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم تعديل منتج بنجاح','Product updated Successfully');
    }

    public function status($status, $id)
    {
        $product = Product::find($id);
       
        if(is_null($product)){
            return $this->sendError('المنتج غير موجود','Product not Found!',404);
        }
        if($status == 'delete'){
           $product->images()->delete();
           $product->options()->delete();
           $product->enhancements()->delete();
            $product->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف المنتج بنجاح','Product deleted successfully');
        
        }
        elseif($status == 'activate'){
           
            $product->active = 1;
            $product->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل المنتج بنجاح','Product activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $product->active = 0;
            $product->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل المنتج بنجاح','Product deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
        
    }


}