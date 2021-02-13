<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas_registro extends Model
{
	protected $table = 'ventas_registro';

	protected $guarded = [];

	// public function facturacion(){
	// 	return $this->belongsTo(Facturacion::class,'id_facturacion');
	// }

	public function cotizacion_pro(){
		return $this->belongsTo(Cotizacion::class,'id_coti_produc');
	}
	public function cotizacion_servi(){
		return $this->belongsTo(Cotizacion_servicio::class,'id_coti_servicio');
	}
	public function id_facturacion(){
		return $this->belongsTo(Facturacion::class,'id_fac');
	}
	public function id_boleta(){
		return $this->belongsTo(Boleta::class,'id_bol');
	}
 //    public function forma_pago(){
 //        return $this->belongsTo(forma_pago::class,'forma_pago_id');
 //    }
 //    public function personal(){
 //        return $this->belongsTo(Personal::class,'personal_id');
 //    }

}
