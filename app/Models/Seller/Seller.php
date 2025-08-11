<?php

namespace App\Models\Seller;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Store\Store;
use App\Models\Product\Product;
use Illuminate\Notifications\Notifiable;
use App\Models\Order\Order;
use App\Models\Support\Ticket;
use Laravel\Cashier\Billable;

class Seller extends Authenticatable
{
    use HasFactory,Notifiable,Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'phone_numbers',
        'status',

    ];

    protected $casts = [

'address' =>'array',
'password' => 'hashed',

    ];


public function stores(){


return $this->hasMany(Store::class);

}


public function products(){


    return $this->hasMany(Product::class);
    
}


public function orders(){

    return $this->hasMany(Order::class);

}


public function tickets(){


    return $this->hasMany(Ticket::class);
}


        }

