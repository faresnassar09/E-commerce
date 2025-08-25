<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;


class OrderService
{


  public function getOrders($status)
  {

    return Auth::user()
      ->orders()
      ->where('status', $status)
      ->orderBy('updated_at', 'desc')
      ->with(

        'items.product.images',
        'seller',

      )->get();
  }

  public function changeOrderStatus($order, $status)
  {

    $order->update(['status' => $status]);

    if ($status == 2) {

      $order->update(['canceled_at' => now()]);
    }

  }



  public function reasonOfCancelation($order, $reason)
  {

    return  $order->logs()->create([

      'type' => 'return',
      'details' => $reason,

    ]);
  }


  public function getReturnsOrders(){

    return Auth::user()
    ->orders()
    ->whereIn('status', [3, 4, 5])
    ->orderBy('updated_at', 'desc')
    ->with(

      'items.product.images',
      'seller',

    )->get();

  }
}
