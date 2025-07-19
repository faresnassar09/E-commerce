<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class Cart extends Model
{
    use HasFactory;

    public function product(){

         
return $this->belongsTo(Product::class,'product_id');

    }

}
