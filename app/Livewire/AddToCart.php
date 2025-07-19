<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;

class AddToCart extends Component
{

    public $Product_id = 0;



public function mount($id){


    $this->Product_id =$id;


}

public function Store(){

    if (!auth()->check()) {

        Log::channel('user')->error('user are not loged in');

        return to_route('login');

    }elseif(DB::table('products')->where('id',$this->Product_id)->value('available_quantity') < 1){

         Log::channel('user')->warning('the product is out of stock',['productId' => $this->Product_id,'userId' => auth()->user()->id]);

        session()->flash('faildMessage','لقد نفذ المخزون هل تريد روية المتاجر القريبة التي تبيع نفس المنتج ؟');  

return;

    }elseif(Auth::user()->Cartitems()->where('product_id',$this->Product_id)->exists()){

        Log::channel('user')->warning('the product is alrady in the cartItems',['productId' => $this->Product_id,'userId' => auth()->user()->id]);

        session()->flash('notEnough','هذا المنتج موجود بالفعل اكمل الشراء من سلة المشتريات');
        return;

    }
 
    try {

        DB::table('carts')->insert([

            'product_id' => $this->Product_id,
            'user_id' => auth()->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
 
         Log::channel('user')->info('user added an item to the cart',[
            
            'product_id' => $this->Product_id,
            'user_id' => auth()->user()->id,
        ]);
        session()->flash('successMessage','تم اضافة المنتج لسلة المشتريات');

return back();

    } 

    catch (\Exception $e) {

        Log::channel('user')->error('failed to add the item to cart items',[

            'product_id' => $this->Product_id,
            'user_id' => auth()->user()->id,
            'message' => $e->getMessage(),

        ]);

        

        
    }

}
  



        
    public function render()
    {

        return view('livewire.add-to-cart');
    }
}
