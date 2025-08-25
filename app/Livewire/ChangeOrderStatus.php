<?php

namespace App\Livewire;

use App\Facades\AuthSeller;
use App\Services\EmailService;
use App\Services\Seller\LoggingService;
use App\Services\Seller\OrderService;
use Livewire\Component;


class ChangeOrderStatus extends Component
{

    public $orderId;

    public function mont($orderId)
    {

        $this->orderId = $orderId;
    }

    public function changeStatus($status)
    {


        $order = app(OrderService::class)->findOrder($this->orderId);

        if (!$order) {

            app(LoggingService::class)->faild('order not found',[

                'order_id' => $this->orderId,
            ]);

            return redirect()->route('seller.orders.incaming')->with('failed', 'الاوردر غير موجود');
        }

        app(OrderService::class)->changeOrderStatus($order, $status);

        $orderDetails = $order->load('items.product')->toArray();


        switch ($status) {

            case 0:
                $status = __('notifications.order_preparing');

                break;

            case 1:

                $status = 'تم نقل الطلب لخانة الطلبات الموصلة';

                app(EmailService::class)->SendOrderSellerTrakingMail(
                    AuthSeller::fullInfo(),
                    $orderDetails,
                    $order->getOrderEmailData(),
                    'delivered',
                );

                app(EmailService::class)->SendOrderUserTrakingMail(
                    $order->getOrderEmailData(),
                    $orderDetails,
                    $order->seller->phone_numbers,
                    'delivered',
                );
                break;

            case 2:

                $status = __('notifications.order_canceled');

                app(EmailService::class)->SendOrderSellerTrakingMail(
                    AuthSeller::fullInfo(),
                    $orderDetails,
                    $order->getOrderEmailData(),
                    'caceled',
                );

                app(EmailService::class)->SendOrderUserTrakingMail(
                    $order->getOrderEmailData(),
                    $orderDetails,
                    $order->seller->phone_numbers,
                    'canceled',
                );
                break;

            case 3:
                $status = __('notifications.return_order_request');
        }


        app(LoggingService::class)->success('order status has been changed',[

            'order_id' => $this->orderId,
            'status' => $status,
        ]);

        return to_route('seller.orders.incoming')->with('success', $status);
    }

    public function render()
    {
        return view('livewire.change-order-status');
    }
}
