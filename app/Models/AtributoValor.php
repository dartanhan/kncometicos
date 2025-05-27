<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AtributoValor extends Model
{
    public $table = 'tbl_loja_atributo_valores';
    protected $fillable = ['atributo_id', 'valor'];

    public function atributo() {
        return $this->belongsTo(Atributo::class);
    }
}
