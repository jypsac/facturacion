<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion_registro extends Model
{
    protected $table = 'facturacion_registro';

    protected $guarded = [];

    protected $with = ['producto'];

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

    public function servicio(){
        return $this->belongsTo(Servicios::class,'servicio_id');
    }
    public function factura_ids(){
        return $this->belongsTo(Facturacion::class,'facturacion_id');
    }
}
