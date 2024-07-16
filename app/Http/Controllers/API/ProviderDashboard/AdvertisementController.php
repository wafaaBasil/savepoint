<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use Validator;
use App\Http\Resources\Advertisement as AdvertisementResource;
use App\Http\Controllers\API\BaseController as BaseController;


class AdvertisementController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $advertisements = Advertisement::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $advertisements = Advertisement::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $advertisements->lastPage();
        }
       
        
        $success['advertisements']=AdvertisementResource::collection($advertisements);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع الاعلانات بنجاح','Advertisements returned successfully');
    }

   
    public function create(Request $request)
    {
        $input = $request->all();
    
       
        $validator_en =  Validator::make($input ,[
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'string|required|max:255',
            'type' => 'required|in:internal_product,external_link',
            'url' => 'string|required|max:255',
            'start_date' => 'required',
            'num_of_day' => 'numeric|required',
            'details' => 'required|string',
        ],[
            'image.required' => 'A image is required.',
            'image.mimes' => 'A image must be a file of type:jpeg,png,jpg,gif,svg.',
            'image.max' => 'A image must not be greater than 2048 kilobytes.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
            'type.required' => 'A type is required.',
            'type.in' => 'The selected type is invalid.',
            'url.required' => 'A url is required.',
            'url.max' => 'A url must not be greater than 255.',
            'url.string' => 'A url must be a string.',
            'details.required' => 'A details is required.',
            'details.string' => 'A details must be a string.',
            'num_of_day.numeric' => 'A num of day must be a number.',
            'num_of_day.required' => 'A num of day is required.',
            'start_date.required' => 'A start date is required.',
        ]);

        $validator =  Validator::make($input ,[
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'string|required|max:255',
            'type' => 'required|in:internal_product,external_link',
            'url' => 'string|required|max:255',
            'start_date' => 'required',
            'num_of_day' => 'numeric|required',
            'details' => 'required|string',
        ],[
            
            'type.required' => 'حفل النوع مطلوب.',
            'type.in' => 'قيمة حقل النوع غير صحيح.',
            'image.required' => 'حقل الصورة مطلوب.',
            'image.mimes' => 'يجب أن يكون حقل الصورة ملفًا من نوع:jpeg,png,jpg,gif,svg.',
            'image.max' => 'يجب أن لا يتجاوز حجم الملف 2048 كيلوبايت .',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'حقل الاسم يجب ان يكون نص.',
            'url.required' => 'حقل الرابط مطلوب.',
            'url.max' => 'يجب أن لا يتجاوز طول الرابط 255  .',
            'url.string' => 'حقل الرابط يجب ان يكون نص.',
            'details.required' => 'حقل المحتوى مطلوب.',
            'details.string' => 'حقل الاسم يجب ان يكون نص.',
            'start_date.required' => 'حقل تاريخ البداية مطلوب.',
            'num_of_day.required' => 'حقل عدد الايام مطلوب.',
            'num_of_day.numeric' => 'حقل عدد الايام يجب ان يكون رقم.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        $advertisement = new Advertisement();
        $advertisement->image = $request->image;
        $advertisement->type = $request->type;
        $advertisement->name = $request->name;
        $advertisement->url = $request->url;
        $advertisement->details = $request->details;
        $advertisement->start_date = $request->start_date;
        $advertisement->num_of_day = $request->num_of_day;
        $advertisement->provider_id = auth()->user()->provider_id;
        $advertisement->save();

        
         
        $success['advertisement']=new AdvertisementResource(Advertisement::find($advertisement->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم اضافة اعلان جديد بنجاح','Advertisement created Successfully');
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
    
         
        $validator_en =  Validator::make($input ,[
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'string|required|max:255',
            'type' => 'required|in:internal_product,external_link',
            'url' => 'string|required|max:255',
            'start_date' => 'required',
            'num_of_day' => 'numeric|required',
            'details' => 'required|string',
        ],[
            'image.required' => 'A image is required.',
            'image.mimes' => 'A image must be a file of type:jpeg,png,jpg,gif,svg.',
            'image.max' => 'A image must not be greater than 2048 kilobytes.',
            'name.required' => 'A name is required.',
            'name.max' => 'A name must not be greater than 255.',
            'name.string' => 'A name must be a string.',
            'type.required' => 'A type is required.',
            'type.in' => 'The selected type is invalid.',
            'url.required' => 'A url is required.',
            'url.max' => 'A url must not be greater than 255.',
            'url.string' => 'A url must be a string.',
            'details.required' => 'A details is required.',
            'details.string' => 'A details must be a string.',
            'num_of_day.numeric' => 'A num of day must be a number.',
            'num_of_day.required' => 'A num of day is required.',
            'start_date.required' => 'A start date is required.',
        ]);

        $validator =  Validator::make($input ,[
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'string|required|max:255',
            'type' => 'required|in:internal_product,external_link',
            'url' => 'string|required|max:255',
            'start_date' => 'required',
            'num_of_day' => 'numeric|required',
            'details' => 'required|string',
        ],[
            
            'type.required' => 'حفل النوع مطلوب.',
            'type.in' => 'قيمة حقل النوع غير صحيح.',
            'image.required' => 'حقل الصورة مطلوب.',
            'image.mimes' => 'يجب أن يكون حقل الصورة ملفًا من نوع:jpeg,png,jpg,gif,svg.',
            'image.max' => 'يجب أن لا يتجاوز حجم الملف 2048 كيلوبايت .',
            'name.required' => 'حقل الاسم مطلوب.',
            'name.max' => 'يجب أن لا يتجاوز طول الاسم 255  .',
            'name.string' => 'حقل الاسم يجب ان يكون نص.',
            'url.required' => 'حقل الرابط مطلوب.',
            'url.max' => 'يجب أن لا يتجاوز طول الرابط 255  .',
            'url.string' => 'حقل الرابط يجب ان يكون نص.',
            'details.required' => 'حقل المحتوى مطلوب.',
            'details.string' => 'حقل الاسم يجب ان يكون نص.',
            'start_date.required' => 'حقل تاريخ البداية مطلوب.',
            'num_of_day.required' => 'حقل عدد الايام مطلوب.',
            'num_of_day.numeric' => 'حقل عدد الايام يجب ان يكون رقم.',
        ]);

        if ($validator->fails()) 
        {
            return $this->sendValidationError($validator->errors(),$validator_en->errors());
        }
        
        $advertisement = Advertisement::find($id);
        if(!is_null($request->image)){
            $advertisement->image = $request->image;
        }
        $advertisement->type = $request->type;
        $advertisement->name = $request->name;
        $advertisement->url = $request->url;
        $advertisement->details = $request->details;
        $advertisement->start_date = $request->start_date;
        $advertisement->num_of_day = $request->num_of_day;
        $advertisement->provider_id = auth()->user()->provider_id;
        $advertisement->save();
         
        $success['advertisement']=new AdvertisementResource(Advertisement::find($advertisement->id));
        $success['status']= 200;    

        return $this->sendResponse($success,'تم تعديل الاعلان بنجاح','Advertisement updated Successfully');
    }

    public function status($status, $id)
    {
        $advertisement = Advertisement::find($id);
       
        if(is_null($advertisement)){
            return $this->sendError('الاعلان غير موجود','Advertisement not Found!',404);
        }
        if($status == 'delete'){
            $advertisement->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف الاعلان بنجاح','Advertisement deleted successfully');
        
        }
        elseif($status == 'activate'){
           
            $advertisement->active = 1;
            $advertisement->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل الاعلان بنجاح','Advertisement activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $advertisement->active = 0;
            $advertisement->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل الاعلان بنجاح','Advertisement deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
        
    }


}