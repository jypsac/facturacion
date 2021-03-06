<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailConfiguraciones extends Model
{
	protected $table = 'email_configuraciones';

	protected $guarded = [];
   public function usuario(){
    	return $this->belongsTo(User::class,'id_usuario');
    }
}
