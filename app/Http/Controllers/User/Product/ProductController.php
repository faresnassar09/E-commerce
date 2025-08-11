<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use App\Models\Product\Product;

class ProductController extends Controller
{

    public function show($id){

        $product = Product::with(
            
            'images',
            'store:id,name,city_id,area_id,street',
            'store.city:id,name',
            'store.area:id,name'
            )->find($id);

        return view('users.products.view',compact('product'));

    }

}
