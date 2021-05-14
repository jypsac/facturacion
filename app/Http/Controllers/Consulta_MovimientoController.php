<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodoConsulta_registro;
use App\PeriodoConsulta;
use App\kardex_entrada;
use App\kardex_entrada_registro;
use App\Almacen;
use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro;
use App\Categoria;
use App\Producto;
use App\Igv;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use DB;

class Consulta_MovimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias=Categoria::all();
        $almacenes=Almacen::all();
        return view('inventario.movimiento-consulta.index',compact('categorias','almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function ajax_movimiento(Request $request){
        // consultas
        // 1 = Compra 
        // 2 = Venta 
        // 3 = Compra y venta
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        //obtencion del igv
        $igv=Igv::first();
        if($categoria=="1"){
            // falta validacion si $request->consulta_p es un numero del 1 al 3
            $consulta=$request->consulta_p;
            if($consulta=="1" or $consulta=="3"){
                if($almacen != 1){
                    return "almacen no admitido";
                }
                //productos + compra------------------------------------------
                //solo permite hacer el llamado para el almacen 1
                $kardex_entradas=kardex_entrada::where('almacen_id',1)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                if (!isset($kardex_entradas)) {
                    $kardex_entradas[]="";
                }
                foreach($kardex_entradas as $kardex_entrada){
                    $kardex_entrada->igv=$igv->igv_total;
                    $kardex_entrada->subtotal=round($kardex_entrada->precio_nacional_total/(1+($igv->igv_total/100)),2);
                }
                $json=$kardex_entradas;
            }else{
                $json=[];
            }
        }elseif($categoria=="2"){
            $consulta=2;
            return "este es servicio";
        }else{
            return "categoria incorrecta";
        }
        return response(json_encode($json),200)->header('content-type','text/plain');
    }

    public function ajax_movimiento_ventas(Request $request){
        // consultas
        // 1 = Compra 
        // 2 = Venta 
        // 3 = Compara y venta
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        if($categoria=="1"){
            // falta validacion si $request->consulta_p es un numero del 1 al 3
            $consulta=$request->consulta_p;
            
            if($consulta=="2" or $consulta=="3"){
                //todos los almacenes
                if($almacen==0){
                    $factura= Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    $boleta= Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                }else{
                    //productos + venta ------------------------------------------
                    //facturacion
                    $facturaciones=Facturacion::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    foreach($facturaciones as $facturacion){
                        $factura_id[]=$facturacion->id;
                    }
                    if (!isset($factura_id)) {
                        $factura_id[]="";
                    }
                    $factura= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->get();

                    //boleta
                    $boletas=Boleta::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    foreach($boletas as $boleta){
                        $boleta_id[]=$boleta->id;
                    }
                    if (!isset($boleta_id)) {
                        $boleta_id[]="";
                    }
                    $boleta_precio_nacional= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum();
                }
                

                //union de jsons
                $json=array_merge(json_decode($factura, true),json_decode($boleta, true));
            }else{
                $json=[];
            }
        }elseif($categoria=="2"){
            $consulta=2;
            return "este es servicio";
        }else{
            return "categoria incorrecta";
        }
        
        return response(json_encode($json),200)->header('content-type','text/plain');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
