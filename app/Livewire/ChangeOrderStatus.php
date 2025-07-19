<?php

namespace App\Livewire;

use App\Facades\AuthSeller;
use App\Jobs\Seller\SendOrderStatusUpdateMailJob as SellerJobMail;
use App\Jobs\User\SendOrderStatusUpdateMailJob as UserJobMail;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;
use Livewire\Component;


class ChangeOrderStatus extends Component
{
 
    public $orderId;

public function mont($orderId){

    $this->orderId = $orderId;

}



public function changeStatus($status){


    $order = $this->findOrder();

    if(!$order){

        Log::channel('seller')->error('order no found',[

            'seller_id' => Auth::guard('seller')->user()->id,
            'order_id' => $this->orderId,

        ]);


        return redirect()->route('seller.orders.incaming')->with('failed','الاوردر غير موجود');

    }

   $order->update(['status' => $status , 'cancelled_at'=>now()  ]);

    $user =$order->user()->first() ; 
    $orderDetails = $order->load('items.product')->toArray();
// dd($user);
switch($status){

case 0 : $status = 'الطلب قيد التجهيز';

break;

case 1 :
    
    $status = 'تم نقل الطلب لخانة الطلبات الموصلة';
    dispatch(new SellerJobMail(AuthSeller::fullInfo()->toArray(),$orderDetails,$order->getOrderEmailData(),'delivered'));
    dispatch(new UserJobMail($user->toArray(),$orderDetails,$order->seller->phone_numbers,'delivered'));

break;

case 2 :

    $status = 'تم الغاء الطلب بنجاح';

    dispatch(new SellerJobMail(AuthSeller::fullInfo()->toArray(),$orderDetails,$order->getOrderEmailData(),'cancelled'));
    dispatch(new UserJobMail($user->toArray(),$orderDetails,$order->seller->phone_numbers,'cancelled'));

break;

case 3: $status = 'تم ارسال طلب الارجاع بنجاح';

}

Log::channel('seller')->error('order status has been changed',[


    'seller_id' => Auth::guard('seller')->user()->id,
    'order_id' => $this->orderId,
    'status' => $status,
    
]);

   return to_route('seller.orders.incoming')->with('success',$status);


      
}


    private function findOrder() {

        return Auth::guard('seller')->user()->orders()->find($this->orderId);
        
    }  


    public function render()
    {
        return view('livewire.change-order-status');
    }
}
