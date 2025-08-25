<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Store\Store;

class StoreController extends Controller
{
public function getStoreDetails($id){


    $store = Store::with('products.images','seller:id,name,phone_numbers')->find($id);
  
$categories = [

    'vegetables' =>$store->products->where('category_id',1)->count(),
    'milks' =>  $store->products->where('category_id',3)->count(),
    'grains' =>  $store->products->where('category_id',2)->count(),
    'fruits' =>  $store->products->where('category_id',4)->count(),

];
  
    return view('users.stores.details',compact('store','categories'));
}
  
}
  