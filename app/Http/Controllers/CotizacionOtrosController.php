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
use Barryvdh\DomPDF\Facade as PDF;
use App\Producto;
use App\TipoCambio;
use App\Unidad_medida;
use Carbon\Carbon;
use App\kardex_entrada_registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $productos=Producto::all();
        $empresa=Empresa::first();
        return view('transaccion.venta.cotizacion.otros.create',compact('igv','empresa','clientes','forma_pagos','moneda','productos'));

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
        /*IMPRENSION*/
       //  if($print==1){
        $name = $request->get('name');

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
        if ($name=='print') {
           return view('transaccion.venta.cotizacion.otros.print',compact('producto_codigo','sub_total','igv','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos', 'costo_sub_total','costo_igv','costo_total','personal','end','punto','end_final'));
       }
       elseif ($name=='pdf'){
         $pdf=PDF::loadView('transaccion.venta.cotizacion.otros.pdf',compact('producto_codigo','sub_total','igv','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos', 'costo_sub_total','costo_igv','costo_total','personal','end','punto','end_final'));
         return $pdf->download('COTPF 001-0000000'.$codigo.'.pdf');
     }
     elseif ($name=='correo'){
        $date_sp = Carbon::now();
        $data_g = str_replace(' ', '_',$date_sp);
        $carbon_sp = str_replace(':','-',$data_g);
        $date = $carbon_sp;
         $redic='mailbox';
         $clientes=$cliente_id->email;
         $rutapdf = 'transaccion.venta.cotizacion.pdf';
         $name = 'COTPF 001-0000000';

           // return $cotizacion;
         $archivo=$name.$codigo.".pdf";
         $pdf=PDF::loadView('transaccion.venta.cotizacion.otros.pdf',compact('producto_codigo','sub_total','igv','cliente_id','forma_pago_id','validez','observacion','producto_id','cantidad','precio','codigo','fecha_emision','moneda_id','garantia','empresa','banco','banco_count','articulos', 'costo_sub_total','costo_igv','costo_total','personal','end','punto','end_final'));
          $especif = $carbon_sp.$archivo;
         $contenido=$pdf->download();
         Storage::disk($redic)->put($especif,$contenido);


       // $archivo=$especif;
            // \Storage::disk('mailbox')->put( $especif ,  \File::get($file));

        // Storage::disk('mailbox')->put($especif,$content);
        // $date = $carbon_sp;

         return view('mailbox.create',compact('archivo','clientes','redic','date'));
     }

        // }
 }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

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
