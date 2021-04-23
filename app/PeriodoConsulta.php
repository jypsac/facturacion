<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeriodoConsulta extends Model
{
    protected $table = 'periodo_consulta';

    protected $guarded = [];

    public function almacen_periodo(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
