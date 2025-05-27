<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use Livewire\WithPagination;

class ProdutoController extends Controller
{
    public $produtos;
    public $search;
    use WithPagination;
    public $abertos = []; // IDs dos produtos abertos
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produtos = Produto::with('variacoes')
            ->where('nome', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('pages.produtos',compact('produtos'));
    }

    public function cadastrar(){
        return view('pages.cadastro-produto');
    }

    public function toggle($produtoId)
    {
        if (in_array($produtoId, $this->abertos)) {
            $this->abertos = array_diff($this->abertos, [$produtoId]);
        } else {
            $this->abertos[] = $produtoId;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        //
    }
}
