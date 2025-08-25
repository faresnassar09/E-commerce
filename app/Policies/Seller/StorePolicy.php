<?php

namespace App\Policies\Seller;

use App\Models\Store\Store;
use App\Models\Seller\Seller;
use App\Models\Admin\Admin;
class StorePolicy
{

    public function edit(Seller $seller, Store $store): bool
    {

        return $seller->id === $store->seller_id;
    }


    public function update(Admin |Seller $seller, Store $store): bool
    {
        if ($seller instanceof Admin) {
            return true;
        }

        return $seller->id === $store->seller_id;
    }


    public function delete(Admin |Seller $seller, Store $store): bool
    {        if ($seller instanceof Admin) {
            return true;
        }
        return $seller->id === $store->seller_id;
    }
}
