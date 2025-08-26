<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\CancelationReasonRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Order\Order;
use App\Services\EmailService;
use App\Services\User\OrderService;
use App\Services\NotificationService;
use App\Services\User\LoggingService;
use Illuminate\Support\Facades\Gate;
use App\Enums\OrderStatus;

class OrderController extends Controller
{

  public function __construct(

    public OrderService $orderService,
    public NotificationService $notificationService,
    public EmailService $emailService,
    public LoggingService $loggingService,

  ){}

  public function index()
  {

    $orders = $this->orderService->getOrders(OrderStatus::Preparing->value);

    return view('users.orders.current', compact('orders'));
  }

  public function cancelOrder(Order $order)
  {

    try {
      
      Gate::authorize('cancel', $order);

      $this->orderService->changeOrderStatus($order,OrderStatus::Canceled->value);

    $orderDetails = $order->load('items.product.seller','user');

    $this->notificationService->notifySellerOfOrderTracking(
      
      $orderDetails->seller,
      Auth::user()->name,
      __('messages.order '.'messages.cancel'),
      __('messages.canceled_orders_title')
    );

    $this->emailService->sendOrderUserTrakingMail(
      Auth::user(),
      $orderDetails,
      $orderDetails->seller->phone_numbers,
      'canceled'
  );

    $this->emailService->sendOrderSellerTrakingMail(

      $orderDetails->items->first()->product->seller,
      $orderDetails,
      $order->getOrderEmailData(),
      'canceled',
    );  

    $this->loggingService->success('order status has changed',[

      'order_id' => $order->id,
      'status' => 'canceled',
    ]);

    return back()->with('success',__('notifications.cancel_order_succeeded'));

    } catch(\Exception $e){

      $this->loggingService->failed('Error occurred while uptating order status',[

      'order_id' => $order->id,
      'exception_details' => $e->getMessage(),
      ]);

    return back()->with('failed', __('notifications.cancel_order_failed'));
}

  }

  public function getcancelledOrdes()
  {

    $canceledOrders = $this->orderService->getOrders(OrderStatus::Canceled->value);


    return view('users.orders.canceled', compact('canceledOrders'));
  }

  public function getDeliveredOrders()
  {

    $orders = $this->orderService->getOrders(OrderStatus::Delivered->value);

    return view('users.orders.delivered', compact('orders'));
  }

  public function returnOrderRequest(CancelationReasonRequest $request)
  {

    try {

    $order = Auth::user()->orders->find($request->order_id);

    Gate::authorize('returnOrder', $order);

    $this->orderService->changeOrderStatus($order, OrderStatus::ReturnRequest->value);

    if ($request->reason) {

      $this->orderService->reasonOfCancelation($order,$request->reason);
    }

    $this->notificationService->notifySellerOfOrderTracking(
      $order->seller,
      $order->user->name,
      __('messages.status_pending_return'),
     __('messages.check_order_requests')
    );

    
    $this->loggingService->success('order return request send to seller successfully',[

      'order_id' => $order->id,
      'order_number' => $order->order_number,

    ]);

    return back()->with('success', __('notifications.return_order_request'));

    } catch (\Exception $e) {

      $this->loggingService->failed('Error occurred while cancelation order',[

        'order_id' => $request->order_id ?? null,
        'exception_details' => $e->getMessage(),
        ]);
    }

    return back()->with('success', __('notifications.return_order_request_failed'));


  }

  public function getReturnedOrders()
  {

    $orders = $this->orderService->getReturnsOrders();
    return view('users.orders.returnes', compact('orders'));
  }

}
