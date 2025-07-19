<?php

use App\Http\Controllers\Seller\Auth\RegisterSellerController;
use App\Http\Controllers\Seller\Product\SellerProduct;
use App\Http\Controllers\Seller\Product\SellerProductsController;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Route::post("insert",[RegisterSellerController::class,'index'])->name('insert');


Route::middleware('auth:sanctum')->post('/save-token', function (Request $request) {

    return response()->json(['success' => Auth::user()]);
});




Route::delete('/seller/products-managemt/delete-image/{image_id}',[SellerProductsController::class,'deleteImage'])->name('seller.product.delete.image');
