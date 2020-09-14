<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    public function moneda(){
    	return $this->belongsTo(Moneda::class,'moneda_principal');
    }
}
