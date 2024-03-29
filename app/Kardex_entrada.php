<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kardex_entrada extends Model
{
    protected $table = 'kardex_entrada';

    protected $guarded = [];

    protected $with = ['provedor'];

    public function provedor(){
        return $this->belongsTo(Provedor::class,'provedor_id');
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    }
    public function almacen_emisor(){
        return $this->belongsTo(Almacen::class,'almacen_emisor_id');
    }
    public function almacen_receptor(){
        return $this->belongsTo(Almacen::class,'almacen_receptor_id');
    }
     public function motivo(){
        return $this->belongsTo(Motivo::class,'motivo_id');
    }
    public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }
    public function kardex_entrada_id(){
        return $this->belongsTo(kardex_entrada_registro::class,'kardex_entrada_id');
    }

}
