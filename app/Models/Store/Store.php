<?php

namespace App\Models\Store;

use App\Models\Area;
use App\Models\City;
use App\Models\Product\Product;
use App\Models\Seller\Seller;
use App\Models\Store\StoreImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;


protected $fillable = [

    'name',
    'description',
    'seller_id',
    'image',
    'city_id',
    'area_id',
    'street',
    'status',

];

public function images(){

return $this->hasMany(StoreImage::class);

}

public function products(){

    return  $this->hasMany(Product::class);

}


public function city(){

return $this->belongsTo(City::class);

}

public function area(){

    return $this->belongsTo(Area::class);
    
    }

    public function seller(){

        return $this->belongsTo(Seller::class);
    }
    
    public function getCityNameAttribute(){

   
        return $this->city->name;

    }
    public function getAreaNameAttribute(){

        return $this->area->name;
    }

}
