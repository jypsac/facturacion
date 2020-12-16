<?php

namespace App;

use App\Observers\TipoCambioObserver;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = 'tipo_cambio';

    protected $guarded = [];

    protected static function boot(){
    	parent::boot();
    	TipoCambio::observe(new TipoCambioObserver());
    }
}
