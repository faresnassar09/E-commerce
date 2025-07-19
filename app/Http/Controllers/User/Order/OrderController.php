<?php

namespace App\Http\Controllers\User\Order;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Http\Requests\Seller\ReasonCancelationForm;
use App\Models\Order\OrderLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Jobs\Seller\SendOrderStatusUpdateMailJob as SellerJobMail;
use App\Jobs\User\SendOrderStatusUpdateMailJob as UserJobMail;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{

  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    $orders = $this->getOrders(0);

    return view('users.orders.current', compact('orders'));
  }



  public function cancelOrder(Order $order)
  {

    Gate::authorize('cancel', $order);



    $orderDetails = $order->load('items.product.user');

    $this->sendNotification($order->seller_id, $orderDetails->user->name, 'الغاء اوردر', 'بالغاء طلب');
    $this->sendMails($order->seller, $orderDetails, $order, 'canceled');
    return  $this->changeOrderStatus($order, 2, 'cancelled_at');
  }



  public function getcancelledOrdes()
  {


    $canceledOrders = $this->getOrders(2);


    return view('users.orders.canceled', compact('canceledOrders'));
  }


  public function getDeliveredOrders()
  {

    $orders = $this->getOrders(1);

    return view('users.orders.delivered', compact('orders'));
  }

  public function returnOrderRequest(ReasonCancelationForm $request)
  {

    $order = Auth::user()->orders->find($request->order_id);

    Gate::authorize('returnOrder', $order);

    $userName = $order->user->name;

    $this->changeOrderStatus($order, 3, 'updated_at');

    if ($request->reason) {

      $this->reasonOfCancelation($request);
    }

    $this->sendNotification(
      $order->seller_id,
      $userName,
      'طلب ارجاع',
      ' بطلب  ارجاع  أوردر. راجع صفحة الطلبات المرتجعات.'
    );



    return back()->with('success', 'تم ارسال طلب لارجاع الاوردر سيتواصل معك البائع قريبا');
  }

  public function getReturnedOrders()
  {

    $orders = Auth::user()
      ->orders()
      ->whereIn('status', [3, 4, 5])
      ->orderBy('updated_at', 'desc')
      ->with(

        'items.product.images',
        'seller',

      )->get();

    return view('users.orders.returnes', compact('orders'));
  }

  public function changeOrderStatus($order, $status, $recourdTimecoulmn)
  {

    try {


      $order->update([

        'status' => $status,
        $recourdTimecoulmn => now(),
      ]);

      Log::channel('user')->info('order status has changed', [

        'user_id' => $order->user_id,
        'order_id' => $order->id,
        'status' => $status,


      ]);

      return back()->with('success', __('messages.order_deleted_sucssesfuly'));
    } catch (\Exception $e) {


      Log::channel('user')->error('order status has not changed', [

        'user_id' => $order->user_id,
        'order_id' => $order->id,
        'status' => $status,
        'exception_details' => $e->getMessage(),
      ]);

      return back()->with('failed', 'error occurried while change order status');
    }
  }


  private function getOrders($status)
  {

    return  $canceledOrders = Auth::user()
      ->orders()
      ->where('status', $status)
      ->orderBy('updated_at', 'desc')
      ->with(

        'items.product.images',
        'seller',

      )->get();
  }

  public function reasonOfCancelation($request)
  {

    try {

      $orderLog = OrderLog::create([

        'title' => $request->reason,
        'type' => 'return',
        'details' => $request->reason,
        'order_id' => $request->order_id,

      ]);
    } catch (\Exception $e) {

      Log::channel('user')->error('error occurred while saving cancelation reason ', [

        'user_id' => Auth::id(),
        'order_id' => $orderId ?? null,
        'exception_details' => $e->getMessage(),
      ]);
    }
  }

  public function sendNotification($sellerId, $userName, $title, $content)
  {

    AuthSeller::sendOrderNotifications(
      $sellerId,
      $title,
      "قام العميل .$userName.$content",
    );
  }

  public function sendMails($seller, $orderDetails, $order, $page)
  {

    dispatch(new SellerJobMail($seller->toArray(), $orderDetails, $order->getOrderEmailData(), $page));
    dispatch(new UserJobMail($order->getOrderEmailData(), $orderDetails, $seller->phone_numbers, $page));
  }
}
