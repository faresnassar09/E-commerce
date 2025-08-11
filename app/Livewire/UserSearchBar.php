<?php

namespace App\Livewire;

use App\Models\Product\Product;
use Livewire\Component;

class UserSearchBar extends Component
{


    public $query = '';
    public $products = [];


    public function updatedQuery(){

        $this->products = Product::where('name', 'like', '%' . $this->query . '%')->get();

            }


    public function render()
    {
        return view('livewire.user-search-bar');
    }
}
{}