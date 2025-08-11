<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OrderActions extends Component
{

    public $id = 0;
    protected $listeners = ['refreshOrders' => '$refresh'];

    public function mount($id){

        $this->id = $id ;

    }


    public function cancel ($id){

       $order = Auth::user()->orders()->find($id)->delete();

       
       return redirect(request()->header('Referer'));



    }
    public function render()
    {
        return view('livewire.order-actions');
    }
}
