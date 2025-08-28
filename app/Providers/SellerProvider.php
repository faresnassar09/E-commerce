<?php

namespace App\Providers;

use App\Models\Product\Product;
use App\Models\Store\Store;
use App\Observers\Seller\ProductObserver;
use App\Observers\Seller\StoreObserver;
use App\Services\Seller\AuthSeller;
use Illuminate\Support\ServiceProvider;

class SellerProvider extends ServiceProvider
{


    public function register(): void
    {


        $this->app->singleton(AuthSeller::class, function () {
            return new AuthSeller();
        });
    
        $this->app->alias(AuthSeller::class,'AuthSeller'); 
    
    }  



   public function boot(): void

    {

        Product::observe(ProductObserver::class);
        Store::observe(StoreObserver::class);



}
   }  