<?php

namespace App\Models\Order;

use App\Models\Seller\Seller;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User\Address;

class Order extends Model
{
    use HasFactory;

    protected  $fillable = [

        'comments',
        'status',
        'time_to_delevired',
        'order_log_id',
        'user_id',
        'price',
        'backup_phone_number',
        'payment_method',
        'seller_id',
        'order_number', 
        'cancelled_at',
        'user_address_id',
     
        
    ];  



    public function items(){

        return $this->hasMany(OrderItem::class);
    }

    public function logs(){

        return $this->hasOne(OrderLog::class);
    }
    public function user(){

        return $this->belongsTo(User::class);
    }


    public function seller(){


        return $this->belongsTo(Seller::class);

        
    }
    public function userAddress(){


        return $this->belongsTo(Address::class);
    }


    public function getOrderEmailData(): array
{
    return [
        
        'name' => $this->user?->name ?? null,
        'email' => $this->user->email ?? null,
        'city' => $this->userAddress?->city->name ?? null,
        'area' => $this->userAddress?->area->name ??null,
        'street' => $this->userAddress?->street ?? null,
        'phone' => $this->user?->phone ?? null,
        
    ];
} 
}
   