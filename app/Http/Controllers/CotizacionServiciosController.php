<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Banco;
use App\Boleta;
use App\Boleta_registro;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_Servicios;
use App\Cotizacion_Servicios_boleta_registro;
use App\Cotizacion_Servicios_factura_registro;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_registro;
use App\Forma_pago;
use App\Igv;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Servicios;
use App\TipoCambio;
use App\Ventas_registro;
use App\kardex_entrada_registro;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CotizacionServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cotizaciones_servicios=Cotizacion_Servicios::all();
        $user_login =auth()->user();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen=Almacen::where('estado',0)->get();
        $almacen_primero=Almacen::where('estado',0)->first();

        return view('transaccion.venta.servicios.cotizacion.index',compact('cotizaciones_servicios','conteo_almacen','user_login','almacen','almacen_primero'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function descripcion_ajax_serv(Request $request){
        $articulo=$request->get('articulo');
        $id=explode(" ",$articulo);
        $producto=Servicios::where('id',$id[0])->first();
        $descripcion= $producto->descripcion;
        return $descripcion;
    }

    public function create_factura(Request $request)
    {
        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','1')->first();

        if($moneda->tipo =='nacional'){
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_nacional*($servicio->utilidad)/100;
                $array[]=round($servicio->precio_nacional+$utilidad[$index],2);
                $array_promedio[]=($servicio->precio_nacional);
            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $array[]=round($servicio->precio_extranjero+$utilidad[$index],2);
                $array_promedio[]=($servicio->precio_extranjero);
            }
        }


        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();

        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacenes=Almacen::all();
        }else{
            $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        }

        $empresa  = Empresa::first();
         //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion_Servicios::where('almacen_id',$sucursal->id)->where('tipo','factura')->count();
        if($ultima_factura){
            $code=$ultima_factura;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTSF ".$sucursal_nr."-".$cotizacion_nr;

        // return $cotizacion_numero;

        return view('transaccion.venta.servicios.cotizacion.factura.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes','empresa','sucursal','cotizacion_numero','array_promedio'));


    }

    public function create_factura_ms(Request $request)
    {
        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','0')->first();

        if($moneda->tipo =='extranjera'){
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_nacional*($servicio->utilidad)/100;
                $array[]=round(($servicio->precio_nacional+$utilidad[$index])/$tipo_cambio->paralelo,2);
                $array_promedio[]=round(($servicio->precio_nacional)/$tipo_cambio->paralelo,2);
            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $array[]=round(($servicio->precio_extranjero+$utilidad[$index])*$tipo_cambio->paralelo,2);
                $array_promedio[]=round(($servicio->precio_extranjero)/$tipo_cambio->paralelo,2);
            }
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::where('principal','0')->first();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacenes=Almacen::all();
        }else{
            $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        }
        $empresa  = Empresa::first();
          //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion_Servicios::where('almacen_id',$sucursal->id)->where('tipo','factura')->count();
        if($ultima_factura){
            $code=$ultima_factura;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTSF ".$sucursal_nr."-".$cotizacion_nr;

        return view('transaccion.venta.servicios.cotizacion.factura.create_ms',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes','empresa','cotizacion_numero','sucursal','array_promedio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_factura(Request $request,$id_moneda)
    {

        //codigo para convertir nombre a producto
        $articulo = $request->input('articulo');
        $count_servicio=count($articulo);

        for($i=0 ; $i<$count_servicio;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $servicio_id[$i]=strstr($articulos[$i], ' ', true);
        }

        //validacion para la no incersion de dobles articulos
        for ($e=0; $e < $count_servicio; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_servicio ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial==$articulo_comparacion) {
                        return redirect()->route('cotizacion_servicio.create_factura')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }
            }
        }

        // Comisionista cobnvertir id
        $comisionista=$request->get('comisionista');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $numero = strstr($comisionista, '-',true);
            $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            $id_personal=$cod_vendedor->id;
            $comisionista_buscador=Personal_venta::where('id',$id_personal)->first();
            $comi=$comisionista_buscador->comision;
        }else{
            $comi=0;
        }

        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);

        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();
        // return $cliente_buscador->id;

        $forma_pago_id=$request->get('forma_pago');
        $formapago= Forma_pago::find($forma_pago_id);
        $dias= $formapago->dias;
        /*Fecha vencimiento*/
        $fecha =date("d-m-Y");
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
        $nuevafechas = date("d-m-Y", $nuevafecha );

        //Almacen
        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacen=$request->get('almacen');
        }else{
            $almacen_seleccionado=Almacen::where('id',$user_id->almacen_id)->first();
            $almacen=$almacen_seleccionado->id;
        }


         //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion_Servicios::where('almacen_id',$sucursal->id)->where('tipo','factura')->count();
        if($ultima_factura){
            $code=$ultima_factura;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTSF ".$sucursal_nr."-".$cotizacion_nr;

        $cotizacion=new Cotizacion_Servicios;
        $cotizacion->cod_cotizacion=$cotizacion_numero;
        $cotizacion->almacen_id =$almacen;
        $cotizacion->cliente_id=$cliente_buscador->id;
        $cotizacion->moneda_id=$id_moneda;
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->estado_aprobar='0';
        $cotizacion->estado_aprobado='0';
        // $cotizacion->aprobado_por='0';
        $cotizacion->garantia=$request->get('garantia');
        $cotizacion->validez=$request->get('validez');
        $cotizacion->fecha_emision=$request->get('fecha_emision');
        $cotizacion->fecha_vencimiento=$nuevafechas;
        $cotizacion->cambio=$cambio->paralelo;
        $cotizacion->observacion=$request->get('observacion');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $cotizacion->comisionista_id= $comisionista_buscador->id;
        }
        $cotizacion->user_id =auth()->user()->id;
        $cotizacion->estado='0';
        $cotizacion->estado_vigente='0';
        $cotizacion->tipo='factura';
        $cotizacion->save();

        $check = $request->input('descuento_unitario');
        $count_check=count($check);

        //validacion dependiendo de la amoneda escogida
        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$cotizacion->moneda_id;

        if($count_servicio = $count_check){
            for($i=0;$i<$count_servicio;$i++){
                $cotizacion_registro=new Cotizacion_Servicios_factura_registro;
                $cotizacion_registro->cotizacion_servicio_id=$cotizacion->id;
                $cotizacion_registro->servicio_id=$servicio_id[$i];

                $servicio=Servicios::where('id',$servicio_id[$i])->where('estado_anular',0)->first();
                // return $servicio;
                //logica para el precio dependiendo de la moneda
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional') {
                        $array2 = $servicio->precio_nacional;
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad/100);
                        $array=$servicio->precio_nacional+$utilidad;
                        $cotizacion_registro->precio=$array;
                    }else{
                        $array2 = $servicio->precio_extranjero;
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad/100);
                        $array=$servicio->precio_extranjero+$utilidad;
                        $cotizacion_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera') {
                        $array2 = $servicio->precio_extranjero*$tipo_cambio->paralelo;
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad/100);
                        $array=($servicio->precio_extranjero+$utilidad)*$tipo_cambio->paralelo;
                        $cotizacion_registro->precio=$array;
                    }else{
                        $array2 = $servicio->precio_nacional/$tipo_cambio->paralelo;
                        $cotizacion_registro->promedio_original=$array2;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad/100);
                        $array=($servicio->precio_nacional+$utilidad)/$tipo_cambio->paralelo;
                        $cotizacion_registro->precio=$array;
                    }
                }

                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];

                //descuento
                $descuento_verificacion=$request->get('check_descuento')[$i];
                if($descuento_verificacion <> 0){
                    $cotizacion_registro->descuento=$servicio->descuento;
                    $desc_comprobacion=$servicio->descuento;
                }else{
                    $cotizacion_registro->descuento=0;
                    $desc_comprobacion=0;
                }
                //precio unitario descuento
                if($desc_comprobacion <> 0){
                    $cotizacion_registro->precio_unitario_desc=$array-($array2*$desc_comprobacion/100);
                    $precio_unitario_desc=$array-($array2*$desc_comprobacion/100);
                }else{
                    $cotizacion_registro->precio_unitario_desc=$array;
                    $precio_unitario_desc=$array;
                }

                $cotizacion_registro->comision=$comi;
                $cotizacion_registro->precio_unitario_comi=$precio_unitario_desc+($array2*$comi/100);


                $cotizacion_registro->save();
            }
        }else {
            return redirect()->route('cotizacion_servicio.create_factura')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('cotizacion_servicio.show',$cotizacion->id);
        // return $array2;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_boleta(Request $request)
    {

        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','1')->first();
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        if($moneda->tipo =='nacional'){
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_nacional*($servicio->utilidad)/100;
                $igv_precio[]=$servicio->precio_nacional+$utilidad[$index];
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=$servicio->precio_nacional+$utilidad[$index]+$igv[$index];
            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $igv_precio[]=$servicio->precio_extranjero+$utilidad[$index];
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=$servicio->precio_extranjero+$utilidad[$index]+$igv[$index];
            }
        }

        // return $utilidad;
        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::all();

        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacenes=Almacen::all();
        }else{
            $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        }

        $empresa  = Empresa::first();

        //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_boleta=Cotizacion_Servicios::where('almacen_id',$sucursal->id)->where('tipo','boleta')->count();
        if($ultima_boleta){
            $code=$ultima_boleta;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTSB ".$sucursal_nr."-".$cotizacion_nr;




        return view('transaccion.venta.servicios.cotizacion.boleta.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes','empresa','sucursal','cotizacion_numero'));
    }

    public function create_boleta_ms(Request $request)
    {
        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','0')->first();
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        if($moneda->tipo =='extranjera'){
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_nacional*($servicio->utilidad)/100;
                $igv_precio[]=$servicio->precio_nacional+$utilidad[$index];
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=($servicio->precio_nacional+$utilidad[$index]+$igv[$index])/$tipo_cambio->paralelo;
            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $igv_precio[]=$servicio->precio_extranjero+$utilidad[$index];
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=($servicio->precio_extranjero+$utilidad[$index]+$igv[$index])*$tipo_cambio->paralelo;
            }
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();

        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacenes=Almacen::all();
        }else{
            $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        }

        $empresa  = Empresa::first();
         //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_boleta=Cotizacion_Servicios::where('almacen_id',$sucursal->id)->where('tipo','boleta')->count();
        if($ultima_boleta){
            $code=$ultima_boleta;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTSB ".$sucursal_nr."-".$cotizacion_nr;

        return view('transaccion.venta.servicios.cotizacion.boleta.create_ms',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes','cotizacion_numero','sucursal','empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function store_boleta(Request $request,$id_moneda)
    {
        $print=$request->get('print');

        if($print==1){
            $cliente_id=$request->get('cliente');

            $sub_total=0;
            $igv=Igv::first();

            $forma_pago_id=$request->get('forma_pago');
            $moneda_id=$request->get('moneda');
            $validez=$request->get('validez');
            $garantia=$request->get('garantia');
            $user_id =auth()->user()->id;
            $observacion=$request->get('observacion');

            $articulo = $request->input('articulo');
            $count_servicio=count($articulo);

            for($i=0 ; $i<$count_servicio;$i++){
                $articulos[$i]= $request->input('articulo')[$i];
                $servicio_id[$i]=strstr($articulos[$i], ' ', true);
                $servicio_codigo[$i]=Servicios::where('id',$servicio_id[$i])->first();
            }

            for($i=0;$i<$count_servicio;$i++){

                $precio[]=$request->input('precio')[$i];
                $descuento[]=$request->input('descuento')[$i];
                $descuento_unitario[]=$request->input('descuento_unitario')[$i];
                $comision[]=$request->input('comision')[$i];

            }
            $sub_total=0;

            return view('transaccion.venta.servicios.cotizacion.boleta.fast_print',compact('servicio_codigo','igv','cliente_id','forma_pago_id','validez','user_id','observacion','servicio_id','precio','descuento','descuento_unitario','comision','sub_total'));
        }

        //codigo para convertir nombre a producto
        $articulo = $request->input('articulo');
        $count_servicio=count($articulo);

        for($i=0 ; $i<$count_servicio;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $servicio_id[$i]=strstr($articulos[$i], ' ', true);
        }

        //validacion para la no incersion de dobles articulos
        for ($e=0; $e < $count_servicio; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_servicio ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial==$articulo_comparacion) {
                        return redirect()->route('cotizacion_servicio.create_factura')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }

            }
        }
        // Comisionista cobnvertir id

        $comisionista=$request->get('comisionista');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $numero = strstr($comisionista, '-',true);
            $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            $id_personal=$cod_vendedor->id;
            $comisionista_buscador=Personal_venta::where('id',$id_personal)->first();
            $comi=$comisionista_buscador->comision;
        }else{
            $comi=0;
        }

        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);

        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();
        // return $cliente_buscador->id;

        $forma_pago_id=$request->get('forma_pago');
        $formapago= Forma_pago::find($forma_pago_id);
        $dias= $formapago->dias;
        /*Fecha vencimiento*/
        $fecha =date("d-m-Y");
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
        $nuevafechas = date("d-m-Y", $nuevafecha );

        //ALMACEN
        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacen=$request->get('almacen');
        }else{
            $almacen_seleccionado=Almacen::where('id',$user_id->almacen_id)->first();
            $almacen=$almacen_seleccionado->id;
        }

 //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_boleta=Cotizacion_Servicios::where('almacen_id',$sucursal->id)->where('tipo','boleta')->count();
        if($ultima_boleta){
            $code=$ultima_boleta;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTSB ".$sucursal_nr."-".$cotizacion_nr;

        $cotizacion=new Cotizacion_Servicios;
        $cotizacion->cod_cotizacion=$cotizacion_numero;
        $cotizacion->almacen_id=$almacen;
        $cotizacion->cliente_id=$cliente_buscador->id;
        $cotizacion->moneda_id=$id_moneda;
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->estado_aprobar='0';
        $cotizacion->estado_aprobado='0';
        // $cotizacion->aprobado_por='0';
        $cotizacion->garantia=$request->get('garantia');
        $cotizacion->validez=$request->get('validez');
        $cotizacion->fecha_emision=$request->get('fecha_emision');
        $cotizacion->fecha_vencimiento=$nuevafechas;
        $cotizacion->cambio=$cambio->paralelo;
        $cotizacion->observacion=$request->get('observacion');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $cotizacion->comisionista_id= $comisionista_buscador->id;
        }
        $cotizacion->user_id =auth()->user()->id;
        $cotizacion->estado='0';
        $cotizacion->estado_vigente='0';
        $cotizacion->tipo='boleta';
        $cotizacion->save();

        $check = $request->input('descuento_unitario');
        $count_check=count($check);


        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$cotizacion->moneda_id;
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        if($count_servicio = $count_check){
            for($i=0;$i<$count_servicio;$i++){
                $cotizacion_registro=new Cotizacion_Servicios_boleta_registro;
                $cotizacion_registro->cotizacion_servicio_id=$cotizacion->id;
                $cotizacion_registro->servicio_id=$servicio_id[$i];

                $servicio=Servicios::where('id',$servicio_id[$i])->where('estado_anular',0)->first();




                //logica para el precio dependiendo de la moneda
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional') {
                        $cotizacion_registro->promedio_original=$servicio->precio_nacional;
                        $utilidad=$servicio->precio_nacional*$servicio->utilidad/100;
                        $igv_precio=$servicio->precio_nacional+$utilidad;
                        $igv=$igv_precio*$igv_total/100;
                        $array=$servicio->precio_nacional+$utilidad+$igv;
                        $cotizacion_registro->precio=$array;
                    }else{
                        $cotizacion_registro->promedio_original=$servicio->precio_extranjero;
                        $utilidad=$servicio->precio_extranjero*$servicio->utilidad/100;
                        $igv_precio=$servicio->precio_extranjero+$utilidad;
                        $igv=$igv_precio*$igv_total/100;
                        $array=$servicio->precio_extranjero+$utilidad+$igv;
                        $cotizacion_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera') {
                        $cotizacion_registro->promedio_original=$servicio->precio_extranjero;
                        $utilidad=$servicio->precio_extranjero*$servicio->utilidad/100;
                        $igv_precio=$servicio->precio_extranjero+$utilidad;
                        $igv=$igv_precio*$igv_total/100;
                        $array=($servicio->precio_extranjero+$utilidad+$igv)*$tipo_cambio->paralelo;
                        $cotizacion_registro->precio=$array;
                    }else{

                        $cotizacion_registro->promedio_original=$servicio->precio_nacional;
                        $utilidad=$servicio->precio_nacional*$servicio->utilidad/100;
                        $igv_precio=$servicio->precio_nacional+$utilidad;
                        $igv=$igv_precio*$igv_total/100;
                        $array=($servicio->precio_nacional+$utilidad+$igv)/$tipo_cambio->paralelo;
                        $cotizacion_registro->precio=$array;
                    }
                }

                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];

                //descuento
                $descuento_verificacion=$request->get('check_descuento')[$i];
                if($descuento_verificacion <> 0){
                    $cotizacion_registro->descuento=$servicio->descuento;
                    $desc_comprobacion=$servicio->descuento;
                }else{
                    $cotizacion_registro->descuento=0;
                    $desc_comprobacion=0;
                }

                //precio unitario descuento
                if($desc_comprobacion <> 0){
                    $cotizacion_registro->precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                    $precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                }else{
                    $cotizacion_registro->precio_unitario_desc=$array;
                    $precio_unitario_desc=$array;
                }

                $cotizacion_registro->comision=$comi;
                $cotizacion_registro->precio_unitario_comi=$precio_unitario_desc+($precio_unitario_desc*$comi/100);


                $cotizacion_registro->save();
            }
        }else {
            return redirect()->route('cotizacion_servicio.create_boleta')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('cotizacion_servicio.show',$cotizacion->id);



    }

    public function show($id)
    {

        $facturacion=Facturacion::where('id_cotizador_servicio',$id)->first();
        $boleta=Boleta::where('id_cotizador_servicio',$id)->first();
        $banco=Banco::where('estado','0')->get();
        $moneda=Moneda::where('principal',1)->first();
        $cotizacion=Cotizacion_Servicios::where('id',$id)->first();

        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $regla=$cotizacion->tipo;
        $i=1;
        $almacen=auth()->user()->almacen_id;
        if($cotizacion->tipo=="factura"){
            //FACTURA
            $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
            foreach ($cotizacion_registro as $cotizacion_registros) {
               $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
           }
           $nueva_cot='cotizacion_servicio.create_'.$regla;
           return view('transaccion.venta.servicios.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','nueva_cot','almacen'));
       }
       else{
            //BOLETA
        $cotizacion_registro=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
        foreach ($cotizacion_registro as $cotizacion_registros) {
            $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
        }
        $nueva_cot='cotizacion_servicio.create_'.$regla;
        return view('transaccion.venta.servicios.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','nueva_cot','almacen'));
    }
}

//ENVIO DE FACTURAR A VISTA
public function facturar($id){
    $facturacion=Facturacion::where('id_cotizador',$id)->first();
    $boleta=Boleta::where('id_cotizador',$id)->first();
    $banco=Banco::where('estado','0')->get();
    $moneda=Moneda::where('principal',1)->first();
    $cotizacion=Cotizacion_Servicios::find($id);

    $empresa=Empresa::first();
    $sum=0;
    $igv=Igv::first();
    $sub_total=0;
    $regla=$cotizacion->tipo;
    $i=1;

    // obtencion de la sucursal
    $almacen=$cotizacion->almacen_id;
           //obtencion del almacen
    $sucursal=Almacen::where('id', $almacen)->first();

    $factura_cod_fac=$sucursal->cod_fac;
    if (is_numeric($factura_cod_fac)) {
               // exprecion del numero de fatura
       $factura_cod_fac++;
       $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
       $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);

   }else{
               // exprecion del numero de fatura
               // GENERACION DE NUMERO DE FACTURA
       $ultima_factura=Facturacion::latest()->first();
       $factura_num=$ultima_factura->codigo_fac;
       $factura_num_string_porcion= explode("-", $factura_num);
       $factura_num_string=$factura_num_string_porcion[1];
       $factura_num=(int)$factura_num_string;
       $factura_num++;
       $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
       $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
   }
   $cod_fac="F".$sucursal_nr."-".$factura_nr;

   $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
   foreach ($cotizacion_registro as $cotizacion_registros) {
    $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
}
if ($cotizacion->estado==0) {

    return view('transaccion.venta.servicios.cotizacion.facturar', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','cod_fac'));
}
elseif ($cotizacion->estado==1) {
    return redirect()->route('cotizacion_servicio.show',$cotizacion->id);
}

}

    //GUARDADO DE COTIZACION A FACTURA
public function facturar_store(Request $request){
    $date_sp = Carbon::now();
    $data_g = str_replace(' ', '_',$date_sp);
    $carbon_sp = str_replace(':','-',$data_g);
    $id = $request->get('id');
        // cambio de Estado Cotizador
    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion_Servicios::where('id',$id_cotizador)->first();

        //buscador al cambio
    $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
    if(!$cambio){
        return "error por no hacer el cambio diario";
    }
          // obtencion de la sucursal
    $almacen=$cotizacion->almacen_id;
           //obtencion del almacen
    $sucursal=Almacen::where('id', $almacen)->first();

    $factura_cod_fac=$sucursal->cod_fac;
    if (is_numeric($factura_cod_fac)) {
               // exprecion del numero de fatura
       $factura_cod_fac++;
       $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
       $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);

       $sucursal=auth()->user()->almacen->codigo_sunat;
        //obtencion del almacen
       $factura_primera=Almacen::where('codigo_sunat', $sucursal)->first();
       $factura_primera->cod_fac='NN';
       $factura_primera->save();
   }else{
               // exprecion del numero de fatura
               // GENERACION DE NUMERO DE FACTURA
       $ultima_factura=Facturacion::latest()->first();
       $factura_num=$ultima_factura->codigo_fac;
       $factura_num_string_porcion= explode("-", $factura_num);
       $factura_num_string=$factura_num_string_porcion[1];
       $factura_num=(int)$factura_num_string;
       $factura_num++;
       $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
       $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
   }
   $factura_numero="F".$sucursal_nr."-".$factura_nr;
            // Creacion de Facturacion
   $facturar=new Facturacion;
   $facturar->codigo_fac=$factura_numero;
   $facturar->almacen_id =$almacen;
   $facturar->id_cotizador_servicio=$request->get('id_cotizador');
   $facturar->orden_compra=$request->get('orden_compra');
   $facturar->guia_remision=$request->get('guia_remision');
   $facturar->cliente_id=$cotizacion->cliente_id;
   $facturar->moneda_id=$cotizacion->moneda_id;
   $facturar->forma_pago_id=$cotizacion->forma_pago_id;
   $facturar->fecha_emision=$request->get('fecha_emision');
   $facturar->fecha_vencimiento=$request->get('fecha_vencimiento');
   $facturar->cambio=$cambio->paralelo;
   $facturar->comisionista=$cotizacion->comisionista_id;
   $facturar->user_id =auth()->user()->id;
   $facturar->estado='0';
   $facturar->tipo='servicio';
   if ($cotizacion->estado==0) {
    $facturar->save();
}
elseif ($cotizacion->estado==1) {
   return redirect()->route('cotizacion_servicio.show',$cotizacion->id);
}
/*cambio de estado del cotizador*/
$cotizacion->estado=1;
$cotizacion->save();
/* cambio de estado del cotizador*/



$buscador_id=Cotizacion_Servicios::where('id',$facturar->id_cotizador_servicio)->first();

$cotizaciones_facturaciones=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$buscador_id->id)->get();

foreach ($cotizaciones_facturaciones as $index => $cotizacion_facturacion) {
    $facturacion_registro=new Facturacion_registro;
    $facturacion_registro->facturacion_id=$facturar->id;
    $facturacion_registro->servicio_id=$cotizacion_facturacion->servicio_id;
    $facturacion_registro->promedio_original=$cotizacion_facturacion->promedio_original;
    $facturacion_registro->precio=$cotizacion_facturacion->precio;
    $facturacion_registro->cantidad=$cotizacion_facturacion->cantidad;
    $facturacion_registro->descuento=$cotizacion_facturacion->descuento;
    $facturacion_registro->precio_unitario_desc=$cotizacion_facturacion->precio_unitario_desc;
    $facturacion_registro->comision=$cotizacion_facturacion->comision;
    $facturacion_registro->precio_unitario_comi=$cotizacion_facturacion->precio_unitario_comi;
    $facturacion_registro->save();
}
/**/
 // Creacion de Ventas Registros del Comisinista
$cotizador=$request->get('id_cotizador');
$precio_final_igv=$request->get('precio_final_igv');
$sub_total_sin_igv=$request->get('sub_total_sin_igv');
$tipo_moneda=$request->get('tipo_moneda');
$id_comisionista=$request->get('id_comisionista');
$comisionista=Cotizacion_Servicios::where('id',$cotizador)->first();
$comisionista_porcentaje=Personal_venta::where('id',$id_comisionista)->first();
$id_comi=$comisionista->comisionista_id;
if(isset($id_comi)){
   $comisionista=new Ventas_registro;
   $comisionista->comisionista=$id_comisionista;
   $comisionista->tipo_moneda=$tipo_moneda;
   $comisionista->estado_aprobado='0';
   $comisionista->estado_pagado='0';
   $comisionista->estado_anular_fac_bol='0';
   $comisionista->monto_final_fac_bol=$precio_final_igv;
   $porcentaje=100+$comisionista_porcentaje->comision;
   $comisionista->monto_comision=(100*$sub_total_sin_igv/$porcentaje)*$comisionista_porcentaje->comision/100;
   // $comisionista->id_coti_produc=$cotizador;
   $comisionista->id_coti_servicio=$cotizador;
   $comisionista->id_fac=$facturar->id;
   $comisionista->observacion='Viene del Cotizador';
   $comisionista->save();
}
return redirect()->route('facturacion_servicio.show',$facturar->id);
}

//ENVIO DE BOLETEAR A VISTA
public function boletear($id){
    $facturacion=Facturacion::where('id_cotizador',$id)->first();
    $boleta=Boleta::where('id_cotizador',$id)->first();
    $banco=Banco::where('estado','0')->get();
    $moneda=Moneda::where('principal',1)->first();
    $cotizacion=Cotizacion_Servicios::find($id);

    $empresa=Empresa::first();
    $sum=0;
    $igv=Igv::first();
    $sub_total=0;
    $regla=$cotizacion->tipo;
    $i=1;

    $boleta_contador= Boleta::all()->count();
    $suma=$boleta_contador+1;
    // $boleta_codigo='BO-0000'.$suma;

        // obtencion de la sucursal
    $cotizacion_almacen=Cotizacion_Servicios::where('id',$id)->first();
    $almacen=$cotizacion_almacen->almacen_id;
        //obtencion del almacen
    $sucursal=Almacen::where('codigo_sunat', $almacen)->first();
    $boleta_cod_fac=$sucursal->cod_bol;
    if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
        $boleta_cod_fac++;
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);

    }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
        $ultima_boleta=Boleta::latest()->first();
        $boleta_num=$ultima_boleta->codigo_boleta;
        $boleta_num_string_porcion= explode("-", $boleta_num);
        $boleta_num_string=$boleta_num_string_porcion[1];
        $boleta_num=(int)$boleta_num_string;
        $boleta_num++;
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
    }
    $boleta_codigo="B".$sucursal_nr."-".$boleta_nr;




    $cotizacion_registro=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
    foreach ($cotizacion_registro as $cotizacion_registros) {
        $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
    }
    if ($cotizacion->estado==0) {
         return view('transaccion.venta.servicios.cotizacion.boletear', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','boleta_codigo'));#
     }
     elseif ($cotizacion->estado==1) {
        return redirect()->route('cotizacion_servicio.show',$cotizacion->id);
    }



}
//GUARDADO DE COTIZACION A BOLETA
public function boletear_store(Request $request){
    $date_sp = Carbon::now();
    $data_g = str_replace(' ', '_',$date_sp);
    $carbon_sp = str_replace(':','-',$data_g);
    $id = $request->get('id');

    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion_Servicios::where('id',$id_cotizador)->first();

      // obtencion de la sucursal
    $cotizacion_almacen=Cotizacion_Servicios::where('id',$id)->first();
    $almacen=$cotizacion_almacen->almacen_id;
        //obtencion del almacen
    $sucursal=Almacen::where('codigo_sunat', $almacen)->first();
    $boleta_cod_fac=$sucursal->cod_bol;
    if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
        $boleta_cod_fac++;
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);

        $sucursal=auth()->user()->almacen->codigo_sunat;
        //obtencion del almacen
        $factura_primera=Almacen::where('codigo_sunat', $sucursal)->first();
        $factura_primera->cod_bol='NN';
        $factura_primera->save();
    }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
        $ultima_boleta=Boleta::latest()->first();
        $boleta_num=$ultima_boleta->codigo_boleta;
        $boleta_num_string_porcion= explode("-", $boleta_num);
        $boleta_num_string=$boleta_num_string_porcion[1];
        $boleta_num=(int)$boleta_num_string;
        $boleta_num++;
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
    }
    $cod_bol="B".$sucursal_nr."-".$boleta_nr;



    $almacen = $request->get('almacen');
    $tipo_cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();

        // Creacion de Facturacion
    $boletear=new Boleta;
    $boletear->codigo_boleta=$cod_bol;
    $boletear->almacen_id = $almacen;
    $boletear->id_cotizador_servicio=$request->get('id_cotizador');
    $boletear->orden_compra=$request->get('orden_compra');
    $boletear->guia_remision=$request->get('guia_remision');
    $boletear->cliente_id=$cotizacion->cliente_id;
    $boletear->moneda_id=$cotizacion->moneda_id;
    $boletear->forma_pago_id=$cotizacion->forma_pago_id;
    $boletear->comisionista=$cotizacion->comisionista_id;
    $boletear->cambio = $tipo_cambio->paralelo;
    $boletear->fecha_emision=$request->get('fecha_emision');
    $boletear->fecha_vencimiento=$request->get('fecha_vencimiento');
    $boletear->estado='0';
    $boletear->tipo='servicio';
    $boletear->user_id =auth()->user()->id;

    if ($cotizacion->estado==0) {
        $boletear->save();
    }
    elseif ($cotizacion->estado==1) {
       return redirect()->route('cotizacion_servicio.show',$cotizacion->id);
   }

   $cotizacions=Cotizacion_Servicios::where('id',$id_cotizador)->first();
   $cotizacions->estado=1;
   $cotizacions->save();

   $buscador_id=Cotizacion_Servicios::where('id',$boletear->id_cotizador_servicio)->first();

   $cotizaciones_boletaciones=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$buscador_id->id)->get();

   foreach ($cotizaciones_boletaciones as $index => $cotizacion_boleta) {
    $boleta_registro=new Boleta_registro();
    $boleta_registro->boleta_id=$boletear->id;
    $boleta_registro->servicio_id=$cotizacion_boleta->servicio_id;
    $boleta_registro->promedio_original=$cotizacion_boleta->promedio_original;
    $boleta_registro->precio=$cotizacion_boleta->precio;
    $boleta_registro->cantidad=$cotizacion_boleta->cantidad;
    $boleta_registro->descuento=$cotizacion_boleta->descuento;
    $boleta_registro->precio_unitario_desc=$cotizacion_boleta->precio_unitario_desc;
    $boleta_registro->comision=$cotizacion_boleta->comision;
    $boleta_registro->precio_unitario_comi=$cotizacion_boleta->precio_unitario_comi;
    $boleta_registro->save();
}

        // Creacion de Ventas Registros del Comisinista
$cotizador=$request->get('id_cotizador');
$id_comisionista=$request->get('id_comisionista');
$comisionista=Cotizacion_Servicios::where('id',$cotizador)->first();
$id_comi=$comisionista->comisionista_id;

if(isset($id_comi)){
   $comisionista=new Ventas_registro;
   $comisionista->id_facturacion=$request->get('fac_id');
   $comisionista->comisionista=$request->get('id_comisionista');
   $comisionista->estado_aprobado='0';
   $comisionista->pago_efectuado='0';
   $comisionista->estado_fac='0';
   $comisionista->observacion='Viene del Cotizador';
   $comisionista->save();
}
return redirect()->route('boleta_servicio.show',$boletear->id);

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
    public function print($id){
        $banco=Banco::where('estado','0')->get();
        $moneda=Moneda::where('principal',1)->first();
        $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
        $cotizacion_registro2=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
       //  foreach ($cotizacion_registro as $cotizacion_registros) {
       //     $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
       // }

        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
        $cotizacion=Cotizacion_Servicios::find($id);
        $empresa=Empresa::first();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $end=0;
        $regla=$cotizacion->tipo;
        $i=1;

        if($cotizacion->tipo=="factura"){
            //FACTURA
            $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
            foreach ($cotizacion_registro as $cotizacion_registros) {
               $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
           }
           return view('transaccion.venta.servicios.cotizacion.print', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i'));
       }else{
            //BOLETA
        $cotizacion_registro=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
        foreach ($cotizacion_registro as $cotizacion_registros) {
            $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
        }
        return view('transaccion.venta.servicios.cotizacion.print', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i'));
    }


       // return view('transaccion.venta.servicios.cotizacion.print' ,compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','regla','sum','igv',"array","sub_total","moneda",'banco','end','igv_p'));
}

public function pdf(Request $request,$id){
    $name = $request->get('name');
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $moneda=Moneda::where('principal',1)->first();
    $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
    $cotizacion_registro2=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
       //  foreach ($cotizacion_registro as $cotizacion_registros) {
       //     $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
       // }

        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
    $cotizacion=Cotizacion_Servicios::find($id);
    $empresa=Empresa::first();
    $sum=0;
    $igv=Igv::first();
    $sub_total=0;
    $end=0;
    $regla=$cotizacion->tipo;
    $i=1;

    if($cotizacion->tipo=="factura"){
            //FACTURA
        $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
        foreach ($cotizacion_registro as $cotizacion_registros) {
           $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
       }
       $archivo=$name.$regla.$id;
       $pdf=PDF::loadView('transaccion.venta.servicios.cotizacion.pdf',compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','banco_count'));
       return $pdf->download('Cotizacion Servicios - '.$archivo.'.pdf');
   }else{
            //BOLETA
    $cotizacion_registro=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
    foreach ($cotizacion_registro as $cotizacion_registros) {
        $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
    }
    $archivo=$name.$regla.$id;
    $pdf=PDF::loadView('transaccion.venta.servicios.cotizacion.pdf',compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','banco_count'));
    return $pdf->download('Cotizacion Servicios - '.$archivo.'.pdf');
}


}
}
