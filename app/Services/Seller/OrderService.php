<?php

namespace App\Services\Seller;

use App\Facades\AuthSeller;



class OrderService
{

    public function getOrders($orderByColumn, $status)
    {


        return AuthSeller::fullInfo()

            ->orders()
            ->where('status', $status)
            ->orderBy($orderByColumn, 'desc')
            ->with([
                'items.product.images',
                'user',
                'logs',
                'userAddress' => ['city', 'area']
            ])
            ->get();
    }

    public function  findOrder($orderId){

        return AuthSeller::fullInfo()->orders()->find($orderId);
        
    }

    public static function orderNotFound()
    {
        return back()->with('failed', __('messages.order_error_delete'));;
    }


    public function changeOrderStatus($order,$status) {

        $order->update(['status' => $status]);

        if ($status == 2) {
            $order->update(['canceled_at' => now()]);  
        
        }

    }


}
