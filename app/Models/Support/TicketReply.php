<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{

    public $fillable = ['ticket_id','message','sender_type'];
    
public function images(){
  
    return $this->hasMany(TicketReplyImage::class);
}

    use HasFactory;
}
