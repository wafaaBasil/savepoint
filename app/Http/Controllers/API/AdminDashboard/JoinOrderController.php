<?php

namespace App\Http\Controllers\API\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Provider as ProviderResource;
use App\Http\Controllers\API\BaseController as BaseController;


class JoinOrderController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $providers = Provider::where('status','new')->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $providers = Provider::where('status','new')->orderBy('created_at','desc')->paginate(10);
            $page_count = $providers->lastPage();
        }

        $success['providers']=ProviderResource::collection($providers);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع طلبات الانضمام بنجاح','Join orders returned successfully');
    }

    public function details(Request $request, $id)
    {
       $provider = Provider::find($id);
       
       if(is_null($provider) || $provider->status != 'new'){
            return $this->sendError('المزود غير موجود','Provider not Found!',404);
        }

        $success['provider']=new ProviderResource($provider);
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المزود بنجاح','Provider returned successfully');
    }
    public function status($status, $id)
    {
        $provider = Provider::find($id);
        if(is_null($provider) || $provider->status != 'new'){
            return $this->sendError('المزود غير موجود','Provider not Found!',404);
        }

        if($status == 'accept'){
           
            $provider->status = 'accept';
            $provider->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم قبول المزود بنجاح','Provider accepted successfully');
        
        }elseif($status == 'reject'){
           
            $provider->status = 'reject';
            $provider->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم رفض المزود بنجاح','Provider rejected successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
    }

}