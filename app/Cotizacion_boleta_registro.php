<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_boleta_registro extends Model
{
    protected $table = 'cotizacion_boleta_registro';

    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
