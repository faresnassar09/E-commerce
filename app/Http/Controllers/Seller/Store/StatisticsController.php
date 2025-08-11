<?php

namespace App\Http\Controllers\Seller\Store;

use App\Http\Controllers\Controller;
use App\Services\Seller\StoreService;

class StatisticsController extends Controller
{
 
    public function __construct(

        public StoreService $storeService,

    ){}


public function index(){
 
$stores = $this->storeService->getStores(); 

return view('sellers.stores.statistics.index',compact('stores'));
    } 

    public function getStoreDetails($id){


    $store = $this->storeService->getStoreDetails($id);
      
    $categories = $this->storeService->getCategoriesDetails($store);
      
    return view('sellers.stores.statistics.view-store',compact('store','categories'));
    }

  
}
       