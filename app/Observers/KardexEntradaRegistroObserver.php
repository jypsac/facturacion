<?php

namespace App\Observers;

use App\kardex_entrada_registro;
use App\Stock_producto;
class KardexEntradaRegistroObserver
{
    /**
     * Handle the kardex_entrada_registro "created" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function created(kardex_entrada_registro $kardexEntradaRegistro)
    {

        // Tipo de cambio -------------------------------------------------------------------------------------
        $stock_productos=Stock_producto::get();
        foreach($stock_productos as $stock_producto){
            $kardex_entrada_registros_pn=kardex_entrada_registro::where('estado',1)->where('tipo_registro_id',1)->where('producto_id',$stock_producto->producto_id)->avg('precio_nacional');
            $kardex_entrada_registros_ex=kardex_entrada_registro::where('estado',1)->where('tipo_registro_id',1)->where('producto_id',$stock_producto->producto_id)->avg('precio_extranjero');
            $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$stock_producto->producto_id)->sum('cantidad');
            $stock_producto->stock=$kardex_entrada_registros_stock;
            $stock_producto->precio_nacional=$kardex_entrada_registros_pn;
            $stock_producto->precio_extranjero=$kardex_entrada_registros_ex;
            $stock_producto->save();
        }

    }

    /**
     * Handle the kardex_entrada_registro "updated" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function updated(kardex_entrada_registro $kardexEntradaRegistro)
    {
         // Tipo de cambio -------------------------------------------------------------------------------------
         $stock_productos=Stock_producto::get();
         $stocks_activos = kardex_entrada_registro::where('estado',1)->get();
         foreach ($stocks_activos as $num => $stocks_activo) {
            $clave = array_search('verde', $array_producto);
            if($clave){
                $array_producto[] = array("producto"=>$stocks_activo->producto_id,"cantidad"=>$stocks_activo->cantidad);
            }else{
                $array_producto[] = array("producto"=>$stocks_activo->producto_id,"cantidad"=>$stocks_activo->cantidad);
            }
            
         }
         json_encode($array);

         $stocks_p=stocks_activo::get();
         $array2[] = array("producto"=>$stocks_activo->producto_id,"cantidad"=>$stocks_activo->cantidad);

         $array_reversa = array_reverse($stock_productos);
         foreach($stock_productos as $stock_producto){
             $kardex_entrada_registros_pn=kardex_entrada_registro::where('precio_nacional','!=',0)->where('tipo_registro_id',1)->where('producto_id',$stock_producto->producto_id)->avg('precio_nacional');

             $kardex_entrada_registros_ex=kardex_entrada_registro::where('precio_extranjero','!=',0)->where('tipo_registro_id',1)->where('producto_id',$stock_producto->producto_id)->avg('precio_extranjero');
             $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$stock_producto->producto_id)->sum('cantidad');
             $stock_producto->stock=$kardex_entrada_registros_stock;
             $stock_producto->precio_nacional=$kardex_entrada_registros_pn;
             $stock_producto->precio_extranjero=$kardex_entrada_registros_ex;
             $stock_producto->save();
         }
    }

    /**
     * Handle the kardex_entrada_registro "deleted" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function deleted(kardex_entrada_registro $kardexEntradaRegistro)
    {
        //
    }

    /**
     * Handle the kardex_entrada_registro "restored" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function restored(kardex_entrada_registro $kardexEntradaRegistro)
    {
        //
    }

    /**
     * Handle the kardex_entrada_registro "force deleted" event.
     *
     * @param  \App\kardex_entrada_registro  $kardexEntradaRegistro
     * @return void
     */
    public function forceDeleted(kardex_entrada_registro $kardexEntradaRegistro)
    {
        //
    }
}
