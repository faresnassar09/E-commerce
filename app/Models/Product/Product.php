<?php

namespace App\Models\Product;


use App\Models\Product\ProductImage;
use App\Models\Seller\Seller;
use App\Models\Store\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;



    protected $fillable = [

        'name',
        'price',
        'status',
        'discount',
        'description',
        'sold_quantity',
        'available_quantity',
        'store_id',
        'seller_id',
        'status',
        'category_id',



    ];

public function images(){

return $this->hasMany(ProductImage::class);

}

public function seller(){



return $this->belongsTo(Seller::class);

}

public  function store(){

return $this->belongsTo(Store::class);

}
  

}
