<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota_Credito_registro extends Model
{
    protected $table = 'nota_credito_registro';

	protected $guarded = [];

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
