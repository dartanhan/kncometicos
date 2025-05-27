<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public $table = 'tbl_loja_categorias';
    protected $fillable = ['nome','slug','status'];

    public function subcategorias(): HasMany
    {
        return $this->hasMany(Subcategoria::class);
    }
}
