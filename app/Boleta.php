<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
	protected $table='boleta';

    protected $guarded=[];

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    } 

    public function cotizacion(){
        return $this->belongsTo(Cotizacion::class,'id_cotizador');
    } 

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    } 
    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago_id');
    } 
    public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    } 
    

}
