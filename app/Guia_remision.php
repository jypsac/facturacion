<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guia_remision extends Model
{
    protected $table = 'guia_remision';

	protected $guarded = [];

	public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function user_personal(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function vehiculo(){
        return $this->belongsTo(Vehiculo::class,'vehiculo_id');
    }
     public function personal(){
        return $this->belongsTo(Personal::class,'conductor_id');
    }
     public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    }
    public function vehiculo_publicos(){
        return $this->belongsTo(TransportePublico::class,'vehiculo_publico');
    }
}