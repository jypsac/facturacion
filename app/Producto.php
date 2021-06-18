<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $guarded = [];
/*
    public function categorias(){
        return $this->belongsTo(categorias::class,'categoria_id');
    }
*/
    public function marcas_i_producto(){
        return $this->belongsTo(Marca::class,'marca_id');
    }  
    public function categoria_i_producto(){
        return $this->belongsTo(Categoria::class,'categoria_id');
    }   
    public function familia_i_producto(){
        return $this->belongsTo(Familia::class,'familia_id');
    }  
    public function moneda_i_producto(){
        return $this->belongsTo(Moneda::class,'monedas_id');
    } 
    public function estado_i_producto(){
        return $this->belongsTo(Estado::class,'estado_id');
    }
    public function unidad_i_producto(){
        return $this->belongsTo(Unidad_medida::class,'unidad_medida_id');
    }
    public function tipo_afec_i_producto(){
        return $this->belongsTo(Tipo_afectacion::class,'tipo_afectacion_id');
    }
}
