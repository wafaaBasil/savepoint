<?php

namespace App\Http\Controllers\API\ProviderDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Order as OrderResource;
use App\Http\Controllers\API\BaseController as BaseController;


class CustomerController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $users = User::where('user_type','customer')->whereHas('customer_orders.provider', function ($query){
                $query->where('id', auth()->user()->provider_id);
            })->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $users = User::where('user_type','customer')->whereHas('customer_orders.provider', function ($query){
                $query->where('id', auth()->user()->provider_id);
            })->orderBy('created_at','desc')->paginate(10);
            $page_count = $users->lastPage();
        }
       
        
        $success['customers']=UserResource::collection($users);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع العملاء بنجاح','Customers returned successfully');
    }

    public function details(Request $request, $id)
    {
       $user = User::find($id);
       
       if(is_null($user)|| $user->user_type != 'customer' || is_null($user->whereHas('customer_orders.provider', function ($query){
        $query->where('id', auth()->user()->provider_id);
    }))){
            return $this->sendError('العميل غير موجود','Customer not Found!',404);
        }

       if($request->page == null){
            $orders = $user->customer_orders()->where('provider_id',auth()->user()->provider_id)->get();
            $page_count = null;
        }else{
            $orders = $user->customer_orders()->where('provider_id',auth()->user()->provider_id)->paginate(10);
            $page_count = $orders->lastPage();
        }
            
        //dd($orders);
        //$success['customer']=new UserResource($user);
        $success['orders']=OrderResource::collection($orders);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع العميل بنجاح','Customer returned successfully');
    }
    


}