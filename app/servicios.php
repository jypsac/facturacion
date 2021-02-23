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
}
