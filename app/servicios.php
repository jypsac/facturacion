<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
     protected $table = 'servicios';

    protected $guarded = [];

	 public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }
     public function familia(){
        return $this->belongsTo(Familia::class,'familia_id');
    }
     public function marca(){
        return $this->belongsTo(Marca::class,'marca_id');
    }
    public function tipo_afec_i_serv(){
        return $this->belongsTo(Tipo_afectacion::class,'tipo_afectacion_id');
    }
}
