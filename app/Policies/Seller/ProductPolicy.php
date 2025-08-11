<?php

namespace App\Policies\Seller;

use App\Models\Admin\Admin;
use App\Models\Product\Product;
use App\Models\Seller\Seller;
use App\Models\User\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{

    public function update(Seller $seller, Product $product): bool
    {
        if ($seller instanceof Admin) {
            return true;
        }
        
        return $seller->id === $product->seller_id;

    }

    public function delete(Seller $seller, Product $product): bool
    {
        if ($seller instanceof Admin) {
            return true;
        }

        return $seller->id === $product->seller_id;

    }

    public function canIncrease(Seller $seller, Product $product): bool
    {
        if ($seller instanceof Admin) {
            return true;
        }

        return $seller->id === $product->seller_id;

    }

    public function canDecrease(Seller $seller, Product $product): bool
    {
        if ($seller instanceof Admin) {
            return true;
        }

        return $seller->id === $product->seller_id;

    }

    public function canReset(Seller $seller, Product $product): bool
    {
        if ($seller instanceof Admin) {
            return true;
        }
        
        return $seller->id === $product->seller_id;

    }
}
