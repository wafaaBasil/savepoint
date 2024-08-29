<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Rating;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;


class ReportController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $ratings = Rating::where('provider_id',auth("sanctum")->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $ratings = Rating::where('provider_id',auth("sanctum")->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $ratings->lastPage();
        }

        $success['customers_total']=User::where('user_type','customer')->whereHas('customer_orders.provider', function ($query){
            $query->where('id', auth("sanctum")->user()->provider_id);
        })->count();
        $success['profits_total']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->sum('order_price');
        $success['orders_total']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->count();
        $success['visits_total']=1111;

        $success['revenues_total']=1111;
        $success['expenses_total']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->sum('order_price');
        

        $provider = Provider::find(auth("sanctum")->user()->provider_id);
        $success['new_order_count']=$provider->orders->where('status','جديد')->count();
        $success['deliver_order_count']=$provider->orders->where('status','التوصيل')->count();
        $success['pending_order_count']=$provider->orders->where('status','جاري التجهيز')->count();
        $success['completed_order_count']=$provider->orders->where('status','تم التوصيل')->count();
        $success['deliver_order_monthly']=$provider->deliver_order_monthly();
        $success['pending_order_monthly']=$provider->pending_order_monthly();
        $success['completed_order_monthly']=$provider->completed_order_monthly();
        $success['deliver_order_percent']=$provider->deliver_order_percent();
        $success['pending_order_percent']=$provider->pending_order_percent();
        $success['completed_order_percent']=$provider->completed_order_percent();

        $success['customers']= User::where('user_type','customer')->whereHas('customer_orders.provider', function ($query){
            $query->where('id', auth("sanctum")->user()->provider_id);
        })->orderBy('customer_orders.order_price','desc')->take(5)->get();

        $success['branches']= Branch::whereHas('orders.provider', function ($query){
            $query->where('id', auth("sanctum")->user()->provider_id);
        })->orderBy('orders.order_price','desc')->take(5)->get();

        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع التقارير بنجاح','Reports returned successfully');
    }


}