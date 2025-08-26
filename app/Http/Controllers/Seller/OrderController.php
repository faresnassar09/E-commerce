<?php

namespace App\Http\Controllers\Seller;

use App\Enums\OrderStatus;
use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Services\EmailService;
use App\Services\Seller\LoggingService;
use App\Services\Seller\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class OrderController extends Controller
{

    public function __construct(

        public OrderService $orderService,
        public EmailService $emailService,
        public LoggingService $loggingService,

    ) {}
    public function incoming()
    {
        $orders = $this->orderService->getOrders('created_at', OrderStatus::Preparing->value);

        return view('sellers.orders.incoming', compact('orders'));
    }

    public function getDeliveredOrders()
    {

        $orders = $this->orderService->getOrders('updated_at', OrderStatus::Delivered->value);

        return view('sellers.orders.delivered', compact('orders'));
    }

    public function getCanceledOrders()
    {

        $canceledOrders = $this->orderService->getOrders('cancelled_at', OrderStatus::Canceled->value);

        return view('sellers.orders.canceled', compact('canceledOrders'));
    }

    public function getReturnRequests()
    {

        $orders = $this->orderService->getOrders('updated_at', OrderStatus::ReturnRequest->value);

        return view('sellers.orders.return-requests', compact('orders'));
    }

    public function acceptReturnRequest(Request $request,Order $order)
    {
        
        try {

        Gate::forUser(AuthSeller::fullInfo())->authorize('sellerCanAcceptReturn',$order);
        
        $this->orderService->changeOrderStatus($order,OrderStatus::ReturnAccepted->value);

        $sellerPhone = $order->seller->phone_numbers;

        $orderDetails = $order->load('items.product');


        $this->emailService->SendOrderUserTrakingMail(
            $order->getOrderEmailData(),
            $orderDetails,
            $sellerPhone,
            'returned'
        );

        $this->emailService->SendOrderSellerTrakingMail(
            AuthSeller::fullInfo(),
            $orderDetails,
            $order->getOrderEmailData(),
            'returned'
        );

        $this->loggingService->success('Order return request accepted',[

        'user_id' => $order->user_id,
        'order_id' => $order->id,
        ]);

        return back()->with('success',__('notifications.return_order_request_accepted'));

        } catch (\Exception $e) {

            $this->loggingService->failed('Unexpected error occurred while accept order return',[

                'exception_details' => $e->getMessage(),
                'order_id' => $order->id,
                ]);

            return back()->with('failed',__('notifications.return_order_request_accept_failed'));

        }

    }

    public function rejectReturnRequest(Order $order)
    {
try {
    
        Gate::forUser(AuthSeller::fullInfo())->authorize('sellerCanAcceptReturn',$order);

        $this->orderService->changeOrderStatus($order,OrderStatus::ReturnRejected->value);

        $orderDetails = $order->load('items.product');

        $this->emailService->SendOrderUserTrakingMail(
            $order->getOrderEmailData(),
            $orderDetails,
            $order->seller->phone_numbers,
            'return-rejected'
        );

        $this->loggingService->success('Order return request rejected',[

            'user_id' => $order->user_id,
            'order_id' => $order->id,
            ]);

        return back()->with('success',__('notifications.return_order_request_rejected'));

} catch (\Exception $e) {

    $this->loggingService->failed('Unexpected error occurred while accept order return',[

        'exception_details' => $e->getMessage(),
        'order_id' => $order->id,
        ]);

    return back()->with('failed',__('notifications.return_order_request_reject_failed'));

}

}
}
