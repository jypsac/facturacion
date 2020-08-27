<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_Servicios extends Model
{
    protected $table = 'cotizacion_servicio';

	protected $guarded = [];

	public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago_id');
    }
    public function personal(){
        return $this->belongsTo(Personal::class,'personal_id');
    }
    public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }

    public function comisionista(){
        return $this->belongsTo(Personal_venta::class,'comisionista_id');
    }

     public function user_personal(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function aprobado(){
        return $this->belongsTo(User::class,'aprobado_por');
    }



}
