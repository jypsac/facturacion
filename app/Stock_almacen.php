<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock_almacen extends Model
{
    protected $table = 'stock_almacen';

	protected $guarded = [];

    public static function ingreso($almacen,$producto,$cantidad){
        $stock_almacen=Stock_almacen::where('almacen_id',$almacen)->where('producto_id',$producto)->first();
        $stock_almacen->stock=$stock_almacen->stock+$cantidad;
        $stock_almacen->save();
    }

    public static function egreso($almacen,$producto,$cantidad){
        $stock_almacen=Stock_almacen::where('almacen_id',$almacen)->where('producto_id',$producto)->first();
        $stock_almacen->stock=$stock_almacen->stock-$cantidad;
        $stock_almacen->save();
    }
}
