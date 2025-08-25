<?php

namespace App\Livewire;

use App\Services\EmailService;
use App\Services\NotificationService;
use App\Services\User\CartItemService;
use App\Services\User\LoggingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CartItems extends Component
{
    public $cartItems;
    public $total = 0;
    public $quantities = [];
    public $selectedItems = [];
    public $comment = null;
    public $backupPhoneNumber = null;
    public $paymentMethod = null;
    public $userAddresses = null;
    public $selectedAddress = null;

    public function mount(): void
    {
        $this->cartItems =  app(CartItemService::class)->loadCartItems();  
        $this->getUserAddresses(null);


    }

    public function getUserAddresses($selectedAddress)
    {

        $this->userAddresses = app(CartItemService::class)->getUserAddresses();

        $this->selectedAddress = $selectedAddress ?? null;
    }


    public function deleteItem(int $id): void
    {
        app(CartItemService::class)->deleteItem($id);

        $this->loadCartItems();
    }

    public function placeOrder()
    {

        if (!$this->selectedAddress){

            return back()->with('failed', __('notifications.should_choose_address'));
                    
        }
        if (!app(CartItemService::class)->isValidSelection($this->selectedItems,$this->quantities)) {
            return back()->with('failed',__('notifications.inputs_not_match'));
        }

        if (!in_array($this->paymentMethod, ['cash', 'visa'])) {
            
            app(LoggingService::class)->failed('no payment method chosen',[]);
            
            return back('failed', __('notifications.should_choose_payment_method'));
        }

        $totalPrice = app(CartItemService::class)->getTotalProperty(
            $this->selectedItems,
            $this->quantities,
        );

        $data = [
            'totalPrice' => $totalPrice,
            'userAddress' => $this->selectedAddress,
            'comment' => $this->comment,
            'backupPhoneNumber' => $this->backupPhoneNumber,
            'paymentMethod' => $this->paymentMethod,
            'sellerId' => app(CartItemService::class)->getSellerId($this->selectedItems[0]),
        ];

        $order = app(CartItemService::class)->createOrder($data);

        app(CartItemService::class)->processOrderItems(
            
            $this->selectedItems,
            $this->quantities,
            $order
        );

        $user = Auth::user();
        $seller = $order->load('seller')->seller;
        $orderDetails = $order->load('items.product')->toArray();
 
        app(NotificationService::class)->notifySellerOfOrderTracking(
            $seller,
            $user->name,
            "طلب جديد",
            "بطلب أوردر. راجع صفحة الطلبات الواردة."          
        );

        app(EmailService::class)->sendOrderUserTrakingMail(

            $user,
            $orderDetails,
            $seller->phone_numbers,
            'placed',
        );

        app(EmailService::class)->sendOrderSellerTrakingMail(

            $seller->toArray(),
            $orderDetails,
            $order->getOrderEmailData(),
            'placed',
        );

        return redirect()->route('user.orders.index')->with('success',__('notifications.order_placed_successfully'));
    }

    public function render()
    {
        $this->total = app(CartItemService::class)->getTotalProperty(
            $this->selectedItems,
            $this->quantities,
        );
        return view('livewire.cart-items');
    }
}
