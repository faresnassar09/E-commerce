<?php

namespace App\Services\Seller;

use App\Facades\AuthSeller;

class StoreService
{

    public function getStores()
    {

        return  AuthSeller::fullInfo()
        ->stores()
        ->with('images', 'city', 'area')->get();
    }




    public function createStore($data)
    {


        $seller = AuthSeller::fullInfo();

        return  $seller->stores()->create([

            'name' => $data->name,
            'description' => $data->description,
            'city_id' => $data->city_id,
            'area_id' => $data->area_id,
            'street' => $data->street,

        ]);
    }

    public function findStore($storeId)
    {

        return AuthSeller::fullInfo()->stores()->find($storeId);
    }

    public function getStoreDetails($storeId){

 return AuthSeller::fullInfo()
 ->stores()
 ->with('products.images',
 'seller:id,name,phone_numbers')
 ->find($storeId);
        
    }

    public function getcategoriesDetails($store) {


        return[
    
            'vegetables' =>$store->products->where('category_id',1)->count(),
            'milks' =>  $store->products->where('category_id',2)->count(),
            'grains' =>  $store->products->where('category_id',3)->count(),
            'fruits' =>  $store->products->where('category_id',4)->count(),
        
        ];
        
    }
    public function updateStore($store, $data)
    {

        $store->fill($data->all());

        if ($store->isDirty()) {

            $store->save();
        }
    }

    public function destroyStore($store){


        $store->delete();

    }

    public function storeNotFound()
    {

        return back()->with('failed', 'لقد حدث خطاء حاول مرة اخري');
    }

    public function insertImages($store, $imagesPaths)
    {


        foreach ($imagesPaths as $imagePath) {

            $store->images()->create([

                'path' => $imagePath,
            ]);
        }
    }
}
