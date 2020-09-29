<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacen';

	protected $guarded = [];
	public function personal(){
        return $this->belongsTo(Personal::class,'responsable');
    }
}
