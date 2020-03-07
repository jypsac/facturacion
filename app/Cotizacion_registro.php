<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cotizacion_registro extends Model
{
    protected $table = 'cotizacion_registro';

    protected $guarded = [];

    public function producto(){
        return $this->belongsTo(producto::class,'producto_id');
    } 
}
