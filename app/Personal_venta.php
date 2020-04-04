<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_venta extends Model
{
   protected $table = 'personal_ventas';

    protected $guarded = [];

    // public function almacen_periodo(){
    //     return $this->belongsTo(Almacen::class,'almacen_id');
    // }
}
