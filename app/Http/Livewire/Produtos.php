<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produto;
use Livewire\WithPagination;

class Produtos extends Component
{

    public $produtos;
    protected $listeners = ['refreshIndex' => '$refresh'];
    public $search;
    use WithPagination;

    public function render()
    {

        //$this->produtos = Produto::all();
        //return view('livewire.produtos.index')->layout('layouts.app');

        $produtos = Produtos::with('variacoes')
            ->where('nome', 'like', '%' . $this->search . '%')
            ->paginate(10);
dd("aa");
       // return view('livewire.pages.produtos',compact('produtos'));
    }
}
