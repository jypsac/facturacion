<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kardex_entrada extends Model
{
    protected $table = 'kardex_entrada';

    protected $guarded = [];

    public function provedor(){
        return $this->belongsTo(Provedor::class,'provedor_id');
    }  

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    } 

}
