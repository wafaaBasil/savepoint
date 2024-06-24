<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($result , $message, $message_en)
   {
    $response = [
        'success' =>true ,
        'data'=>$result,
        'message'=>['en' => $message_en, 'ar' => $message]

    ];

     
    return response()->json($response , 200);
     
   }

   public function sendError($error ,$error_en , /*$errorMessages=[],*/ $code)
   {
       
  
    $response = [
        'success' =>false ,
        'message'=>['en' => $error_en, 'ar' => $error]

    ];

    /*if (!empty($errorMessages)) {
        # code...
        $response['data']= $errorMessages;
    }else{*/
        $response['data']= null;
    //}
         
        return response()->json($response,$code);
        
   }

   
   public function sendValidationError($error ,$error_en , $errorMessages=[], $code=422)
   {
       
foreach($error->keys() as $fieldKey){
    $errors[] = $error->first($fieldKey);
  }

    
foreach($error_en->keys() as $fieldKey){
    $errors_en[] = $error_en->first($fieldKey);
  }
    $response = [
        'success' =>false ,
        'message'=>['en' => $errors_en, 'ar' => $errors]

    ];

    if (!empty($errorMessages)) {
        # code...
        $response['data']= $errorMessages;
    }else{
        $response['data']= null;
    }
         
        return response()->json($response,$code);
        
   }
}
