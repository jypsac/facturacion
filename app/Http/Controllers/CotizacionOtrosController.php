<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Cliente;
use App\Empresa;
use App\Forma_pago;
use App\Igv;
use App\Kardex_entrada;
use App\Moneda;
use App\Personal;
use App\Producto;
use App\TipoCambio;
use App\Unidad_medida;
use App\kardex_entrada_registro;
use Illuminate\Http\Request;

class CotizacionOtrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes=Cliente::all();
        $moneda=Moneda::all();
        $forma_pagos= Forma_pago::all();
        $igv=Igv::first();
        $empresa=Empresa::first();
        return view('transaccion.venta.cotizacion.otros.create',compact('igv','empresa','clientes','forma_pagos','moneda'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // $print=$request->get('print');

       //  if($print==1){
        $banco=Banco::where('estado','0')->get();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();

         //Convertir nombre del cliente a id
        $cliente_id=$request->get('cliente');
        $nombre = strstr($cliente_id, '-',true);
        $cliente_id=Cliente::where('numero_documento',$nombre)->first();

        $user_login =auth()->user();
        $personal=Personal::where('id',$user_login->personal_id)->first();

        $codigo=$request->get('codigo');
        $fecha_emision=$request->get('fecha_emision');
        $forma_pago_id=$request->get('forma_pago');

        $moneda=$request->get('moneda');
        $moneda_id=Moneda::where('id',$moneda)->first();

        $validez=$request->get('validez');
        $garantia=$request->get('garantia');
        $observacion=$request->get('observacion');
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);
        $cantidad_p = $request->input('cantidad');

        $costo_sub_total = $request->input('costo_sub_total');
        $costo_igv = $request->input('costo_igv');
        $costo_total = $request->input('costo_total');
        $count_cantidad_p=count($cantidad_p);
        $sub_total=0;
        $igv=Igv::first();

        if (strpos($costo_total, '.') !== false) { $punto= 'true';}else{ $punto='false'; }
        if ($punto=='true') {$total = strstr($costo_total, '.',true);$final=strstr($costo_total, '.'); }
        else{ $total = $costo_total; $final = ' '; }
        $end=$total;
        $end_final=$final;

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id[$i]=strstr($articulos[$i], ' ', true);
            $producto_codigo[$i]=Producto::where('id',$producto_id[$i])->first();
        }

        for($i=0;$i<$count_articulo;$i++){
            $cantidad[]=$request->input('cantidad')[$i];
            $precio[]=$request->input('precio')[$i];
        }
        return view('transaccion.venta.cotizacion.otros.fast_print',compact('producto_codigo','sub_total','igv','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos', 'costo_sub_total','costo_igv','costo_total','personal','end','punto','end_final'));
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
