<?php

use App\Facades\AuthSeller;
use App\Facades\seller;
use App\Http\Controllers\Seller\SubscriptionController;
use App\Http\Controllers\User\Products\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;




Route::get('response',function(){

    return response()->json(['success' => true,'fares']);

});


Route::get('test',function(){

    // Storage::append('public/english.text','Subsequent');

 

    $order = \App\Models\Order\Order::find(5);
    return $order->getOrderEmailData();

});



Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

    session()->put('locale', $locale);

    return back(); // أو redirect('/')
})->name('lang.switch');
 



