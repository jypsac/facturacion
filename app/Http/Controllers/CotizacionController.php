<?php

namespace App\Http\Controllers;

use App\Cotizacion;
use App\Marcas;
use App\Producto;
use App\Cliente;
use App\Forma_pago;
use App\Personal;
use App\Moneda;
use App\Empresa;
use App\Cotizacion_factura_registro;
use App\kardex_entrada_registro;
use App\Igv;
use App\User;
use App\Personal_venta;

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
    public function create_factura()
    {
        $productos=Producto::where('estado_id',1)->where('estado_anular',1)->get();

        foreach ($productos as $index => $producto) {
            $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')*($producto->utilidad-$producto->descuento1)/100;
            $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')+$utilidad[$index];
            $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::all();
        $moneda=Moneda::all();
        $personales=Personal::all();
        $p_venta=Personal_venta::all();
        $igv=Igv::first();

        return view('transaccion.venta.cotizacion.factura.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_factura(Request $request)
    {
        //El input esta activo

        // return $request;

        $print=$request->get('print');
        if($print==1){
            $cliente_id=$request->get('cliente');
            // $atencion=$request->get('atencion');
            $forma_pago_id=$request->get('forma_pago');
            $moneda_id=$request->get('moneda');
            $validez=$request->get('validez');
            $garantia=$request->get('garantia');
            $user_id =auth()->user()->id;
            $observacion=$request->get('observacion');

            $articulo = $request->input('articulo');
            $count_articulo=count($articulo);

            $cantidad_p = $request->input('cantidad');
            $count_cantidad_p=count($cantidad_p);

            for($i=0 ; $i<$count_cantidad_p;$i++){
                $articulos[$i]= $request->input('articulo')[$i];
                $producto_id[$i]=strstr($articulos[$i], ' ', true);
            }

            for($i=0;$i<$count_articulo;$i++){
                
                $cantidad[]=$request->input('cantidad')[$i];
                $check_descuento[]=$request->input('check_descuento')[$i];
            }

            return view('transaccion.venta.cotizacion.fast_print',compact('cliente_id','forma_pago_id','validez','referencia','user_id','observacion','producto_id','cantidad','check_descuento'));
        }

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
                        return redirect()->route('cotizacion.create_factura')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }

            }
        }
        // Comisionista cob¿nvertir id

        $comisionista=$request->get('comisionista');
        $numero = strstr($comisionista, '-',true);
        $numero_doc=personal::where('numero_documento',$numero)->first();
        $id_personal=$numero_doc->id;
        $comisionista_buscador=Personal_venta::where('id_personal',$id_personal)->first();


        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);

        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();
        // return $cliente_buscador->id;

        $cotizacion=new Cotizacion;
        $cotizacion->cliente_id=$cliente_buscador->id;
        // $cotizacion->atencion=$request->get('atencion');
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->validez=$request->get('validez');
        $cotizacion->moneda_id=$request->get('moneda');
        $cotizacion->garantia=$request->get('garantia');
        $cotizacion->user_id =auth()->user()->id;
        $cotizacion->observacion=$request->get('observacion');
        $cotizacion->comisionista_id= $comisionista_buscador->id;
        $cotizacion->estado='0';
        $cotizacion->estado_vigente='0';
        $cotizacion->save();


        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores del check descuento
        $check = $request->input('check_descuento');
        $count_check=count($check);

        if($count_articulo = $count_cantidad  = $count_check){
            for($i=0;$i<$count_articulo;$i++){
                $cotizacion_registro=new Cotizacion_factura_registro();
                $cotizacion_registro->cotizacion_id=$cotizacion->id;
                $cotizacion_registro->producto_id=$producto_id[$i];

                $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
                $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio')*($producto->utilidad-$producto->descuento1)/100;
                $array=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio')+$utilidad;
                $desc_comprobacion=$request->get('check_descuento')[$i];
                $cotizacion_registro->precio=$array;
                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];
                $cotizacion_registro->descuento=$request->get('check_descuento')[$i];
                if($desc_comprobacion <> 0){
                    $cotizacion_registro->precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                }else{
                    $cotizacion_registro->precio_unitario_desc=$array;
                }
                
                $cotizacion_registro->save();
            }
        }else {
            return redirect()->route('cotizacion.create_factura')->with('campo', 'Falto introducir un campo de la tabla productos');
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
        $moneda=Moneda::where('principal',1)->first();
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
        foreach ($cotizacion_registro as $cotizacion_registros) {
             $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
        }
        
        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
        $cotizacion=Cotizacion::find($id);
        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;

         return view('transaccion.venta.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro','sum','igv',"array","sub_total","moneda"));
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

    // public function fast_print(Request $request){
    //     $atencion=$request->get('atencion');
    //     return view('transaccion.venta.cotizacion.fast_print',compact('atencion'));
    // }
}
