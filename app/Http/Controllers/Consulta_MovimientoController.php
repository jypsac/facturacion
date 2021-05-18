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
        // return $request;
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
            $consulta=$request->consulta_p_input;
            if($consulta=="0"){
                return "consulta 0";
            }
            if($consulta=="1" or $consulta=="3"){
                if($almacen == 0){
                    //productos + compra------------------------------------------
                    //solo permite hacer el llamado para el almacen 1
                    $kardex_entradas=kardex_entrada::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    $total=0;
                    $igv_t=0;
                    $subtotal=0;
                    $jsons=0;
                    if (!isset($kardex_entradas)) {
                        $kardex_entradas[]="";
                    }
                    foreach($kardex_entradas as $kardex_entrada){
                        $kardex_entrada->igv=$igv->igv_total;
                        $kardex_entrada->subtotal=round($kardex_entrada->precio_nacional_total/(1+($igv->igv_total/100)),2);
                        $total=$total+$kardex_entrada->precio_nacional_total;
                        $igv_t=$igv_t+$kardex_entrada->igv;
                        $subtotal=$subtotal+$kardex_entrada->subtotal;
                        $jsons++;
                    }
                    $data_extra[$jsons]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);

                    $json=array_merge(json_decode($kardex_entradas, true),$data_extra );
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
                    
                    $json=array_merge(json_decode($kardex_entradas, true),$data_extra );
                }
                
            }else{
                $json=[];
            }
        }elseif($categoria=="2"){
            $consulta=2;
            return "Servicio no admitible para compras";
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
        
        // falta validacion si $request->consulta_p es un numero del 1 al 3
        $consulta_p=$request->consulta_p_input;
        if($categoria=="2"){
            $consulta_p="2";
        }
        if($consulta_p=="0"){
            return "consulta 0";
        }
        // return $consulta_p;
        if($consulta_p=="2" or $consulta_p=="3"){
            //todos los almacenes
            if($almacen==0){
                if($categoria=="1"){
                    $facturaciones= Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->get();
                }elseif($categoria=="2"){
                    $facturaciones= Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->get();
                }else{
                    return "categoria incorrecta";
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($facturaciones as $facturacion){
                    $factura_id[]=$facturacion->id;
                    $factura_precio= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('precio');
                    $facturacion->precio=$factura_precio;
                    
                    $facturacion->subtotal=round($facturacion->precio/(1+($igv->igv_total/100)),2);
                    $facturacion->igv=round($facturacion->precio-$facturacion->subtotal,2);

                    $total=$total+$facturacion->precio;
                    $igv_t=$igv_t+$facturacion->igv;
                    $subtotal=$subtotal+$facturacion->subtotal;
                    $jsons++;
                }
                $data_extra[$jsons]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);
                $json=array_merge(json_decode($facturaciones, true),$data_extra );

            }else{
                //productos + venta ------------------------------------------
                //facturacion
                if($categoria=="1"){
                    $facturaciones=Facturacion::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->get();
                }elseif($categoria=="2"){
                    $facturaciones=Facturacion::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->get();
                }else{
                    return "categoria incorrecta";
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($facturaciones as $facturacion){
                    $factura_id[]=$facturacion->id;
                    $factura_precio= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('precio');
                    $facturacion->precio=$factura_precio;
                    
                    $facturacion->subtotal=round($facturacion->precio/(1+($igv->igv_total/100)),2);
                    $facturacion->igv=round($facturacion->precio-$facturacion->subtotal,2);
                    $total=$total+$facturacion->precio;
                    $igv_t=$igv_t+$facturacion->igv;
                    $subtotal=$subtotal+$facturacion->subtotal;
                    $jsons++;
                }
                $data_extra[$jsons]=array('id' => $jsons+1,'fecha_emision' => "Total",'codigo_fac' => "",'cliente_id'=>"", 'cliente_id'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio'=>$total);
                if (!isset($factura_id)) {
                    $factura_id[]="";
                }
                $json=array_merge(json_decode($facturaciones, true),$data_extra );
            }
            //union de jsons
            // $json=array_merge(json_decode($facturaciones, true),json_decode($boletas, true));
            // $json=array_merge(json_decode($facturaciones, true));
        }else{
            $json=[];
        }
        
        return response(json_encode($json),200)->header('content-type','text/plain');
    }

    public function ajax_movimiento_ventas_b(Request $request){
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
        
        // falta validacion si $request->consulta_p es un numero del 1 al 3
        $consulta_p=$request->consulta_p_input;
        if($categoria=="2"){
            $consulta_p="2";
        }
        if($consulta_p=="0"){
            return "consulta 0";
        }
        if($consulta_p=="2" or $consulta_p=="3"){
            //todos los almacenes
            if($almacen==0){
                if($categoria=="1"){
                    $boletas= Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->get();
                }elseif($categoria=="2"){
                    $boletas= Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->get();
                    // return "este es servicio";
                }else{
                    return "categoria incorrecta";
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($boletas as $boleta){
                    $boleta_id[]=$boleta->id;
                    $boleta_precio= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('precio');
                    $boleta->precio=$boleta_precio;
                    
                    $boleta->subtotal=round($boleta->precio/(1+($igv->igv_total/100)),2);
                    $boleta->igv=round($boleta->precio-$boleta->subtotal,2);
                    $total=$total+$boleta->precio;
                    $igv_t=$igv_t+$boleta->igv;
                    $subtotal=$subtotal+$boleta->subtotal;
                    $jsons++;
                }
                if (!isset($boleta_id)) {
                    $boleta_id[]="";
                }
                $data_extra[$jsons]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);
                $json=array_merge(json_decode($boletas, true),$data_extra );
            }else{
                //productos + venta ------------------------------------------
                //boleta
                if($categoria=="1"){
                    $boletas=Boleta::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->get();
                }elseif($categoria=="2"){
                    $boletas=Boleta::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->get();
                    // return "este es servicio";
                }else{
                    return "categoria incorrecta";
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($boletas as $boleta){
                    $boleta_id[]=$boleta->id;
                    $boleta_precio= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('precio');
                    $boleta->precio=$boleta_precio;
                    $boleta->subtotal=round($boleta->precio/(1+($igv->igv_total/100)),2);
                    $boleta->igv=round($boleta->precio-$boleta->subtotal,2);
                    $total=$total+$boleta->precio;
                    $igv_t=$igv_t+$boleta->igv;
                    $subtotal=$subtotal+$boleta->subtotal;
                    $jsons++;
                }
                if (!isset($boleta_id)) {
                    $boleta_id[]="";
                }
                $data_extra[$jsons]=array('id' => $jsons+1,'fecha_emision' => "Total",'codigo_boleta' => "",'cliente_id' => "",'cliente.nombre'=>"", 'cliente_id'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio'=>$total);
                $json=array_merge(json_decode($boletas, true),$data_extra );
                
            }
            //union de jsons
            // $json=array_merge(json_decode($boletas, true));
        }else{
            $json=[];
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
