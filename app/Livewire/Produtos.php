<?php

namespace App\Livewire;

use App\Models\Produto;
use App\Models\ProdutoVariacao;
use Livewire\Component;
use Livewire\WithPagination;

class Produtos extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';
    public $editingId = null;
    public $editData = [];
    public $expanded = [];
    public $expandedProdutoId = null;
    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleVariacoes($id)
    {
        $this->expanded[$id] = !($this->expanded[$id] ?? false);
        $this->expandedProdutoId = $this->expandedProdutoId === $id ? null : $id;
    }

    public function startEdit($tipo, $id)
    {
        $this->editingId = $tipo . '-' . $id;
        $item = $tipo === 'pai' ? Produto::find($id) : ProdutoVariacao::find($id);
        $this->editData = [
            'nome' => $item->nome,
            'preco' => $item->preco,
            'sku' => $item->sku,
            'estoque' => $item->estoque,
        ];
    }

    public function saveEdit($tipo, $id)
    {
        $item = $tipo === 'pai' ? Produto::find($id) : ProdutoVariacao::find($id);
        $item->update($this->editData);
        $this->editingId = null;
        $this->editData = [];
        $this->dispatch('notify', 'Produto atualizado com sucesso!');
    }

    public function render()
    {
        $produtos = Produto::with(['variacoes' => function ($query) {
            $query->where('nome', 'like', '%' . $this->search . '%')
                ->orWhere('sku', 'like', '%' . $this->search . '%');
        }])
            ->where(function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%')
                    ->orWhereHas('variacoes', function ($subquery) {
                        $subquery->where('nome', 'like', '%' . $this->search . '%')
                            ->orWhere('sku', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate($this->perPage); // Paginação

        return view('livewire.produtos', compact('produtos'));
    }
}
