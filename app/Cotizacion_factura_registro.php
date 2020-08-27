<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_factura_registro extends Model
{
    protected $table = 'cotizacion_factura_registro';

    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
