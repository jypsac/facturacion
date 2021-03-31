<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock_producto extends Model
{
    protected $table = 'stock_productos';

    protected $guarded = [];

    public static function new($producto){
        $stock_producto=new Stock_producto;
        $stock_producto->producto_id=$producto;
        $stock_producto->stock=0;
        $stock_producto->precio_nacional="0";
        $stock_producto->precio_extranjero="0";
        $stock_producto->save();
    }
}
