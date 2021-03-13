<?php

namespace App\Observers;

use App\Stock_producto;
use App\kardex_entrada_registro;
class StockProductosObserver
{
    /**
     * Handle the stock_producto "created" event.
     *
     * @param  \App\Stock_producto  $stockProducto
     * @return void
     */
    public function created(Stock_producto $stockProducto)
    {
        // Tipo de cambio -------------------------------------------------------------------------------------
        $stock_productos=Stock_producto::get();
        foreach($stock_productos as $stock_producto){
            $kardex_entrada_registros_pn=kardex_entrada_registro::where('estado',1)->where('producto_id',$stock_producto->producto_id)->avg('precio_nacional');
            $kardex_entrada_registros_ex=kardex_entrada_registro::where('estado',1)->where('producto_id',$stock_producto->producto_id)->avg('precio_extranjero');
            $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$stock_producto->producto_id)->sum('cantidad');
            $stock_producto->stock=$kardex_entrada_registros_stock;
            $stock_producto->precio_nacional=$kardex_entrada_registros_pn;
            $stock_producto->precio_extranjero=$kardex_entrada_registros_ex;
            $stock_producto->save();
        }

    }

    /**
     * Handle the stock_producto "updated" event.
     *
     * @param  \App\Stock_producto  $stockProducto
     * @return void
     */
    public function updated(Stock_producto $stockProducto)
    {
        //
    }

    /**
     * Handle the stock_producto "deleted" event.
     *
     * @param  \App\Stock_producto  $stockProducto
     * @return void
     */
    public function deleted(Stock_producto $stockProducto)
    {
        //
    }

    /**
     * Handle the stock_producto "restored" event.
     *
     * @param  \App\Stock_producto  $stockProducto
     * @return void
     */
    public function restored(Stock_producto $stockProducto)
    {
        //
    }

    /**
     * Handle the stock_producto "force deleted" event.
     *
     * @param  \App\Stock_producto  $stockProducto
     * @return void
     */
    public function forceDeleted(Stock_producto $stockProducto)
    {
        //
    }
}
