<?php

namespace App\Http\Controllers\API\ProviderDashboard;

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
            $ratings = Rating::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->get();
            $page_count = null;
        }else{
            $ratings = Rating::where('provider_id',auth()->user()->provider_id)->orderBy('created_at','desc')->paginate(10);
            $page_count = $ratings->lastPage();
        }

        $success['ratings']=RatingResource::collection($ratings);
        $success['page_count'] = $page_count;
        $success['status']= 200;

         return $this->sendResponse($success,'تم ارجاع التقييمات بنجاح','Ratings returned successfully');
    }
    

}