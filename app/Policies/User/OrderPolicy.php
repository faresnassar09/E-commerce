<?php

namespace App\Policies\User;

use App\Models\Order\Order;
use App\Models\User\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Order $order): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
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
}
