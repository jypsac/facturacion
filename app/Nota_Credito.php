<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota_Credito extends Model
{
    protected $table = 'nota_credito';

	protected $guarded = [];

    public function nota_i_facturacion(){
        return $this->belongsTo(Facturacion::class,'facturacion_id');
    }  

    public function nota_i_boleta(){
        return $this->belongsTo(Boleta::class,'boleta_id');
    } 

    // public function nota_i_factura_boleta($estado){
    //     if($estado==0){
    //         return $this->belongsTo(Facturacion::class,'facturacion_id');
    //     }else{
    //         return $this->belongsTo(Boleta::class,'boleta_id');
    //     }
    // }

}
