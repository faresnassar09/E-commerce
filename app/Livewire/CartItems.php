<?php

namespace App\Livewire;

use App\Facades\AuthSeller;
use App\Jobs\Seller\SendOrderStatusUpdateMailJob as SellerJobMail;
use App\Jobs\User\SendOrderStatusUpdateMailJob  as UserJobMail;
use App\Models\Order\Order;
use App\Models\User\Cart;
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
        $this->loadCartItems();
        $this->getUserAddresses(null);
    }


    public function getUserAddresses($selectedAddress)
    {

        $this->userAddresses = Auth::user()->addresses()->with('city', 'area')->get();

        $this->selectedAddress = $selectedAddress ?? null;
    }

    public function getTotalProperty(): float
    {
        return Cart::whereIn('id', $this->selectedItems)->get()->sum(function ($item) {
            $qty = $this->quantities[$item->id] ?? $item->quantity;
            return ($item->product->price - $item->product->discount) * $qty;
        });
    }

    public function deleteItem(int $id): void
    {
        Cart::destroy($id);
        $this->loadCartItems();
    }

    public function placeOrder()
    {

        if (!$this->selectedAddress){

            return back()->with('faildMessage', 'يجب ان تحدد عنوان اذا لم تضف عنوان بعد اضغط علي اضافة عنوان');
                    
        }
        if (!$this->isValidSelection()) {
            return back()->with('faildMessage', 'عندما تحدد عنصر يجب ان تختار الكمية و عندما تختار كمية يجب ان تحدد عنصر');
        }

        if (!$this->isValidSelection()) {
            return back()->with('faildMessage', 'عندما تحدد عنصر يجب ان تختار الكمية و عندما تختار كمية يجب ان تحدد عنصر');
        }

        if (!in_array($this->paymentMethod, ['cash', 'visa'])) {
            Log::channel('user')->error("Payment method not selected", ['user_id' => auth()->id()]);
            session()->flash('faildMessage', 'يجب تحديد طريقة الدفع');
            return;
        }

        $totalPrice = $this->getTotalProperty();
        $order = $this->createOrder($totalPrice);
        $this->processOrderItems($order);

        $user = Auth::user();
        $sellerDetails = $order->load('seller')->seller->toArray();
        $orderDetails = $order->load('items.product')->toArray();

        if (!$sellerDetails) {
            Log::channel('user')->warning('No seller found for the order', ['user_id' => $user->id, 'order_id' => $order->id]);
            return;
        }



        dispatch(new SellerJobMail($sellerDetails, $orderDetails, $order->getOrderEmailData(), 'placed'));
        dispatch(new UserJobMail($order->getOrderEmailData(), $orderDetails, $sellerDetails['phone_numbers'], 'placed'));
        AuthSeller::sendOrderNotifications($sellerDetails['id'], "طلب جديد", "قام العميل {$user->name} بطلب أوردر. راجع صفحة الطلبات الواردة.");

        return redirect()->route('user.orders.index')->with('success', 'لقد قمت بحجز الطلب بنجاح');
    }

    protected function isValidSelection(): bool
    {
        $valid = count($this->selectedItems) > 0 && count($this->selectedItems) === count($this->quantities);

        if (!$valid) {
            Log::channel('user')->error('Mismatch in selected items and quantities', [
                'selected_items_count' => count($this->selectedItems),
                'selected_items_quantity' => count($this->quantities),
                'user_id' => auth()->id(),
                'cart_items_ids' => $this->selectedItems,
            ]);
        }

        return $valid;
    }

    

    protected function createOrder(float $totalPrice): Order
    {
        return Order::create([
            'user_id' => auth()->id(),
            'user_address_id' => $this->selectedAddress,
            'status' => 0,
            'price' => $totalPrice,
            'time_to_delevired' => now()->addDay(),
            'comments' => $this->comment,
            'backup_phone_number' => $this->backupPhoneNumber,
            'payment_method' => $this->paymentMethod,
            'seller_id' => $this->getSellerId(),
            'order_number' => now()->format('YmdHis') . mt_rand(10000, 99999),
        ]);
    }

    protected function processOrderItems(Order $order): void
    {
        foreach ($this->selectedItems as $itemId) {
            $cartItem = Cart::with('product')->find($itemId);

            if (!$cartItem || !$cartItem->product) {
                continue;
            }

            $quantity = $this->quantities[$itemId];

            $cartItem->product->decrement('available_quantity', $quantity);
            $cartItem->product->increment('sold_quantity', $quantity);

            $order->items()->create([
                'product_id' => $cartItem->product->id,
                'price' => ($cartItem->product->price - $cartItem->product->discount) * $quantity,
                'quantity' => $quantity,
            ]);
        }
    }

    protected function getSellerId(): ?int
    {
        $cartItem = Cart::with('product.seller')->find($this->selectedItems[0]);
        return $cartItem->product->seller->id ?? null;
    }

    protected function loadCartItems(): void
    {
        $this->cartItems = Cart::with('product.images')->where('user_id', auth()->id())->get();
    }


    public function render()
    {
        $this->total = $this->getTotalProperty();
        return view('livewire.cart-items');
    }
}
