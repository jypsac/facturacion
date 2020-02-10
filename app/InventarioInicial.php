<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioInicial extends Model
{
    protected $table = 'inventario_inicial';

	protected $guarded = [];
	
	 public function provedor(){
        return $this->belongsTo(Provedor::class,'provedor_id');
    }  

    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    } 
    public function motivos(){
        return $this->belongsTo(Motivo::class,'motivo_id');
    } 
}
