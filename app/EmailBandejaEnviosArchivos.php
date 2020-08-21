<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailBandejaEnviosArchivos extends Model
{
	protected $table = 'email_bandeja_envios_archivos';

	protected $guarded = [];
	// public function usuario(){
	// 	return $this->belongsTo(user::class,'id_usuario');
	// }
}
