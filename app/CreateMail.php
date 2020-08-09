<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreateMail extends Model
{
    public function usuario(){
    	return $this->belongsTo(user::class,'id_usuario');
    }
}
