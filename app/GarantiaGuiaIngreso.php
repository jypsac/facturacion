<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaGuiaIngreso extends Model
{
    protected $table = 'garantia_guia_ingreso';

    protected $guarded = [];

    public function marcas(){
        return $this->belongsTo(Marca::class);
    }

    public function personal_laborales(){
        return $this->belongsTo(Personal_datos_laborales::class);
    }

    public function clientes(){
        return $this->belongsTo(Cliente::class);
    }

    // public function contactos(){
    //     return $this->belongsTo(Contacto::class);
    // }
}
