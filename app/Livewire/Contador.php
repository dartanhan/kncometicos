<?php


namespace App\Livewire;


use Livewire\Component;

class Contador extends Component
{
    public $valor = 0;
    public $tem_variacao = false;

    public function incrementar()
    {
        $this->valor++;
        $this->tem_variacao = true;
    }

    public function render()
    {
        return view('livewire.contador');
    }
}
