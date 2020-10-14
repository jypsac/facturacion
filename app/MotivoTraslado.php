<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class MotivoTraslado extends Model
{
	protected $table = 'motivo_traslado';

	protected $guarded = [];

    //  public function producto(){
    //     return $this->belongsTo(Producto::class,'producto_id');
    // }


}
