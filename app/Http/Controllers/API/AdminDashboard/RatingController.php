<?php

namespace App\Http\Controllers\API\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use Validator;
use App\Http\Resources\Rating as RatingResource;
use App\Http\Controllers\API\BaseController as BaseController;


class RatingController extends BaseController
{
    public function index(Request $request)
    {
        if($request->page == null){
            $ratings = Rating::where('order_id',null)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $ratings = Rating::where('order_id',null)->orderBy('created_at','desc')->paginate(10);
            $page_count = $ratings->lastPage();
        }

        $success['ratings']=RatingResource::collection($ratings);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع التقييمات بنجاح','Ratings returned successfully');
    }
    public function status($status, $id)
    {
        $rating = Rating::find($id);
        if(is_null($rating)|| $rating->order_id != null){
            return $this->sendError('التقييم غير موجود','Rating not Found!',404);
        }

        if($status == 'activate'){
           
            $rating->active = 1;
            $rating->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تفعيل التقييم بنجاح','Rating activated successfully');
        
        }elseif($status == 'deactivate'){
           
            $rating->active = 0;
            $rating->save();
            $success['status']= 200;
            return $this->sendResponse($success,'تم تعطيل التقييم بنجاح','Rating deactivated successfully');
        
        }else{
            
            return $this->sendError('الصفحة غير موجودة','Page not Found!',404);

        }
        
    }

}