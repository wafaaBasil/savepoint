<?php

namespace App\Http\Controllers\API\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\Provider as ProviderResource;
use App\Http\Controllers\API\BaseController as BaseController;


class ProviderController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $providers = Provider::where('status','accept')->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $providers = Provider::where('status','accept')->orderBy('created_at','desc')->paginate(10);
            $page_count = $providers->lastPage();
        }

        $success['providers']=ProviderResource::collection($providers);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المزودين بنجاح','Providers returned successfully');
    }

    public function details(Request $request, $id)
    {
       $provider = Provider::find($id);
       
       if(is_null($provider) || $provider->status != 'accept'){
            return $this->sendError('المزود غير موجود','Provider not Found!',404);
        }

       if($request->page == null){
            $orders = $provider->orders;
            $page_count = null;
        }else{
            $orders = $provider->orders()->paginate(10);
            $page_count = $orders->lastPage();
        }
        
        //$success['provider']=new ProviderResource($provider);
        $success['orders']=OrderResource::collection($orders);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المزود بنجاح','Provider returned successfully');
    }
    public function status($status, $id)
    {
        $provider = Provider::find($id);
        if(is_null($provider) || $provider->status != 'accept'){
            return $this->sendError('المزود غير موجود','Provider not Found!',404);
        }

        if($status == 'delete'){
           
            $provider->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف المزود بنجاح','Provider deleted successfully');
        
        }elseif($status == 'activate'){
           
            $provider->active = 1;
            $provider->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل المزود بنجاح','Provider activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $provider->active = 0;
            $provider->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل المزود بنجاح','Provider deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
    }

}