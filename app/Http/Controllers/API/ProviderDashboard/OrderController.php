<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Provider;
use Illuminate\Http\Request;
use Validator;
use App\Http\Resources\Order as OrderResource;
use App\Http\Controllers\API\BaseController as BaseController;


class OrderController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $orders = Order::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $orders = Order::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $orders->lastPage();
        }

        $success['orders']=OrderResource::collection($orders);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع الطلبات بنجاح','Orders returned successfully');
    }

    
   

}