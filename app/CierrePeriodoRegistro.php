<?php

namespace App;
use App\Producto;
use Illuminate\Database\Eloquent\Model;

class CierrePeriodoRegistro extends Model
{
    protected $table = 'cierre_periodo_registro';

    protected $guarded = [];
    public function producto(){
       return $this->belongsTo(Producto::class,'producto_id');
    }
}
