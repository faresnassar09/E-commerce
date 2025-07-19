<?php

namespace App\Providers;

use App\Models\Seller\Seller;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {



    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Cashier::useCustomerModel(Seller::class);
        Cashier::calculateTaxes();


}
}