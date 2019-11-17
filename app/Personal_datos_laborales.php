<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_datos_laborales extends Model
{
    protected $table = 'personal_datos_laborales';

    protected $guarded = [];

    public function personal_l(){
        return $this->belongsTo(Personal::class,'personal_id');
    }
}
