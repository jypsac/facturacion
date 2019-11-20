<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaInformeTecnico extends Model
{
    protected $table = 'garantia_informe_tecnico';

    protected $guarded = [];

    public function garantia_egreso_i(){
        return $this->belongsTo(GarantiaGuiaEgreso::class,'garantia_egreso_id');
    }

    public function marcas_i(){
        return $this->belongsTo(Marca::class,'marca_id');
    }

    //para el ingeniero asignado
    public function personal_laborales(){
        return $this->belongsTo(Personal::class,'personal_id');
    }

    //para el cliente
    public function clientes_i(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    //para el contacto del cliente
    public function contactos(){
        return $this->belongsTo(Contacto::class,'cliente_id');
    }
}
