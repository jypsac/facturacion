<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Motivo;
use App\Kardex_salida;
use App\kardex_salida_registro;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use Illuminate\Http\Request;

class KardexSalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventario.kardex.salida.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $motivos=Motivo::all();
        $productos=Producto::all();
        return view('inventario.kardex.salida.create',compact('motivos','productos'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        // Validacion para ver si la cantidad es suficiente con lo requerido

        //Primer verificacion de articulos en validacion del if
        $articulo1 = $request->input('articulo');
        $count_articulo1=count($articulo1);

        $cantidad1 = $request->input('cantidad');
        $count_cantidad1=count($cantidad1);

        if($count_articulo = $count_cantidad){
            $cantidad = $request->input('cantidad');
            $count_cantidad=count($cantidad);

            $kardex_salida=new Kardex_salida();
            $kardex_salida->motivo_id=$request->get('motivo');
            $kardex_salida->informacion=$request->get('informacion');
            $kardex_salida->estado=1;
            $kardex_salida->save();

            //contador de valores de articulos (re verificacion)
            $articulo = $request->input('articulo');
            $count_articulo=count($articulo);

            $cantidad = $request->input('cantidad');
            $count_cantidad=count($cantidad);

            if($count_articulo = $count_cantidad ){
                for($i=0;$i<$count_articulo;$i++){
                    $kardex_salida_registro=new kardex_salida_registro();
                    $kardex_salida_registro->kardex_salida_id=$kardex_salida->id;
                    $kardex_salida_registro->producto_id=$request->get('articulo')[$i];
                    $kardex_salida_registro->cantidad=$request->get('cantidad')[$i];
                    $kardex_salida_registro->save();

                    $comparacion=Kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->get();
                    $cantidad=kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->sum('cantidad');

                    if(isset($comparacion)){
                        $var_cantidad_entrada=$kardex_salida_registro->cantidad;
                        $contador=0;
                        foreach ($comparacion as $p) {
                            if($p->cantidad>=$var_cantidad_entrada){
                                $cantidad_mayor=$p->cantidad;
                                $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                                $p->cantidad=$cantidad_final;
                                if($cantidad_final==0){
                                    $p->estado=0;
                                    $p->save();
                                    return "cantidad restada a cero";
                                }else{
                                    $p->save();
                                    return "cantidad restada";
                                }
                            }else{
                                $var_cantidad_entrada=$var_cantidad_entrada-$p->cantidad;
                                $p->cantidad=0;
                                $p->estado=0;
                                $p->save();
                                // $contador=$contador+$var_cantidad_entrada;
                            }
                            
                        }
                    }
                }
            }else {
                return "Error fatal comunicarse con soporte inmediatamente";
            }
        }else{
            return "Falto introducir un campo";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mi_empresa=Empresa::first();
        $kardex_salidas=Kardex_salida::find($id);
        $kardex_salidas_registros=kardex_salida_registro::where('kardex_salida_id',$id)->get();
        return view('inventario.kardex.entrada.show',compact('kardex_salidas','kardex_salidas_registros','mi_empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
