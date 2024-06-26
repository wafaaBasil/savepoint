<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests extends \Illuminate\Routing\Middleware\ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        // $original = parent::handle($request, $next, $maxAttempts, $decayMinutes);
       //dd($request->path);
       if($request->path() == 'api/send-verify-message' || $request->path() == 'api/password/create'){
        if (RateLimiter::tooManyAttempts($request->path().'.'.$request->input('phonenumber'), 3)) {
            //dd(RateLimiter::availableIn($request->input('phonenumber')));
            $response = [
        'success' =>false ,
        'message'=>['en' => 'You have exceeded the limit. Please try again in 24 hours.', 'ar' => 'لقد تجاوزت الحد المسموح الرجاء المحاولة بعد 24 ساعة']

    ];
        return response()->json($response,429);
        }else{
        RateLimiter::hit($request->path().'.'.$request->input('phonenumber'), 86400);
        }
        
       }

        if($request->path() == 'api/celebrity/profile/send-verify-message' || $request->path() == 'api/user/profile/send-verify-message'){
            $user = Auth::user();
        if (RateLimiter::tooManyAttempts($request->path().'.'.$user->phonenumber, 3)) {
            //dd(RateLimiter::availableIn($request->input('phonenumber')));
            $response = [
        'success' =>false ,
        'message'=>['en' => 'You have exceeded the limit. Please try again in 24 hours.', 'ar' => 'لقد تجاوزت الحد المسموح الرجاء المحاولة بعد 24 ساعة']

    ];
        return response()->json($response,429);
        }else{
        RateLimiter::hit($request->path().'.'.$user->phonenumber, 86400);
        }
        
       }
        
        return $next($request);
    }
}
