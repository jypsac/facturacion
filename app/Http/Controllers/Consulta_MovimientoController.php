<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeriodoConsulta_registro;
use App\PeriodoConsulta;
use App\Moneda;
use App\Empresa;
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
        $consulta=$request->consulta_p_input;
        if($categoria=="1"){
            // falta validacion si $request->consulta_p es un numero del 1 al 3
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
                        $kardex_entrada->subtotal=$kardex_entrada->precio_nacional_total;
                        // $kardex_entrada->igv=$igv->igv_total;
                        $kardex_entrada->igv=round($kardex_entrada->subtotal*($igv->igv_total/100),2);
                        $kardex_entrada->precio_nacional_total = $kardex_entrada->subtotal + round($kardex_entrada->subtotal*($igv->igv_total/100),2);
                        // $tot =  $kardex_entrada->precio_nacional_total+$kardex_entrada->igv;
                        $subtotal=$subtotal+$kardex_entrada->subtotal;
                        $igv_t=$igv_t+$kardex_entrada->igv;
                        $total = $total+($kardex_entrada->subtotal+$kardex_entrada->igv);
                        $jsons++;
                    }
                    $data_extra[$jsons]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);

                    $json=array_merge(json_decode($kardex_entradas, true),$data_extra );
                }else{
                    //productos + compra------------------------------------------
                    //solo permite hacer el llamado para el almacen 1
                    $kardex_entradas=kardex_entrada::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    $total=0;
                    $igv_t=0;
                    $subtotal=0;
                    $jsons=0;
                    if (!isset($kardex_entradas)) {
                        $kardex_entradas[]="";
                    }
                    foreach($kardex_entradas as $kardex_entrada){
                        $kardex_entrada->subtotal=$kardex_entrada->precio_nacional_total;
                        // $kardex_entrada->igv=$igv->igv_total;
                        $kardex_entrada->igv=round($kardex_entrada->subtotal*($igv->igv_total/100),2);
                        $kardex_entrada->precio_nacional_total = $kardex_entrada->subtotal + round($kardex_entrada->subtotal*($igv->igv_total/100),2);
                        // $tot =  $kardex_entrada->precio_nacional_total+$kardex_entrada->igv;
                        $subtotal=$subtotal+$kardex_entrada->subtotal;
                        $igv_t=$igv_t+$kardex_entrada->igv;
                        $total = $total+($kardex_entrada->subtotal+$kardex_entrada->igv);
                        $jsons++;
                    }
                    $data_extra[$jsons]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);

                    $json=array_merge(json_decode($kardex_entradas, true),$data_extra );
                }
            }else{
                $json=[];
            }
        }elseif($categoria=="2"){
            $json=[];
            // return "Servicio no admitible para compras";
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
        $consulta_s=$request->consulta_s_input;
        // if($categoria=="2"){
        //     $consulta_p="2";
        // }
        if($consulta_p=="0"){
            return "consulta 0";
        }
        if($consulta_p=="2" or $consulta_p=="3" or $consulta_s = "1" && $consulta_p != "1"){
            //todos los almacenes
            if($almacen==0){
                if($categoria=="1"){
                    $facturaciones= Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->get();
                }elseif($categoria=="2"){
                    $facturaciones= Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->get();
                }else{
                    return "categoria incorrecta";
                }
                if(count($facturaciones) == 0){
                    $json=[];
                    goto salto_fac_json;
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($facturaciones as $facturacion){
                    $factura_id[]=$facturacion->id;
                    $factura_precio= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('precio');
                    $factura_cantidad= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('cantidad');
                    $facturacion->precio=round($factura_precio*$factura_cantidad,2);

                    $facturacion->subtotal=round($facturacion->precio/(1+($igv->igv_total/100)),2);
                    $facturacion->igv=round($facturacion->precio-$facturacion->subtotal,2);

                    $total=$total+$facturacion->precio;
                    $igv_t=$igv_t+$facturacion->igv;
                    $subtotal=$subtotal+$facturacion->subtotal;
                    $jsons++;
                }
                $data_extra[$jsons]=array('id' => $jsons+1,'fecha_emision' => "Total",'codigo_fac' => "",'cliente_id'=>"", 'cliente_id'=>"" , 'subtotal' => round($subtotal,2) , 'igv' => $igv_t , 'precio'=>round($total,2));

                $json=array_merge(json_decode($facturaciones, true),$data_extra );
                salto_fac_json:
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
                if(count($facturaciones) == 0){
                    $json=[];
                    goto salto_alm_fac_json;
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($facturaciones as $facturacion){
                    $factura_id[]=$facturacion->id;
                    $factura_precio = Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('precio');
                    $fact_cant = Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('cantidad');
                    $facturacion->precio=$factura_precio*$fact_cant;

                    $facturacion->subtotal=round($facturacion->precio/(1+($igv->igv_total/100)),2);
                    $facturacion->igv=round($facturacion->precio-$facturacion->subtotal,2);
                    $total=$total+$facturacion->precio;
                    $igv_t=$igv_t+$facturacion->igv;
                    $subtotal=$subtotal+$facturacion->subtotal;
                    $jsons++;
                }
                $data_extra[$jsons]=array('id' => $jsons+1,'fecha_emision' => "Total",'codigo_fac' => "",'cliente_id'=>"", 'cliente_id'=>"" , 'subtotal' => round($subtotal,2) , 'igv' => $igv_t , 'precio'=>round($total,2));
                if (!isset($factura_id)) {
                    $factura_id[]="";
                }
                $json=array_merge(json_decode($facturaciones, true),$data_extra );
                salto_alm_fac_json:
            }
            //union de jsons
            // $json=array_merge(json_decode($facturaciones, true),json_decode($boletas, true));
            // $json=array_merge(json_decode($facturaciones, true));
        }else{
            $json=[];
        }

        // if($categoria == "2"){

        // }
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
        $consulta_s=$request->consulta_s_input;
        // if($categoria=="2"){
        //     $consulta_p="2";
        // }
        if($consulta_p=="0"){
            return "consulta 0";
        }
        if($consulta_p=="2" or $consulta_p=="3" or $consulta_s=="1"){
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
                if(count($boletas) == 0){
                    $json=[];
                    goto salto_bol_alm_js;
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($boletas as $boleta){
                    $boleta_id[]=$boleta->id;
                    $boleta_precio= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta->id)->sum('precio');
                    $boleta_cant= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta->id)->sum('cantidad');
                    $boleta->precio=$boleta_precio*$boleta_cant;

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
                salto_bol_alm_js:
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
                if(count($boletas) == 0){
                    $json=[];
                    goto salto_alm_json;
                }
                $total=0;
                $igv_t=0;
                $subtotal=0;
                $jsons=0;
                foreach($boletas as $boleta){
                    $boleta_id[]=$boleta->id;
                    $boleta_precio= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta->id)->sum('precio');
                    $boleta_cant= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta->id)->sum('cantidad');
                    $boleta->precio=$boleta_precio*$boleta_cant;
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
                salto_alm_json:
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
    public function pdf(Request $request){
        // consultas
        // 1 = Compra
        // 2 = Venta
        // 3 = Compara y venta
        $moneda_nac = Moneda::where('tipo','nacional')->first();
        $moneda_ex = Moneda::where('tipo','extranjera')->first();
        $empresa = Empresa::first();
        $igv = Igv::first();
        $igv_t = $igv->igv_total;
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        // CONSULTA PRODUCTO
        $consulta_prod = $request->consulta_p_input;
        // CONSULTA SERVICIO
        $consulta_serv = $request->consulta_s_input;
        $jsons = 1;
        // return $consulta;
        // PRODUCTOS
        // if($categoria== "1"){
            if($consulta_prod == "1" or $consulta_prod == "3"){
                if($almacen == 0){
                    $kardex_entrada =  kardex_entrada::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                }else{
                    $kardex_entrada =  kardex_entrada::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('almacen_id',$almacen)->get();
                }
            }
            if($consulta_prod == "2" or $consulta_prod == "3" or $consulta_serv == "1") {

                if($almacen == 0){
                    if($categoria == "1"){
                       $factura = Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->get();
                       $boleta = Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->get();
                    }elseif($categoria == "2"){
                        $factura = Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->get();
                        $boleta = Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->get();
                    }
                    foreach($factura as $facturacion){
                        if($facturacion->moneda_id == $moneda_nac->id){
                            $factura_reg_precio_n = number_format(Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('precio_unitario_comi'),2);
                            $factura_reg_precio_x = number_format($factura_reg_precio_n/$facturacion->cambio,2);
                        }
                        if($facturacion->moneda_id == $moneda_ex->id){
                            $factura_reg_precio_x = number_format(Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('precio_unitario_comi'),2);
                            $factura_reg_precio_n = number_format(round($factura_reg_precio_x*$facturacion->cambio, 1, PHP_ROUND_HALF_UP),2);
                        }

                        $factura_reg_cant = Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('cantidad');
                        $data_extra_f[]=array('id' => $facturacion->created_at,'codigo_guia'=>$facturacion->codigo_fac,'tipo'=> 'Factura','cantidad'=>$factura_reg_cant,'cambio'=>$facturacion->cambio,'precio_nac'=>$factura_reg_precio_n,'precio_ex'=> $factura_reg_precio_x);
                    }

                    //BOLETAS

                    foreach ($boleta as $boleta_reg) {
                        if($boleta_reg->moneda_id == $moneda_nac->id){
                            $boleta_reg_precio_n = number_format(Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('precio'),2);
                            $boleta_reg_precio_x = number_format($boleta_reg_precio_n/$boleta_reg->cambio,2);
                        }
                        if($boleta_reg->moneda_id == $moneda_ex->id){
                            $boleta_reg_precio_x = number_format(Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('precio'),2);
                            $boleta_reg_precio_n = number_format(round($boleta_reg_precio_x*$boleta_reg->cambio,1, PHP_ROUND_HALF_UP ),2);
                        }
                        $boleta_reg_cant = Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('cantidad');
                        $data_extra_b[]=array('id' => $boleta_reg->created_at,'codigo_guia'=>$boleta_reg->codigo_boleta,'tipo'=> 'Boleta','cantidad'=>$boleta_reg_cant,'cambio'=>$boleta_reg->cambio,'precio_nac'=>$boleta_reg_precio_n,'precio_ex'=>$boleta_reg_precio_x);
                    }
                }else{
                    //almacen seleccionado
                    if($categoria == "1"){
                       $factura = Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('almacen_id', $almacen)->where('tipo','producto')->get();
                       $boleta = Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','producto')->where('almacen_id', $almacen)->get();
                    }elseif($categoria == "2"){
                        $factura = Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->where('almacen_id', $almacen)->get();
                        $boleta = Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo','servicio')->where('almacen_id', $almacen)->get();
                    }
                    // $fac_count = count($factura);
                    foreach($factura as $facturacion){
                        if($facturacion->moneda_id == $moneda_nac->id){
                            $factura_reg_precio_n = number_format(Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('precio_unitario_comi'),2);
                            $factura_reg_precio_x = number_format($factura_reg_precio_n/$facturacion->cambio,2);
                        }
                        if($facturacion->moneda_id == $moneda_ex->id){
                            $factura_reg_precio_x = number_format(Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('precio_unitario_comi'),2);
                            $factura_reg_precio_n = number_format(round($factura_reg_precio_x*$facturacion->cambio, 1, PHP_ROUND_HALF_UP),2);
                        }
                        $factura_reg_cant = Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('cantidad');
                        $data_extra_f[]=array('id' => $facturacion->created_at,'codigo_guia'=>$facturacion->codigo_fac,'tipo'=> 'Factura','cantidad'=>$factura_reg_cant,'cambio'=>$facturacion->cambio,'precio_nac'=>$factura_reg_precio_n,'precio_ex'=> $factura_reg_precio_x);
                    }
                    //BOLETAS
                    // $boleta = Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();

                    foreach ($boleta as $boleta_reg) {
                        if($boleta_reg->moneda_id == $moneda_nac->id){
                            $boleta_reg_precio_n = number_format(Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('precio'),2);
                            $boleta_reg_precio_x = number_format($boleta_reg_precio_n/$boleta_reg->cambio,2);
                        }
                        if($boleta_reg->moneda_id == $moneda_ex->id){
                            $boleta_reg_precio_x = number_format(Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('precio'),2);
                            $boleta_reg_precio_n = number_format(round($boleta_reg_precio_x*$boleta_reg->cambio,1, PHP_ROUND_HALF_UP ),2);
                        }
                        $boleta_reg_cant = Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('cantidad');
                        $data_extra_b[]=array('id' => $boleta_reg->created_at,'codigo_guia'=>$boleta_reg->codigo_boleta,'tipo'=> 'Boleta','cantidad'=>$boleta_reg_cant,'cambio'=>$boleta_reg->cambio,'precio_nac'=>$boleta_reg_precio_n,'precio_ex'=>$boleta_reg_precio_x);
                    }
                }
            }
        // }
        // return view('inventario.movimiento-consulta.show_pdf',compact('fecha_inicio','fecha_final','almacen','empresa','igv','kardex_entrada','consulta','data_extra_f','data_extra_b','moneda_ex','moneda_nac','categoria'));
        $archivo="Periodo - Consulta";
        $pdf=PDF::loadView('inventario.movimiento-consulta.show_pdf',compact('fecha_inicio','fecha_final','almacen','empresa','igv','kardex_entrada','categoria','data_extra_f','data_extra_b','moneda_ex','moneda_nac'));
        return $pdf->download('Periodo consulta - '.$archivo.' .pdf');

        // return view('inventario.periodo-consulta.',compact('garantia_guia_ingreso','mi_empresa'));
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
