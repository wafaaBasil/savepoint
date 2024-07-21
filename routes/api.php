<?php

use App\Http\Middleware\ThrottleRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminDashboard\OrderController;
use App\Http\Controllers\API\AdminDashboard\CustomerController;
use App\Http\Controllers\API\PasswordResetController;
use App\Http\Controllers\API\AdminDashboard\DeliveryController;
use App\Http\Controllers\API\AdminDashboard\ProviderController;
use App\Http\Controllers\API\AdminDashboard\JoinOrderController;
use App\Http\Controllers\API\AdminDashboard\RatingController;
use App\Http\Controllers\API\AdminDashboard\CouponController;


    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:api');

    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
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
    

    Route::prefix("admin-dashboard")->middleware('auth:api')->group(function () {
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
           // Route::get('join-order/{id}', 'details');
            Route::get('{status}-join-order/{id}', 'status');
        });
        Route::controller(OrderController::class)->group(function () {
            Route::get('orders', 'index');
           // Route::get('join-order/{id}', 'details');
            Route::get('{status}-order/{id}', 'status');
        });

        Route::controller(RatingController::class)->group(function () {
            Route::get('ratings', 'index');
            Route::get('{status}-rating/{id}', 'status');
        });

        Route::controller(CouponController::class)->group(function () {
            Route::get('coupons', 'index');
            Route::post('coupons/create', 'create');
            Route::post('coupons/update/{id}', 'update');
            Route::get('{status}-coupon/{id}', 'status');
        });

    });

    Route::prefix("provider-dashboard")->middleware('auth:api')->group(function () {
        
        Route::controller(\App\Http\Controllers\API\ProviderDashboard\CouponController::class)->group(function () {
            Route::get('coupons', 'index');
            Route::post('coupons/create', 'create');
            Route::post('coupons/update/{id}', 'update');
            Route::get('{status}-coupon/{id}', 'status');
        });

        Route::controller(\App\Http\Controllers\API\ProviderDashboard\AdvertisementController::class)->group(function () {
            Route::get('advertisements', 'index');
            Route::post('advertisements/create', 'create');
            Route::put('advertisements/update/{id}', 'update');
            Route::get('advertisements/{status}/{id}', 'status');
        });
        Route::controller(\App\Http\Controllers\API\ProviderDashboard\ProductController::class)->group(function () {
            Route::get('products', 'index');
            Route::post('products/create', 'create');
            Route::put('products/update/{id}', 'update');
            Route::get('products/{status}/{id}', 'status');
        });
        Route::controller(\App\Http\Controllers\API\ProviderDashboard\ProductCategoryController::class)->group(function () {
            Route::get('product-categories', 'index');
            Route::post('product-categories/create', 'create');
            Route::put('product-categories/update/{id}', 'update');
            Route::get('product-categories/{status}/{id}', 'status');
        });
        Route::controller(\App\Http\Controllers\API\ProviderDashboard\EnhancementController::class)->group(function () {
            Route::get('enhancements', 'index');
            Route::post('enhancements/create', 'create');
            Route::put('enhancements/update/{id}', 'update');
            Route::get('enhancements/{status}/{id}', 'status');
        });
        Route::controller(\App\Http\Controllers\API\ProviderDashboard\CustomerController::class)->group(function () {
            Route::get('customers', 'index');
            Route::get('customer/{id}', 'details');
        });
        Route::controller(\App\Http\Controllers\API\ProviderDashboard\OrderController::class)->group(function () {
            Route::get('orders', 'index');
        });
        Route::controller(\App\Http\Controllers\API\ProviderDashboard\RatingController::class)->group(function () {
            Route::get('ratings', 'index');
        });
    });
