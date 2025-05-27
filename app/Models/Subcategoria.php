<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategoria extends Model
{
    public $table = 'tbl_loja_subcategorias';
    protected $fillable = ['nome','slug','status','categoria_id'];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function produtos(): HasMany
    {
        return $this->hasMany(Produto::class, 'subcategoria_id');
    }
}
