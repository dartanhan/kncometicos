<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Atributo extends Model
{
    public $table = 'tbl_loja_atributos';
    protected $fillable = ['nome'];

    public function valores() {
        return $this->hasMany(AtributoValor::class);
    }
}
