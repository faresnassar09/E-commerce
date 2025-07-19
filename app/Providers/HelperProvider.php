<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthSeller;
class HelperProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
             $this->app->singleton(AuthSeller::class, function () {
            return new AuthSeller();
        });
    
        $this->app->alias(AuthSeller::class,'AuthSeller');    }   //


  


   public function boot(): void
    {

}


    

   }   /**
     * Bootstrap services.
     */
 