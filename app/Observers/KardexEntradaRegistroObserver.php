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
        $stocks_activos = kardex_entrada_registro::where('estado',1)->get();

        foreach ($stocks_activos as $stocks_activo) {
           $productos[]=$stocks_activo->producto->id;
        }
        $prod=array_unique($productos, SORT_REGULAR);
        $count_cantidad=count($prod);

        for($x=0;$x<$count_cantidad;$x++){
            $cantidad[] = intval(kardex_entrada_registro::where('producto_id',$prod[$x])->sum('cantidad'));
        }
        // return $cantidad;
        //$prod -> los productos en orden
        //$cantidad -> obtiene el stock en orden al producto

        $kardex_almacen_principal_desc= kardex_entrada_registro::where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->get();
        $contador=0;
        $array_registros[]=0;
        // $array_registros[]=3;
        for($x=0;$x<$count_cantidad;$x++){
            while($cantidad[$x] > $contador){
                $kardex_almacen_principal_desc= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereNotIn('id',$array_registros)->get()->first();
                $contador=$contador+$kardex_almacen_principal_desc->cantidad_inicial;
                $array_registros[]=$kardex_almacen_principal_desc->id;
            }
            // return $cantidad;
            // return $kardex_almacen_principal_desc->cantidad_inicial;
            //llamar los kardex_registros que tengan los id
            $precio_nacional= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_nacional');
            $precio_extranjero= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_extranjero');
            //guardar en sotck_productos

            $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$prod[$x])->sum('cantidad');
            $stock_producto=Stock_producto::where('producto_id',$prod[$x])->first();
            $stock_producto->stock=$kardex_entrada_registros_stock;
            $stock_producto->precio_nacional=$precio_nacional;
            $stock_producto->precio_extranjero=$precio_extranjero;
            $stock_producto->save();
            unset($array_registros);
            unset($contador);
            $array_registros[]=0;
            $contador=0;
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
        $stock_productos=Stock_producto::get();
        $stocks_activos = kardex_entrada_registro::where('estado',1)->get();

        foreach ($stocks_activos as $stocks_activo) {
           $productos[]=$stocks_activo->producto->id;
        }
        $prod=array_unique($productos, SORT_REGULAR);
        $count_cantidad=count($prod);

        for($x=0;$x<$count_cantidad;$x++){
            $cantidad[] = intval(kardex_entrada_registro::where('producto_id',$prod[$x])->sum('cantidad'));
        }
        // return $cantidad;
        //$prod -> los productos en orden
        //$cantidad -> obtiene el stock en orden al producto

        $kardex_almacen_principal_desc= kardex_entrada_registro::where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->get();
        $contador=0;
        $array_registros[]=0;
        // $array_registros[]=3;
        for($x=0;$x<$count_cantidad;$x++){
            while($cantidad[$x] > $contador){
                $kardex_almacen_principal_desc= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereNotIn('id',$array_registros)->get()->first();
                $contador=$contador+$kardex_almacen_principal_desc->cantidad_inicial;
                $array_registros[]=$kardex_almacen_principal_desc->id;
            }
            // return $cantidad;
            // return $kardex_almacen_principal_desc->cantidad_inicial;
            //llamar los kardex_registros que tengan los id
            $precio_nacional= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_nacional');
            $precio_extranjero= kardex_entrada_registro::where('producto_id',$prod[$x])->where('precio_nacional',"!=",0)->orderBy('id', 'DESC')->whereIn('id',$array_registros)->avg('precio_extranjero');
            //guardar en sotck_productos

            $kardex_entrada_registros_stock=kardex_entrada_registro::where('estado',1)->where('producto_id',$prod[$x])->sum('cantidad');
            $stock_producto=Stock_producto::where('producto_id',$prod[$x])->first();
            $stock_producto->stock=$kardex_entrada_registros_stock;
            $stock_producto->precio_nacional=$precio_nacional;
            $stock_producto->precio_extranjero=$precio_extranjero;
            $stock_producto->save();
            unset($array_registros);
            unset($contador);
            $array_registros[]=0;
            $contador=0;
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
