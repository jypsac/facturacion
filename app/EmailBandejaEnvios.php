<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailBandejaEnvios extends Model
{
	protected $table = 'email_bandeja_envios';

	protected $guarded = [];
	public function usuario(){
		return $this->belongsTo(User::class,'id_usuario');
	}
}
