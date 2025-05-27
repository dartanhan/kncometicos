<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\ProdutoVariacao;
use Livewire\WithFileUploads;

class CadastroProduto extends Component
{
    use WithFileUploads;

    public $variacoes = [];
    public $categoriaSelecionada = null;
    public $subcategorias = [];
    public bool $tem_variacao = false;
    public $produto = [
        'nome' => '',
        'descricao' => '',
        'codigo_barras' => '',
        'sku' => '',
        'preco' => 0,
        'estoque' => 0,
        'subcategoria_id' => null
    ];

    protected $rules = [
        'produto.nome' => 'required|min:3',
        'produto.descricao' => 'required',
        'produto.codigo_barras' => 'required|unique:tbl_loja_produtos,codigo_barras',
        'produto.preco' => 'required|numeric|min:0',
        'produto.estoque' => 'required|integer|min:0',
        'produto.subcategoria_id' => 'required|exists:subcategorias,id',
        'variacoes.*.nome' => 'required_if:produto.tem_variacao,true',
        'variacoes.*.preco' => 'required_if:produto.tem_variacao,true|numeric|min:0',
        'variacoes.*.estoque' => 'required_if:produto.tem_variacao,true|integer|min:0',
    ];

    public function updatedCategoriaSelecionada($value)
    {
        $this->subcategorias = Subcategoria::where('categoria_id', $value)->get();
    }

    public function adicionarVariacao()
    {
        $this->variacoes[] = [
            'nome' => '',
            'sku' => '',
            'preco' => 0,
            'estoque' => 0
        ];
    }

    public function removerVariacao($index)
    {
        unset($this->variacoes[$index]);
        $this->variacoes = array_values($this->variacoes);
    }

    public function salvar()
    {
        $this->validate();

        $this->produto['tem_variacao'] = $this->tem_variacao;

        $produto = Produto::create($this->produto);

        if ($this->produto['tem_variacao']) {
            foreach ($this->variacoes as $variacao) {
                $produto->variacoes()->create($variacao);
            }
        }

        session()->flash('success', 'Produto cadastrado com sucesso!');
        return redirect()->route('produtos.index');
    }

    public function render()
    {
        $categorias = Categoria::all();

        return view('livewire.cadastro-produto', [
            'categorias' => $categorias,
            'subcategorias' => $this->subcategorias
        ]);
    }
}
