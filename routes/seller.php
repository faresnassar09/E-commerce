<?php

use App\Http\Controllers\Seller\Auth\AuthenticationController;
use App\Http\Controllers\Seller\Auth\RegistrationController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\Product\ProductController;
use App\Http\Controllers\Seller\Product\StatisticController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\Store\StatisticsController as StoreStaticsesController;
use App\Http\Controllers\Seller\Store\StoreController;
use App\Http\Controllers\Seller\SubscriptionController;
use App\Http\Controllers\Support\ComplaintController;

use Illuminate\Support\Facades\Route;

Route::controller(SellerController::class)
    ->middleware('auth:seller')
    ->prefix('seller/')
    ->name('seller.')
    ->group(function () {

      Route::view('landing','sellers.index')->name('landing')->withoutMiddleware('auth:seller');
      Route::get('dashboard','dashboard')->name('dashboard');
      
    });



    Route::controller(RegistrationController::class)
    ->prefix('auth/seller/')
    ->name('auth.seller.')
    ->group(function () {

        Route::get("register", 'create')->name('create');
        Route::post("insert", 'store')->name('insert');

    });


    Route::controller(AuthenticationController::class)
    ->prefix('auth/seller/')
    ->name('auth.seller.')
    ->group(function () {


        Route::get('login', 'login')->name('login');
        Route::post('login','LoginAuthentication')->name('login.submit');

        Route::post('logout','destroy')->name('logout');
    });

Route::controller(ProfileController::class)
    ->middleware(['auth:seller', 'checksubsription','seller_not_baneed'])
    ->prefix('seller/profile/')
    ->name('seller.profile.')
    ->group(function () {

        Route::get('index', 'index')->name('index');
        Route::post('update', 'update')->name('update');
        Route::get('destroy', 'destroy');

    });


Route::controller(StoreController::class)
    ->middleware(['auth:seller', 'checksubsription','seller_not_baneed'])
    ->prefix('seller/store')
    ->name('seller.store.')
    ->group(function () {

        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('create.submit');
        Route::get('edit/{store}', 'edit')->name('edit');
        Route::post('update/{store}', 'update')->name('update');
        Route::get('delete/{store}', 'destroy')->name('delete');
    });

Route::controller(StoreStaticsesController::class)
    ->middleware(['auth:seller','checksubsription','seller_not_baneed'])
    ->prefix('seller/store/staticses/')
    ->name('seller.store.staticses.')
    ->group(function () {

        Route::get('index', 'index')->name('index');
        Route::get('details/{id}', 'getStoreDetails')->name('details')->withoutMiddleware(['auth:seller','checksubsription']);


    });
Route::controller(ProductController::class)
    ->middleware(['auth:seller', 'checksubsription','seller_not_baneed'])
    ->prefix('seller/product-managemt/')
    ->name('seller.product.')
    ->group(function () {

        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('insert', 'store')->name('store');
        Route::patch('update/{product}','update')->name('update');
        Route::delete('delete/{product}', 'destroy')->name('delete');
        Route::get('delete-image/{image}', 'deleteImage')->name('image.delete');
    });


Route::controller(StatisticController::class)
    ->middleware(['auth:seller', 'checksubsription','seller_not_baneed'])
    ->prefix('seller/products/statics')
    ->name('seller.statics.')
    ->group(function () {

        Route::get('static', 'index')->name('statics');

        Route::patch('increase-quntity', 'increaseQuantity')->name('increase');

        Route::patch('decrease-quntity', 'decreaseQuantity')->name('decrease');
        Route::patch('reset-quantity', 'resetQuantity')->name('resetquantity');
    });

Route::controller(OrderController::class)
    ->middleware(['auth:seller', 'checksubsription','seller_not_baneed'])
    ->prefix('/seller/orders-managemntg/')
    ->name('seller.orders.')
    ->group(function () {

        Route::get('incoaming', 'incoming')->name('incoming');
        Route::get('canceled', 'getCanceledOrders')->name('canceled');
        Route::get('delivered', 'getDeliveredOrders')->name('delivered');
        Route::get('return-requests', 'getReturnRequests')->name('return_requests');
        Route::patch('return-accept/{order}', 'acceptReturnRequest')->name('return.accept');
        Route::patch('return-reject/{order}', 'rejectReturnRequest')->name('return.reject');
    });


Route::controller(SubscriptionController::class)
    ->prefix('seller/subscription/')
    ->name('seller.subscription.')
    ->middleware('auth:seller','seller_not_baneed')
    ->group(function () {

        Route::post('new-subscripe', 'createCheckout')->name('create');
        Route::get('success', function(){return to_route('seller.subscription.get_details')->with('success','تم الاشتراك بنجاح');} )->name('success');
        Route::get('failed', function(){return to_route('seller.subscription.get_details')->with('failed','حدثت مشكلة اثناء الدفع تواصل مع الدعم');})->name('failed');
        Route::delete('cancel', 'cancel')->name('cancel');
        Route::get('subscription-details', 'getSubscriptionDetails')->name('get_details');
    });


    Route::controller(ComplaintController::class)
    ->prefix('seller/complaint/')
    ->name('support.complaint.')
    ->middleware('auth:seller')
    ->group(function () {

        Route::get('tickets', 'index')->name('tickets');
        Route::post('store', 'store')->name('store');
        Route::get('show/{ticket}', 'show')->name('show');
        Route::delete('delete/{ticket}', 'deleteTicket')->name('delete');
        Route::post('new-reply/{ticket}', 'submitReply')->name('insert_reply');


       
    });