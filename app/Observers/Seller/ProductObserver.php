<?php

namespace App\Observers\Seller;

use App\Services\Seller\CacheService;
use App\Models\Product\Product;


class ProductObserver
{

    public function __construct(public CacheService $cacheService)
    {
        
    }
    public function created(Product $product): void
    {

        $this->cacheService->clearProductsCache();

}

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this->cacheService->clearProductsCache();
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this->cacheService->clearProductsCache();
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        $this->cacheService->clearProductsCache();
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        $this->cacheService->clearProductsCache();
    }
}
