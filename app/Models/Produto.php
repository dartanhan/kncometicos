<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produto extends Model
{
    public $table = 'tbl_loja_produtos';
    protected $fillable = ['nome','descricao','codigo_barras','sku','preco','estoque','tem_variacao','subcategoria_id'];

    public function variacoes(): HasMany
    {
        return $this->hasMany(ProdutoVariacao::class, 'produto_id');
    }

    public function subcategoria(): BelongsTo
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'produto_categoria', 'produto_id', 'categoria_id');
    }
}
