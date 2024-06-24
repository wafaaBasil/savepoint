<?php

namespace App\Http\Controllers\API\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use App\Http\Resources\Delivery as DeliveryResource;
use App\Http\Controllers\API\BaseController as BaseController;


class DeliveryController extends BaseController
{
   
    
    public function index()
    {
       $users = User::where('user_type','delivery')->orderBy('created_at','desc')->paginate(10);
        
        $success['deliveries']=DeliveryResource::collection($users);
        $success['page_count'] = $users->lastPage();
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المناديب بنجاح','Deliveries returned successfully');
    }

    public function details($id)
    {
       $user = User::find($id);
        
        $success['customers']=new DeliveryResource($user);
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع المندوب بنجاح','Delivery returned successfully');
    }
    public function delete($id)
    {
        $user = User::find($id);
       
        if(is_null($user)){
            return $this->sendError('المندوب غير موجود','Delivery not Found!',404);
        }

        $user->delivery->delete();
        $user->delete();
        
        $success['status']= 200;

        return $this->sendResponse($success,'تم حذف المندوب بنجاح','Delivery deleted successfully');
    }

    public function deactive($id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return $this->sendError('المندوب غير موجود','Delivery not Found!',404);
        }
        $user->delivery->active = 0;
        $user->active = 0;
        $user->delivery->save();
        $user->save();
        
        $success['status']= 200;

        return $this->sendResponse($success,'تم تعطيل المندوب بنجاح','Delivery deactivated successfully');
    }

}