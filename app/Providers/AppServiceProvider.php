<?php

namespace App\Providers;

use App\Models\Seller\Seller;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;
use App\Services\EmailService;
use Illuminate\Support\Facades\Crypt;

;
class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {

    }
 

    public function boot(): void
    {  

        Cashier::useCustomerModel(Seller::class);
        Cashier::calculateTaxes();
}
}