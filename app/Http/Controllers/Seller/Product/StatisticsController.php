<?php

namespace App\Http\Controllers\Seller\Product;

use App\Facades\AuthSeller;
use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StatisticsController extends Controller
{

private $product = null;
  

public function index(){

    $products = AuthSeller::fullInfo()->products()->with('images')->get();
    

    return view('sellers.products.statics.index',compact('products'));
    
    } 
    
    


public function  increaseQuantity (Request $request){


 $this->validationQuantity($request);


    $this->product = $this->findProduct($request->product_id);

 
 if(!$this->product){

    Log::channel('seller')->warning('⚠️ Unauthorized attempt to increase quantity: product not found.', [
        'seller_id' => Auth::guard('seller')->id(),
        'product_id' => $request->product_id,
        'ip' => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);
    

        return back()->with('failed','حدث خطاء حاول مره اخري');

    }


    $this->increase($request->quantity);




    return back()->with('success',' ✔️ تم زيادة الكمية بنجاح');

}


public function decreaseQuantity(Request $request){

    $this->validationQuantity($request);


    $this->product = $this->findProduct($request->product_id);

 
 if(!$this->product){

    Log::channel('seller')->error('trying to decrease :: product not found',[

        'seller_id' => AuthSeller::id(),
        'product_id' => $request->product_id ?? null,

    ]);
        return back()->with('failed','حدث خطاء حاول مره اخري');

    }

   $status = $this->decrease($request->quantity);

    if (!$status) {

        return back()->with('failed','تجاوزت الكمية الحالية');    
    }


    return back()->with('success','✔️  تم انقاص الكمية بنجاح');


}


public function resetQuantity(Request $request){

    $this->product = $this->findProduct($request->product_id);
  
    $this->findProduct($this->product);

if(!$this->product){


    Log::channel('seller')->error('trying to reset quantity :: product not found',[

        'seller_id' => Auth::guard('seller')->user()->id,
        'product_id' => $request->id,

    ]);
    return back()->with('failed','حدث خطاء حاول مره اخري');

}

Log::channel('seller')->info('trying to reset quantity :: quantity has been reset',[

    'seller_id' => Auth::guard('seller')->user()->id,
    'product_id' => $request->id,
    'quantity' => $this->product->available_quantity, 
    
]); 

  $this->decrease($this->product->available_quantity);


 
  return back()->with('success','تم تصفيرالكمية بنجاح');


}


private function findProduct($productId){

return Auth::guard('seller')->user()->products()->find($productId); 



} 

private function increase($quantity){
 

    $status = $this->product->increment('available_quantity',$quantity);

    Log::channel('seller')->info('product quantity has been incresed',[

        'seller_id' => AuthSeller::id(),
        'product_id' => $this->product->id,
        'quantity' => $quantity,
    ]);
  
return $status ; 


}

private function decrease($quantity){

if($this->product->available_quantity < $quantity){ 
    
    Log::channel('seller')->error('trying to decrease :: excede the currint quantity',[

        'seller_id' => AuthSeller::id(),
        'product_id' => $this->product->id,
        'product_quantity' => $this->product->available_quantity,
        'requested_decrease_quantity' => $quantity,


    ]);

    return 0;

}

    $status = $this->product->decrement('available_quantity',$quantity);

    Log::channel('seller')->error('trying to decrease :: quantity has been decreased',[

        'seller_id' => AuthSeller::id(),
        'product_id' => $this->product->id,
        'quantity' => $quantity,

    ]);

     
return $status ; 



}



private function validationQuantity($request){

return $request->validate([

        'quantity' => ['required','numeric','min:1','max:200']
        
        ],['quantity.max' => 'لا يمكنك ان تزيد او تنقص اكثر من 200 في المرة الواحده']);


}
}
