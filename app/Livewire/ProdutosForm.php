<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Produto;


class ProdutosForm extends Component
{
    public $produtoId;
    public $nome, $sku, $formato = 'Simples', $tipo = 'Produto', $preco_venda, $unidade = 'Unidade', $descricao_curta;

    public function mount($produtoId = null)
    {
        $this->produtoId = $produtoId;

        if ($produtoId) {
            $produto = Produto::findOrFail($produtoId);

            $this->nome = $produto->nome;
            $this->sku = $produto->sku;
            $this->formato = $produto->formato;
            $this->tipo = $produto->tipo;
            $this->preco_venda = $produto->preco_venda;
            $this->unidade = $produto->unidade;
            $this->descricao_curta = $produto->descricao_curta;
        }
    }

    public function salvar()
    {
        $this->validate([
            'nome' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
            'formato' => 'required',
            'tipo' => 'required',
            'preco_venda' => 'required|numeric',
            'unidade' => 'required',
            'descricao_curta' => 'nullable|string',
        ]);

        $data = [
            'nome' => $this->nome,
            'sku' => $this->sku,
            'formato' => $this->formato,
            'tipo' => $this->tipo,
            'preco_venda' => $this->preco_venda,
            'unidade' => $this->unidade,
            'descricao_curta' => $this->descricao_curta,
        ];

        if ($this->produtoId) {
            Produto::find($this->produtoId)->update($data);
            session()->flash('success', 'Produto atualizado com sucesso.');
        } else {
            Produto::create($data);
            session()->flash('success', 'Produto criado com sucesso.');
        }

        return redirect()->route('produtos');
    }

    public function render()
    {
        return view('livewire.pages.produtos.form');
    }
}
