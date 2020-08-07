<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_Servicios_factura_registro extends Model
{
    protected $table = 'cotizacion_servicio_factura_r';

	protected $guarded = [];

	public function servicio(){
        return $this->belongsTo(Servicios::class,'servicio_id');
    }
}
