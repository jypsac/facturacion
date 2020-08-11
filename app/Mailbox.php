<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
	protected $table = 'mailboxes';

	protected $guarded = [];
	public function usuario(){
		return $this->belongsTo(user::class,'id_usuario');
	}
}
