<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_venta extends Model
{
   protected $table = 'personal_ventas';

    protected $guarded = [];

    public function personal(){
        return $this->belongsTo(personal_datos_laborales::class,'id_personal');
    }
}
