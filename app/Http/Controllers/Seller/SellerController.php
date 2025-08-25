<?php

namespace App\Http\Controllers\Seller;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;

class SellerController extends Controller
{

public function dashboard(){


$data = [

    'productsCount' => AuthSeller::fullInfo()->products()->count(),
    'storesCount' => AuthSeller::fullInfo()->stores()->count(),
    'ordersCount' => AuthSeller::fullInfo()->orders()->count(),
    'totalProfit' => AuthSeller::fullInfo()->orders()->where('status',1)->sum('price'),
];


return view('sellers.dashboard',compact('data'));

}

}
