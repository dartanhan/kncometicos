<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Request;
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
    public $descricao = "teste desc";
    public $imagemArquivo;
    public $imagemPreview;
    public $produto = [
        'nome' => '',
        'descricao' => '',
        'codigo_barras' => '',
        'sku' => '',
        'preco' => 0,
        'estoque' => 0,
        'subcategoria_id' => null,
        'quantidade' => 0
    ];

    public function temVariacao($value)
    {
       $this->tem_variacao = (bool) $value;
    }

    public function uploadTemp(Request $request)
    {
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('produtos', 'public');
            return response()->json(['path' => $path]);
        }

        return response()->json(['error' => 'Nenhum arquivo enviado'], 400);
    }

    protected function rules()
    {
        $rules = [
            'produto.nome' => 'required|min:3',
            'produto.descricao' => 'required',
            'produto.sku' => 'required|unique:tbl_loja_produtos,sku|numeric',
            'produto.codigo_barras' => 'required|unique:tbl_loja_produtos,codigo_barras',
            'produto.preco' => 'required|numeric|min:0',
            'produto.quantidade' => 'required|max:5|integer|min:0',
            'produto.estoque' => 'required|integer|min:0',
            'produto.subcategoria_id' => 'required|exists:subcategorias,id',
        ];

        if ($this->tem_variacao) {
            $rules['variacoes.*.nome'] = 'required';
            $rules['variacoes.*.preco'] = 'required|numeric|min:0';
            $rules['variacoes.*.estoque'] = 'required|integer|min:0';
        }

        return $rules;
    }



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
            'estoque' => 0,
            'quantidade' =>0
        ];
    }

    public function removerVariacao($index)
    {
        unset($this->variacoes[$index]);
        $this->variacoes = array_values($this->variacoes);
    }

    public function salvar()
    {
        $this->validate($this->rules());

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
