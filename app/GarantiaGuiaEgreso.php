<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaGuiaEgreso extends Model
{
    protected $table = 'garantia_guia_egreso';

    protected $guarded = [];

    public function garantia_ingreso_i(){
        return $this->belongsTo(GarantiaGuiaIngreso::class,'garantia_ingreso_id');
    }
}
