<?php

namespace App\Http\Controllers;

use App\Cotizacion;
use App\Marcas;
use App\Producto;
use App\Cliente;
use App\Forma_pago;
use App\Personal;
use App\Empresa;
use App\Cotizacion_registro;

use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $cotizacion=Cotizacion::all();
        return view('transaccion.venta.cotizacion.index',compact('cotizacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productos=Producto::all();
        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::all();
        $personales=Personal::all();
        return view('transaccion.venta.cotizacion.create',compact('productos','forma_pagos','clientes','personales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        


        //codigo para convertir nombre a producto
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id[$i]=strstr($articulos[$i], ' ', true);
        }

        //contador de valores de articulos
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        //validacion para la no incersion de dobles articulos
        for ($e=0; $e < $count_articulo; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_articulo ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial==$articulo_comparacion) {
                        return redirect()->route('cotizacion.create')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }

            }
        }

        $cotizacion=new Cotizacion;
        $cotizacion->cliente_id=$request->get('cliente');
        $cotizacion->atencion=$request->get('atencion');
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->validez=$request->get('validez');
        $cotizacion->referencia=$request->get('referencia');
        $cotizacion->personal_id=$request->get('personal');
        $cotizacion->observacion=$request->get('observacion');
        $cotizacion->save();

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        if($count_articulo = $count_cantidad ){
            for($i=0;$i<$count_articulo;$i++){
                $cotizacion_registro=new Cotizacion_registro();
                $cotizacion_registro->cotizacion_id=$cotizacion->id;
                $cotizacion_registro->producto_id=$producto_id[$i];
                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];
                $cotizacion_registro->save();
            }
        }else {
            return redirect()->route('cotizacion.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('cotizacion.show',$cotizacion->id);

        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
        $cotizacion=Cotizacion::find($id);
        $empresa=Empresa::first();

         return view('transaccion.venta.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro'));
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
