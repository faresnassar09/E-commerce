<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\City;
use App\Models\Area;
class GetAreas extends Component
{

public $city_id;
public $areas;
public $selected_area;
public $cities;

public function mount(){

$this->cities = City::all();

}   
    public function render()
    {
        $this->areas = Area::where('city_id',$this->city_id)->get();

        return view('livewire.get-areas');
    }
}
