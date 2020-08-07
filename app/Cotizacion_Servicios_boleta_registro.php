<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_Servicios_boleta_registro extends Model
{
    protected $table = 'cotizacion_servicio_boleta_r';

	protected $guarded = [];

	public function servicio(){
        return $this->belongsTo(Servicios::class,'servicio_id');
    }
}
