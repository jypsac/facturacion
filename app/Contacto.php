<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'contactos';

    protected $guarded = [];

    public function clientes(){
      return $this->belongsTo(Cliente::class);
    }

}


