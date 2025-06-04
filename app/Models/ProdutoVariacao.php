<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutoVariacao extends Model
{
    public $table = 'tbl_loja_produto_variacoes';
    protected $fillable = ['produto_id','atributos','quantidade','preco','estoque','sku','status','nome'];

    protected $casts = [
        'atributos' => 'array',
    ];

    public function produto() {
        return $this->belongsTo(Produto::class);
    }
}
