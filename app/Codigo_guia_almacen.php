<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigo_guia_almacen extends Model
{
    protected $table = 'cod_guia_almacen';

    protected $guarded = [];

    public function id_almacen(){
      return $this->belongsTo(Almacen::class);
    }

}
