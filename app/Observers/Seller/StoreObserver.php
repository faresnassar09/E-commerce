<?php

namespace App\Observers\Seller;

use App\Models\Store\Store;
use App\Services\Seller\CacheService;

class StoreObserver
{
    
    public function __construct(public CacheService $cacheService)
    {
        
    }
    public function created(Store $store): void
    {
        $this->cacheService->clearStoresCache();
    }

    /**
     * Handle the Store "updated" event.
     */
    public function updated(Store $store): void
    {
        $this->cacheService->clearStoresCache();
    }

    /**
     * Handle the Store "deleted" event.
     */
    public function deleted(Store $store): void
    {
        $this->cacheService->clearStoresCache();
    }

    /**
     * Handle the Store "restored" event.
     */
    public function restored(Store $store): void
    {
        $this->cacheService->clearStoresCache();
    }

    /**
     * Handle the Store "force deleted" event.
     */
    public function forceDeleted(Store $store): void
    {
        $this->cacheService->clearStoresCache();
    }
}
