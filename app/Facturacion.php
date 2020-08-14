<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    protected $table = 'facturacion';

	protected $guarded = [];

	public function cotizacion(){
        return $this->belongsTo(Cotizacion::class,'id_cotizador');
    }

    public function cotizacion_servicio(){
        return $this->belongsTo(Cotizacion_Servicios::class,'id_cotizador_servicio');
    }

    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function cliente(){
        return $this->belongsTo(cliente::class,'cliente_id');
    }
     public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }

}
