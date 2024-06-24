<?php

namespace App\Http\Controllers\API\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\Delivery as DeliveryResource;
use App\Http\Controllers\API\BaseController as BaseController;


class DeliveryController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $users = User::where('user_type','delivery')->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $users = User::where('user_type','delivery')->orderBy('created_at','desc')->paginate(10);
            $page_count = $users->lastPage();
        }

        $success['deliveries']=DeliveryResource::collection($users);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المناديب بنجاح','Deliveries returned successfully');
    }

    public function details(Request $request, $id)
    {
       $user = User::find($id);
       
       if(is_null($user)|| $user->user_type != 'delivery'){
            return $this->sendError('المندوب غير موجود','Delivery not Found!',404);
        }

       if($request->page == null){
            $orders = $user->delivery_orders;
            $page_count = null;
        }else{
            $orders = $user->delivery_orders()->paginate(10);
            $page_count = $orders->lastPage();
        }
        
        $success['delivery']=new DeliveryResource($user);
        $success['orders']=OrderResource::collection($orders);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المندوب بنجاح','Delivery returned successfully');
    }
    public function status($id, $status)
    {
        $user = User::find($id);
       
        if(is_null($user)|| $user->user_type != 'delivery'){
            return $this->sendError('المندوب غير موجود','Delivery not Found!',404);
        }

        if($status == 'delete'){
           
            $user->delete();
            $success['status']= 200;
            return $this->sendResponse($success,'تم حذف المندوب بنجاح','Delivery deleted successfully');
        
        }elseif($status == 'activate'){
           
            $user->active = 1;
            $user->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل المندوب بنجاح','Delivery activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $user->active = 0;
            $user->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل المندوب بنجاح','Delivery deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
    }

}