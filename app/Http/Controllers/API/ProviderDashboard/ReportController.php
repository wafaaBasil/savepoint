<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Order;
use App\Models\Provider;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Branch as BranchResource;
use Illuminate\Http\Request;
use App\Models\Rating;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;


class ReportController extends BaseController
{
    public function index(Request $request)
    {
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


        $currentYear = Carbon::now()->year;

        $success['january']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '1')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['february']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '2')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['march']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '3')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['april']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '4')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['may']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '5')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['june']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '6')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['july']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '7')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['august']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '8')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['september']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '9')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['october']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '10')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['november']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '11')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['december']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '12')->whereYear('created_at', $currentYear)->sum('order_price');

        
        $success['customers']= UserResource::collection(User::where('user_type','customer')->whereHas('customer_orders.provider', function ($query){
            $query->where('id', auth("sanctum")->user()->provider_id)->orderBy('order_price','desc');
        })->take(5)->get());

        $success['branches']= BranchResource::collection(Branch::whereHas('orders.provider', function ($query){
            $query->where('id', auth("sanctum")->user()->provider_id)->orderBy('order_price','desc');
        })->take(5)->get());

        

        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع التقارير بنجاح','Reports returned successfully');
    }

    public function financial(Request $request)
    {
        $success['currently_available_balance']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->sum('order_price');
        $success['profits_total']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->sum('order_price');
        $success['revenues_total']=1111;
        $success['expenses_total']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->sum('order_price');

        $currentYear = Carbon::now()->year;

        $success['january']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '1')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['february']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '2')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['march']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '3')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['april']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '4')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['may']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '5')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['june']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '6')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['july']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '7')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['august']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '8')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['september']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '9')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['october']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '10')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['november']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '11')->whereYear('created_at', $currentYear)->sum('order_price');
        $success['december']=Order::where('provider_id',auth("sanctum")->user()->provider_id)->whereMonth('created_at', '12')->whereYear('created_at', $currentYear)->sum('order_price');

        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المالية بنجاح','financial returned successfully');
    }


}