<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion_registro extends Model
{
    protected $table = 'facturacion_registro';

    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(producto::class,'producto_id');
    }

    public function servicio(){
        return $this->belongsTo(servicios::class,'servicio_id');
    }
}
