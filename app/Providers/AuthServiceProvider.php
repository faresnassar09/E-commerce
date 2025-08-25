<?php

namespace App\Providers;

use \App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Store\Store;
use App\Models\Support\Ticket;
use App\Policies\OrderPolicy;
use App\Policies\Seller\ComplaintPolicy;
use App\Policies\Seller\ProductPolicy;
use App\Policies\Seller\StorePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Product::class => ProductPolicy::class,
        Store::class => StorePolicy::class,
        Order::class => OrderPolicy::class,
        Ticket::class => ComplaintPolicy::class,
    ];
    

    public function boot(): void
    {


            }
}
