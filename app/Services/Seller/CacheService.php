<?php 

namespace App\Services\Seller;

use App\Enums\CacheKeys;
use App\Facades\AuthSeller;

class CacheService{


      
    public function getCachedStores(){

        return app('cache')->rememberForever(CacheKeys::SellerStores->value . AuthSeller::id(),function(){

        return  AuthSeller::fullInfo()
        ->stores()
        ->with('images', 'city', 'area')->get();


    });


    }


    public function getCachedProducts(){

        return app('cache')->rememberForever(CacheKeys::SellerProducts->value . AuthSeller::id(),function(){

            return AuthSeller::fullInfo()->products()->with('images')->paginate(12);
    
        }); 

    }

    public function clearStoresCache()
    {

        app('cache')->forget(CacheKeys::SellerStores->value . AuthSeller::id());
    }

    public function clearProductsCache()
    {

        app('cache')->forget(CacheKeys::SellerProducts->value . AuthSeller::id());
    }



} 