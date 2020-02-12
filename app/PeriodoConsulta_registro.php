<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoConsulta_registro extends Model
{
    protected $table = 'periodo_consulta_registro';

    protected $guarded = [];

    public function periodo_producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
