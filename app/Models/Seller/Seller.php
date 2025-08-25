<?php

namespace App\Models\Seller;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\Store\Store;
use App\Models\Support\Ticket;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class Seller extends Authenticatable implements MustVerifyEmail
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

