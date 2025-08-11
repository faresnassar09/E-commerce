<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReplyImage extends Model
{

    public $fillable = ['path'];
    
    use HasFactory;
}
