<?php

namespace App\Livewire;

use App\Services\User\CartItemService;
use App\Services\User\LoggingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddToCart extends Component
{
    public $productId = 0;

    public function mount($id)
    {

        $this->productId = $id;
    }

    public function Store()
    {

   try {

        if (!Auth::check()) {

            app(LoggingService::class)->failed('user are not loged in');

            return to_route('login');

        } elseif (!app(CartItemService::class)->checkProductAvilableQuantity(

            $this->productId
            
            )) {

                app(LoggingService::class)->warning('the product is out of stock',[

                    'productId' => $this->productId,
            ]);

            return back()->with(

                'failed',
                __('notification.product_quantity_out_of_stuck')
            );


        } elseif (app(CartItemService::class)->checkIfAlreadyExists($this->productId)) {

            app(LoggingService::class)->warning('the product is alrady in the cartItems',[

                'productId' => $this->productId,
            ]);

            return back()->with('success',__('notifications.product_already_exists'));
        }

        app(CartItemService::class)->addItemTocart($this->productId);

            return back()->with('success',__('notifications.product_added_to_cart_items'));

        } catch (\Exception $e) {

            app(LoggingService::class)->failed('failed to add the item to cart items',[

                'product_id' => $this->productId,
                'exception_details' => $e->getMessage(),
            ]);

            return back()->with('failed',__('notifications.add_product_to_cart_items_failed'));


        }
    }

    public function render()
    {

        return view('livewire.add-to-cart');
    }
}
