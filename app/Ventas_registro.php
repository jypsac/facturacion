<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas_registro extends Model
{
    protected $table = 'ventas_registro';

	protected $guarded = [];

	// public function cliente(){
 //        return $this->belongsTo(cliente::class,'cliente_id');
 //    } 
 //    public function forma_pago(){
 //        return $this->belongsTo(forma_pago::class,'forma_pago_id');
 //    } 
 //    public function personal(){
 //        return $this->belongsTo(Personal::class,'personal_id');
 //    } 
    
}
