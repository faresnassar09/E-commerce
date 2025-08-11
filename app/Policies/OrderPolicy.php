<?php

namespace App\Policies;

use App\Models\Order\Order;
use App\Models\User\User;
use App\Models\Seller\Seller;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{

    public function delete(User $user, Order $order): bool
    {
            return $user->id === $order->user_id;
    }  

    public function cancel(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }  

public function returnOrder(User $user, Order $order){

    return $user->id === $order->user_id;

}

public function sellerCanAcceptReturn(Seller $seller , Order $order): bool {

    return $seller->id === $order->seller_id ; 
    
}
}
