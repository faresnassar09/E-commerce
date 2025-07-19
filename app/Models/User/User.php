<?php

namespace App\Models\User;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Order\Order;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;



public function orders(){


return $this->hasMany(Order::class); 

}




    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
  
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',

    ];


public function cartItems(){


    return $this->hasMany(Cart::class);
}




 public function addresses(){

return $this->hasMany(Address::class);

 }

public function getCityNameAttribute()
{
    $cityId = $this->address['city_id'] ?? null;
    return \App\Models\City::find($cityId)?->name;
}

public function getAreaNameAttribute()
{
    $areaId = $this->address['area_id'] ?? null;
    return \App\Models\Area::find($areaId)?->name;
}

}
