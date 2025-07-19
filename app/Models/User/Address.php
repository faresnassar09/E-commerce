<?php

namespace App\Models\User;

use App\Models\Area;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory; 

public $table = 'user_addresses';

    public $fillable = [

        'street',
        'city_id',
        'area_id' ,

      ];
    public function city(){


        return $this->belongsTo(City::class);
    }

    public function area(){


        return $this->belongsTo(Area::class);
    }
 
}