<?php

namespace App\Http\Controllers\Seller\Store;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Models\Store\Store;


class StatisticsController extends Controller
{
 
    public function index(){
 
$stores = AuthSeller::fullInfo()->stores()->with('Images','products')->get(); 


return view('sellers.stores.statistics.index',compact('stores'));
    } 

    public function getStoreDetails($id){


        $store = Store::with('products.images','seller:id,name,phone_numbers')->find($id);
      
    $categories = [
    
        'vegetables' =>$store->products->where('category_id',1)->count(),
        'milks' =>  $store->products->where('category_id',2)->count(),
        'grains' =>  $store->products->where('category_id',3)->count(),
        'fruits' =>  $store->products->where('category_id',4)->count(),
    
    ];
      
    // return $categories;
        return view('sellers.stores.statistics.view-store',compact('store','categories'));
    }

  
}
       