<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class g_remision_registro extends Model
{


    protected $table = 'g_remision_registros';

	protected $guarded = [];


     public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
}
