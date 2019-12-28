<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaGuiaIngreso extends Model
{
    protected $table = 'garantia_guia_ingreso';

    protected $guarded = [];

    public function marcas_i(){
        return $this->belongsTo(Marca::class,'marca_id');
    }

    public function personal_laborales(){
        return $this->belongsTo(Personal_datos_laborales::class,'personal_lab_id');
    }

    public function clientes_i(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    public function contactos(){
        return $this->belongsTo(Contacto::class,'cliente_id','clientes_id');
    }


}
