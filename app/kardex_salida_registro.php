<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kardex_salida_registro extends Model
{
    protected $table = 'kardex_salida_registro';

    protected $guarded = [];

     public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    } 
    
}
