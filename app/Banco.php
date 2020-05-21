<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'banco';

    protected $guarded = [];

    // public function clientes(){
    //   return $this->belongsTo(Cliente::class);
    // }

    // public function clientes_i(){
    //     return $this->belongsTo(Cliente::class,'cliente_id');
    // }

}


