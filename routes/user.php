<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\User\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\Auth\ConfirmablePasswordController;
use App\Http\Controllers\User\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\User\Auth\EmailVerificationPromptController;
use App\Http\Controllers\User\Auth\NewPasswordController;
use App\Http\Controllers\User\Auth\PasswordController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;
use App\Http\Controllers\User\Auth\RegisteredUserController;
use App\Http\Controllers\User\Auth\VerifyEmailController;
use App\Http\Controllers\User\cartItemsController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\Product\ProductController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\StoreController ;


//   Important 

/*
|                                                     |
|  we don't use routs for cart-items we use livewire  |
|                                                     |
*/


Route::middleware('guest')->prefix('user/')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');  

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:5,1');

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});


Route::controller(cartItemsController::class)
->middleware(['auth','user_not_banned'])
->prefix('user/cart/')
->name('user.cart.')
->group(function () {

    route::get('index', 'index')->name('index');
});


Route::controller(OrderController::class)
->middleware(['auth:web', 'verified','user_not_banned'])
->prefix('user/orders/')
->name('user.orders.')
->group(function () {
  
    Route::get('index', 'index')->name('index');
    Route::get('delivered', 'getDeliveredOrders')->name('delivered');
    Route::patch('cancel/{order}', 'cancelOrder')->name('cancel');
    Route::get('canceled', 'getcancelledOrdes')->name('cancelled');
    Route::patch('return-request', 'returnOrderRequest')->name('return');
    Route::get('returned', 'getReturnedOrders')->name('get_returns');
    Route::get('traking/{order}', 'traking')->name('traking');
});




Route::controller(ProductController::class)
->prefix('prodcts/')
->name('user.product.')
->group(function () {

    Route::get('show/{id}', 'show')->name('show');
});



Route::get('/',[UserController::class,'index'])->name('index');

Route::controller(UserController::class)
    ->middleware(['auth:web', 'verified'])
    ->prefix('user/')
    ->name('user.')
    ->group(function () {

        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('new-address','createNewAddresss')->name('create_address')->middleware('user_not_banned');
        Route::post('insert-address','storeNewAddress')->name('insert_address')->middleware('user_not_banned');

    });


Route::controller(ProfileController::class)
    ->middleware(['auth:web', 'verified','user_not_banned'])
    ->prefix('user/profile/')
    ->name('user.profile.')
    ->group(function () {


        Route::get('profile',  'edit')->name('edit');
        Route::patch('profile', 'update')->name('update');
        Route::delete('profile',  'destroy')->name('destroy');
    });

    Route::controller(StoreController::class)

    ->prefix('user/store/')
    ->name('user.store.')
    ->group(function () {


        Route::get('details/{id}','getStoreDetails')->name('details');
  
    });
