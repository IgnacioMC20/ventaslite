<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $counter = 2;

    public function render()
    {
        return view('livewire.counter');
    }

    public function chupar(){
        $this->counter++;
    }
}
