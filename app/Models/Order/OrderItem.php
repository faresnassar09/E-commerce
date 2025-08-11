<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;
class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [

        'order_id',
        'product_id',
        'quantity',
        'price',

    ];


    public function product(){


        return $this->belongsTo(Product::class,'product_id','id');
    }


}
