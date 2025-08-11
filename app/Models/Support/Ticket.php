<?php

namespace App\Models\Support;  

use \App\Models\Seller\Seller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;  

    public $fillable = ['seller_id','subject','message'];

    public function images(){


        return $this->hasMany(TicketImage::class);
    }


    public function replies(){

        return $this->hasMany(TicketReply::class);
    }

    public function seller(){
        
        return $this->belongsTo(Seller::class);
    }
}
