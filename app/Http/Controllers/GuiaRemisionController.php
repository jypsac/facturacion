<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Guia_remision;
use App\Igv;
use App\Producto;
use App\Vehiculo;
use App\kardex_entrada_registro;
use Illuminate\Http\Request;

class GuiaRemisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guia_remision=Guia_remision::all();
        return view('transaccion.venta.guia_remision.index',compact('guia_remision'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        foreach ($productos as $index => $producto) {
            $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')*($producto->utilidad-$producto->descuento1)/100;
            $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')+$utilidad[$index];
            $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
            $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio');
        }

        $clientes=Cliente::all();
        $vehiculo=Vehiculo::where('estado_activo',0)->get();
        $empresa=Empresa::first();
        $igv=Igv::first();
        return view('transaccion.venta.guia_remision.create',compact('productos','clientes','array','array_cantidad','igv','array_promedio','empresa','vehiculo'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
         //id del cliente de create_2
        $id_cliente=$request->get('cliente_id');
        //Buscador Cliente
        if (isset($id_cliente)) {
           $cliente_id=$request->get('cliente_id');
        }
        else{
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);
        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();
        $cliente_id=$cliente_buscador->id;
        }
        //buscador Vehiculo
        $vehiculo_nombre=$request->get('vehiculo');
        $placa = strstr($vehiculo_nombre, '/',true);
        $vehiculo_buscador=Vehiculo::where('placa',$placa)->first();
        $vehiculo_id=$vehiculo_buscador->id;

        $guia_remision=new Guia_remision;
        $guia_remision->cod_guia='001';
        $guia_remision->cliente_id=$cliente_id;
        $guia_remision->fecha_emision=$request->get('fecha_emision');
        $guia_remision->fecha_entrega=$request->get('fecha_entrega');
        $guia_remision->vehiculo_id=$vehiculo_id;
        $guia_remision->conductor_id=$request->get('conductor');
        $guia_remision->estado_anulado='0';
        $guia_remision->estado_registrado='0';
        $guia_remision->user_id=auth()->user()->id;
        $guia_remision->save();
        return redirect()->route('guia_remision.show',$guia_remision->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $guia_remision=Guia_remision::find($id);
        $banco=Banco::all();
        $empresa=Empresa::first();

     return view('transaccion.venta.guia_remision.show',compact('empresa','banco','guia_remision'));
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return view('transaccion.venta.guia_remision.edit');
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

    public function seleccionar()
    {   
        $activos=Cotizacion::where('estado_aprovar','1')->get();

        return view('transaccion.venta.guia_remision.selecionar_cotizacion',compact('activos'));

    }
    public function cotizacion($id)

    {

        $cotizacion=Cotizacion::find($id);
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();

        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        foreach ($productos as $index => $producto) {
            $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')*($producto->utilidad-$producto->descuento1)/100;
            $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')+$utilidad[$index];
            $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
            $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio');
        }

        $clientes=Cliente::all();
        $vehiculo=Vehiculo::where('estado_activo',0)->get();
        $empresa=Empresa::first();
        $igv=Igv::first();
        return view('transaccion.venta.guia_remision.create_2',compact('cotizacion','productos','clientes','array','array_cantidad','igv','array_promedio','empresa','cotizacion_registro','vehiculo'));
    }
}