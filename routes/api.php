<?php

use App\Http\Middleware\ThrottleRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminDashboard\CustomerController;
use App\Http\Controllers\API\PasswordResetController;
use App\Http\Controllers\API\AdminDashboard\DeliveryController;
use App\Http\Controllers\API\AdminDashboard\ProviderController;
use App\Http\Controllers\API\AdminDashboard\JoinOrderController;


    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');

    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::get('logout', 'logout');
    });

    Route::group([      
        'middleware' => 'api',    
        'prefix' => 'password'
    ], function () {    
        Route::controller(PasswordResetController::class)->group(function () {
        Route::post('create', 'create')/*->middleware(ThrottleRequests::class)*/;
        Route::get('find/{token}', 'find');
        Route::post('verify', 'verifyContact');
        Route::post('reset', 'reset');
    });
});
    

    Route::prefix("admin-dashboard")->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('customers', 'index');
            Route::get('customer/{id}', 'details');
            Route::get('{status}-customer/{id}', 'status');
        });

        Route::controller(DeliveryController::class)->group(function () {
            Route::get('deliveries', 'index');
            Route::get('delivery/{id}', 'details');
            Route::get('{status}-delivery/{id}', 'status');
        });

        Route::controller(ProviderController::class)->group(function () {
            Route::get('providers', 'index');
            Route::get('provider/{id}', 'details');
            Route::get('{status}-provider/{id}', 'status');
        });

        Route::controller(JoinOrderController::class)->group(function () {
            Route::get('join-orders', 'index');
            Route::get('join-order/{id}', 'details');
            Route::get('{status}-join-order/{id}', 'status');
        });

    })->middleware('auth:api');
