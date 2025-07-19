<?php

namespace App\Http\Controllers\Seller;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Jobs\Seller\SendOrderStatusUpdateMailJob as SellerJobMail;
use App\Jobs\User\SendOrderStatusUpdateMailJob as UserJobMail;
use App\Models\Seller\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


//
//
//

class OrderController extends Controller
{

    public function incoming()
    {


        $orders = $this->getOrders('created_at', 0);

        return view('sellers.orders.incoming', compact('orders'));
    }

    public function getDeliveredOrders()
    {

        $orders = $this->getOrders('updated_at', 1);

        return view('sellers.orders.delivered', compact('orders'));
    }



    public function getCanceledOrders()
    {

        $canceledOrders = $this->getOrders('cancelled_at', 2);

        return view('sellers.orders.canceled', compact('canceledOrders'));
    }

    public function getReturnRequests()
    {

        $orders = $this->getOrders('updated_at', 3);

        return view('sellers.orders.return-requests', compact('orders'));
    }

    public function acceptReturnRequest(Request $request, $id)
    {

        $order = $this->findOrder($id);

        if (!$order) {

            $this->orderNotFound();
        }

        $order->update(['status' => 5]);

        $orderDetails = $order->load('items.product');

        $user = $order->user;


        dispatch(new SellerJobMail(AuthSeller::fullInfo()->toArray(), $orderDetails, $order->getOrderEmailData(), 'returned'));
        dispatch(new UserJobMail($user->toArray(), $orderDetails, $order->seller->phone_numbers, 'returned'));

        return back();
    }


    public function rejectReturnRequest(Request $request, $id)
    {

        $order = $this->findOrder($id);

        if (!$order) {

            $this->orderNotFound();
        }

        $order->update(['status' => 4]);

        $orderDetails = $order->load('items.product');

        dispatch(new UserJobMail($order->getOrderEmailData(), $orderDetails, $order->seller->phone_numbers,'return-rejected'));


        return back();
    }


    private function getOrders($orderByColumn, $status)
    {


        return $orders = AuthSeller::fullInfo()

            ->orders()
            ->where('status', $status)
            ->orderBy($orderByColumn, 'desc')
            ->with([
            'items.product.images',
            'user',
            'log',
            'userAddress' => fn($q) => $q->with(['city', 'area'])])
            ->get();
    }

    public function findOrder($id)
    {
        return AuthSeller::fullInfo()->orders()->find($id);
    }



    public static function orderNotFound()
    {

        Log::channel('seller')->error('order not found', [

            'seller_id' => AuthSeller::id(),
            'order_id' => request('order_id'),
        ]);

        return back()->with('failed', __('messages.order_error_delete'));;
    }
}
