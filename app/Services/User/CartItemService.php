<?php

namespace App\Services\User;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\User\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartItemService
{

    public function checkProductAvilableQuantity($productId)
    {

        $availabeQuantity = Product::find($productId)->value('available_quantity');


        if ($availabeQuantity < 1) {

            return false;
        }

        return true;
    }

    public function checkIfAlreadyExists($productId)
    {

        $product = Auth::user()->Cartitems()->where('product_id', $productId)->exists();

        if (!$product) {

            return false;
        }

        return true;
    }

    public function addItemTocart($productId){

    Auth::user()->cartItems()->create([

            'product_id' => $productId,
            'user_id' => Auth::id(),

        ]);
        
    }


    public function getUserAddresses() {

        return Auth::user()->addresses()->with('city', 'area')->get();
        
    }

    public function deleteItem($id)  {

        Cart::destroy($id);

    }

    public function  createOrder($data)  {


       return  Auth::user()->orders()->create([
 
            'user_address_id' => $data['userAddress'],
            'status' => 0,
            'price' => $data['totalPrice'],
            'time_to_delevired' => now()->addDay(),
            'comments' => $data['comment'],
            'backup_phone_number' => $data['backupPhoneNumber'],
            'payment_method' => $data['paymentMethod'],
            'seller_id' => $data['sellerId'],
            'order_number' => now()->format('YmdHis') . mt_rand(10000, 99999),
        ]);
        
    }

    private function getProduct($itemId){

        return Cart::with('product')->find($itemId);
        
    }

    private function increaseQuantity($product,$quantity){

        $product->increment('sold_quantity', $quantity);
    }

    private function createItem($order,$productId,$price,$quantity){

        $order->items()->create([
            'product_id' => $productId,
            'price' => $price,
            'quantity' => $quantity,
        ]);
        
    }

    private function decreaseQuantity($product,$quantity) {

        $product->decrement('available_quantity', $quantity);

    }
    public function processOrderItems($selectedItems,$quantities,Order $order)
    {
        foreach ($selectedItems as $itemId) {

            $cartItem = $this->getProduct($itemId) ;

            if (!$cartItem || !$cartItem->product) {
                continue;
            }

            $quantity = $quantities[$itemId];

            $this->increaseQuantity($cartItem->product,$quantity);
            $this->decreaseQuantity($cartItem->product,$quantity);

            $this->createItem(
                $order,$cartItem->product->id,
                ($cartItem->product->price - $cartItem->product->discount) * $quantity,
                $quantity
            );
  
        }
    }


    public function getSellerId($item): ?int
    {
        $cartItem = Cart::find($item);
        return $cartItem->seller->id;
    }


    
    public function loadCartItems()
    {
       $user = Auth::user()->load('cartItems.product.images');

        return $user->cartItems;
    }

    public  function isValidSelection($items,$quqntity): bool
    {
        Log::channel('user')->error('Mismatch in selected items and quantities', [$items]);

    
        $valid = count($items) > 0 && count($items) === count($quqntity);

        if (!$valid) {
            Log::channel('user')->error('Mismatch in selected items and quantities', [
                'selected_items_count' => count($items),
                'selected_items_quantity' => count($quqntity),
                'user_id' => auth()->id(),
                'cart_items_ids' => $items,
            ]);
        }

        return $valid;
    }


    public function getTotalProperty($selectedItems,$quantities): float
    {
        return Cart::whereIn('id', $selectedItems)->get()->sum(function ($item) use ($quantities) {
            $qty = $quantities[$item->id] ?? $item->quantity;
            return ($item->product->price - $item->product->discount) * $qty;
        });
    }

}
