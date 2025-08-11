<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class Cart extends Model
{
    use HasFactory;


    public $fillable = ['product_id','user_id'];

    public function product(){

         
return $this->belongsTo(Product::class,'product_id');

    }
    
    public function getSellerAttribute()  {

        return $this->product->seller;
        
    }
}
 