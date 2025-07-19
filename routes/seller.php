<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Seller\Product\ProductsController;
use App\Http\Controllers\Seller\Product\StatisticsController;

use App\Http\Controllers\Seller\Auth\RegistrationController;
use App\Http\Controllers\Seller\Auth\AuthenticationController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\Store\StoreController;
use App\Http\Controllers\Seller\Store\StatisticsController as StoreStaticsesController;
use App\Http\Controllers\Seller\SubscriptionController;
use App\Http\Controllers\Support\Complaint;

Route::controller(SellerController::class)
    ->middleware('auth:seller')
    ->prefix('seller/')
    ->name('seller.')
    ->group(function () {

      Route::view('landing','sellers.index')->name('landing')->withoutMiddleware('auth:seller');
      Route::get('/dashboard','dashboard')->name('dashboard');
      
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
        // Route::get('notifications','notify')->name('notify');

    });


Route::controller(StoreController::class)
    ->middleware(['auth:seller', 'checksubsription','seller_not_baneed'])
    ->prefix('seller/store')
    ->name('seller.store.')
    ->group(function () {

        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('create', 'store')->name('create.submit');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update/{id}', 'update')->name('update');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

Route::controller(StoreStaticsesController::class)
    ->middleware(['auth:seller','checksubsription','seller_not_baneed'])
    ->prefix('seller/store/staticses/')
    ->name('seller.store.staticses.')
    ->group(function () {

        Route::get('index', 'index')->name('index');
        Route::get('details/{id}', 'getStoreDetails')->name('details')->withoutMiddleware(['auth:seller','checksubsription']);


    });
Route::controller(ProductsController::class)
    ->middleware(['auth:seller', 'checksubsription','seller_not_baneed'])
    ->prefix('/seller/products-managemt')
    ->name('seller.product.')
    ->group(function () {

        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('insert', 'store')->name('store');
        Route::patch('update/{id}', 'update')->name('update');
        Route::delete('delete/{id}', 'destroy')->name('delete');
        Route::delete('delete-image/{image_id}', 'Delete_Image')->name('image.delete');
    });


Route::controller(StatisticsController::class)
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
        Route::patch('return-accept/{id}', 'acceptReturnRequest')->name('return.accept');
        Route::patch('return-reject/{id}', 'rejectReturnRequest')->name('return.reject');
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


    Route::controller(Complaint::class)
    ->prefix('seller/complaint/')
    ->name('support.complaint.')
    ->middleware('auth:seller')
    ->group(function () {

        Route::get('tickets', 'index')->name('tickets');
        Route::post('store', 'store')->name('store');
        Route::get('show/{id}', 'show')->name('show');
        Route::delete('delete', 'deleteTicket')->name('delete');
        Route::post('new-reply/{id}', 'submitReply')->name('insert_reply');


       
    });