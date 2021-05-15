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
                if($almacen == 0){
                    //productos + compra------------------------------------------
                    //solo permite hacer el llamado para el almacen 1
                    $kardex_entradas=kardex_entrada::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    if (!isset($kardex_entradas)) {
                        $kardex_entradas[]="";
                    }
                    foreach($kardex_entradas as $kardex_entrada){
                        $kardex_entrada->igv=$igv->igv_total;
                        $kardex_entrada->subtotal=round($kardex_entrada->precio_nacional_total/(1+($igv->igv_total/100)),2);
                    }
                    $json=$kardex_entradas;
                }else{
                    //productos + compra------------------------------------------
                    //solo permite hacer el llamado para el almacen 1
                    $kardex_entradas=kardex_entrada::where('almacen_id',1)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    $total=0;
                    $igv_t=0;
                    $subtotal=0;
                    $jsons=0;
                    if (!isset($kardex_entradas)) {
                        $kardex_entradas[]="";
                    }
                    foreach($kardex_entradas as $kardex_entrada){
                        $kardex_entrada->subtotal=round($kardex_entrada->precio_nacional_total/(1+($igv->igv_total/100)),2);
                        $kardex_entrada->igv=round($kardex_entrada->precio_nacional_total-$kardex_entrada->subtotal,2);
                        $total=$total+$kardex_entrada->precio_nacional_total;
                        $igv_t=$igv_t+$kardex_entrada->igv;
                        $subtotal=$subtotal+$kardex_entrada->subtotal;
                        $jsons++;
                    }
                    $data_extra[$jsons]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);
                    // $data_extra='{"fecha_compra" : 0,"codigo_guia" => "","provedor_id"=>"", "factura"=>"" , "subtotal" => $subtotal , "igv" => $igv_t , "precio_nacional_total"=>$total}';
                    // json_encode($data_extra);    
                    // foreach($kardex_entradas as $kardex_entrada){
                    //     $kardex_entrada->totales=$total;
                    //     $kardex_entrada->igv_total=$igv_t;
                    //     $kardex_entrada->subtotal_total=$subtotal;
                    // }

                    $json=array_merge(json_decode($kardex_entradas, true),$data_extra );
                    // $json=$kardex_entradas;
                }
                
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
        // return $request;
        // consultas
        // 1 = Compra 
        // 2 = Venta 
        // 3 = Compara y venta
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        //obtencion del igv
        $igv=Igv::first();
        if($categoria=="1"){
            // falta validacion si $request->consulta_p es un numero del 1 al 3
            $consulta_s=$request->consulta_s;
            $consulta_p=$request->consulta_p;
            if($consulta_s=="0" and $consulta_p=="0"){
                return "consulta 0";
            }
            
            if($consulta_s=="1" or $consulta_p=="2" or $consulta_p=="3"){
                //todos los almacenes
                if($almacen==0){
                    $facturaciones= Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    foreach($facturaciones as $facturacion){
                        $factura_id[]=$facturacion->id;
                        $factura_precio= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('precio');
                        $facturacion->precio=$factura_precio;
                        
                        $facturacion->subtotal=round($facturacion->precio/(1+($igv->igv_total/100)),2);
                        $facturacion->igv=$facturacion->precio-$facturacion->subtotal;
                    }
                }else{
                    //productos + venta ------------------------------------------
                    //facturacion
                    $facturaciones=Facturacion::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    foreach($facturaciones as $facturacion){
                        $factura_id[]=$facturacion->id;
                        $factura_precio= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('precio');
                        $facturacion->precio=$factura_precio;
                        
                        $facturacion->subtotal=round($facturacion->precio/(1+($igv->igv_total/100)),2);
                        $facturacion->igv=$facturacion->precio-$facturacion->subtotal;
                    }
                    if (!isset($factura_id)) {
                        $factura_id[]="";
                    }
                }
                //union de jsons
                // $json=array_merge(json_decode($facturaciones, true),json_decode($boletas, true));
                $json=array_merge(json_decode($facturaciones, true));
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

    public function ajax_movimiento_ventas_b(Request $request){
        // consultas
        // 1 = Compra 
        // 2 = Venta 
        // 3 = Compara y venta
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        //obtencion del igv
        $igv=Igv::first();
        if($categoria=="1"){
            // falta validacion si $request->consulta_p es un numero del 1 al 3
            $consulta_s=$request->consulta_s;
            $consulta_p=$request->consulta_p;
            if($consulta_s=="0" and $consulta_p=="0"){
                return "consulta 0";
            }
            
            if($consulta_s=="1" or $consulta_p=="2" or $consulta_p=="3"){
                //todos los almacenes
                if($almacen==0){
                    $boletas= Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    foreach($boletas as $boleta){
                        $boleta_id[]=$boleta->id;
                        $boleta_precio= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('precio');
                        $boleta->precio=$boleta_precio;
                        
                        $boleta->subtotal=round($boleta->precio/(1+($igv->igv_total/100)),2);
                        $boleta->igv=$boleta->boleta-$facturacion->subtotal;
                    }
                    if (!isset($boleta_id)) {
                        $boleta_id[]="";
                    }
                }else{
                    //productos + venta ------------------------------------------

                    //boleta
                    $boletas=Boleta::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    foreach($boletas as $boleta){
                        $boleta_id[]=$boleta->id;
                        $boleta_precio= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('precio');
                        $boleta->precio=$boleta_precio;
                        
                        $boleta->subtotal=round($boleta->precio/(1+($igv->igv_total/100)),2);
                        $boleta->igv=$boleta->boleta-$boleta->subtotal;
                    }
                    if (!isset($boleta_id)) {
                        $boleta_id[]="";
                    }
                    
                }
                //union de jsons
                $json=array_merge(json_decode($boletas, true));
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
