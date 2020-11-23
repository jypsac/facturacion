<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Boleta;
use App\Boleta_registro;
use App\Cliente;
use App\Cotizacion_Servicios;
use App\Cotizacion_Servicios_boleta_registro;
use App\Cotizacion_Servicios_factura_registro;
use App\Cotizacion_factura_registro;
use App\Cotizacion_boleta_registro;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_registro;
use App\Forma_pago;
use App\Igv;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Servicios;
use App\Ventas_registro;
use Illuminate\Http\Request;
use App;
use App\kardex_entrada_registro;

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
        return view('transaccion.venta.servicios.cotizacion.index',compact('cotizaciones_servicios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_factura()
    {
        $servicios=Servicios::where('estado_anular',0)->get();

        foreach ($servicios as $index => $servicio) {
            $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
            $array[]=$servicio->precio+$utilidad[$index];
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::all();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        return view('transaccion.venta.servicios.cotizacion.factura.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta'));
    }

    public function create_factura_ms()
    {
        $servicios=Servicios::where('estado_anular',0)->get();

        foreach ($servicios as $index => $servicio) {
            $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
            $array[]=$servicio->precio+$utilidad[$index];
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::all();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        return view('transaccion.venta.servicios.cotizacion.factura.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_factura(Request $request)
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

            return view('transaccion.venta.servicios.cotizacion.factura.fast_print',compact('servicio_codigo','igv','cliente_id','forma_pago_id','validez','user_id','observacion','servicio_id','precio','descuento','descuento_unitario','comision','sub_total'));
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

        $personal_contador= Cotizacion_Servicios::all()->count();
        $suma=$personal_contador+1;
        $cod_comision='COFAC-0000'.$suma;

        $cotizacion=new Cotizacion_Servicios;
        $cotizacion->cliente_id=$cliente_buscador->id;
        // $cotizacion->atencion=$request->get('atencion');
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->validez=$request->get('validez');
        $cotizacion->moneda_id=$request->get('moneda');
        $cotizacion->cod_comision=$cod_comision;
        $cotizacion->garantia=$request->get('garantia');
        $cotizacion->user_id =auth()->user()->id;
        $cotizacion->observacion=$request->get('observacion');
        $cotizacion->fecha_emision=$request->get('fecha_emision');
        $cotizacion->fecha_vencimiento=$nuevafechas;
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $cotizacion->comisionista_id= $comisionista_buscador->id;
        }
        $cotizacion->tipo='factura';
        $cotizacion->estado='0';
        $cotizacion->estado_vigente='0';
        $cotizacion->estado_aprovar='0';
        $cotizacion->estado_aprobado='0';
        // $cotizacion->aprobado_por='0';
        $cotizacion->save();

        $check = $request->input('descuento_unitario');
        $count_check=count($check);

        if($count_servicio = $count_check){
            for($i=0;$i<$count_servicio;$i++){
                $cotizacion_registro=new Cotizacion_Servicios_factura_registro;
                $cotizacion_registro->cotizacion_servicio_id=$cotizacion->id;
                $cotizacion_registro->servicio_id=$servicio_id[$i];

                    $servicio=Servicios::where('id',$servicio_id[$i])->where('estado_anular',0)->first();
                    $utilidad=$servicio->precio*$servicio->utilidad/100;
                    $array=$servicio->precio+$utilidad;


                $cotizacion_registro->promedio_original=$servicio->precio;
                $cotizacion_registro->precio=$array;
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
            return redirect()->route('cotizacion_servicio.create_factura')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('cotizacion_servicio.show',$cotizacion->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_boleta()
    {
        $servicios=Servicios::where('estado_anular',0)->get();
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        foreach ($servicios as $index => $servicio) {
            $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
            $igv[]=$servicio->precio*$igv_total/100;
            $array[]=$servicio->precio+$utilidad[$index]+$igv[$index];
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::all();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        return view('transaccion.venta.servicios.cotizacion.boleta.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function store_boleta(Request $request)
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

        $personal_contador= Cotizacion_Servicios::all()->count();
        $suma=$personal_contador+1;
        $cod_comision='COFAC-0000'.$suma;

        $cotizacion=new Cotizacion_Servicios;
        $cotizacion->cliente_id=$cliente_buscador->id;
        // $cotizacion->atencion=$request->get('atencion');
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->validez=$request->get('validez');
        $cotizacion->moneda_id=$request->get('moneda');
        $cotizacion->cod_comision=$cod_comision;
        $cotizacion->garantia=$request->get('garantia');
        $cotizacion->user_id =auth()->user()->id;
        $cotizacion->observacion=$request->get('observacion');
        $cotizacion->fecha_emision=$request->get('fecha_emision');
        $cotizacion->fecha_vencimiento=$nuevafechas;
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $cotizacion->comisionista_id= $comisionista_buscador->id;
        }
        $cotizacion->tipo='boleta';
        $cotizacion->estado='0';
        $cotizacion->estado_vigente='0';
        $cotizacion->estado_aprovar='0';
        $cotizacion->estado_aprobado='0';
        // $cotizacion->aprobado_por='0';
        $cotizacion->save();

        $check = $request->input('descuento_unitario');
        $count_check=count($check);



        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        if($count_servicio = $count_check){
            for($i=0;$i<$count_servicio;$i++){
                $cotizacion_registro=new Cotizacion_Servicios_boleta_registro;
                $cotizacion_registro->cotizacion_servicio_id=$cotizacion->id;
                $cotizacion_registro->servicio_id=$servicio_id[$i];

                    $servicio=Servicios::where('id',$servicio_id[$i])->where('estado_anular',0)->first();
                    $utilidad=$servicio->precio*$servicio->utilidad/100;
                    $igv=$servicio->precio*$igv_total/100;
                    $array=$servicio->precio+$utilidad+$igv;


                $cotizacion_registro->promedio_original=$servicio->precio;
                $cotizacion_registro->precio=$array;
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

        if($cotizacion->tipo=="factura"){
            //FACTURA
            $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
            foreach ($cotizacion_registro as $cotizacion_registros) {
               $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
            }
            return view('transaccion.venta.servicios.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i'));
        }else{
            //BOLETA
            $cotizacion_registro=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
            foreach ($cotizacion_registro as $cotizacion_registros) {
                $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
            }
            return view('transaccion.venta.servicios.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i'));
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

        $fac= Facturacion::all()->count();
        $suma=$fac+1;
        $cod_fac='FC-000'.$suma;

        $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
            foreach ($cotizacion_registro as $cotizacion_registros) {
               $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
            }
            return view('transaccion.venta.servicios.cotizacion.facturar', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','cod_fac'));


    }

//GUARDADO DE COTIZACION A FACTURA
    public function facturar_store(Request $request){
        // return $request;
    // cambio de Estado Cotizador
    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion_Servicios::where('id',$id_cotizador)->first();
    $cotizacion->estado=1;
    $cotizacion->save();
    $fac= Facturacion::all()->count();
    $suma=$fac+1;
    $cod_fac='FC-000'.$suma;

    // Creacion de Facturacion
    $facturar=new Facturacion;
    $facturar->codigo_fac=$cod_fac;
    $facturar->id_cotizador_servicio=$request->get('id_cotizador');
    $facturar->orden_compra=$request->get('orden_compra');
    $facturar->guia_remision=$request->get('guia_remision');
    $facturar->cliente_id=$cotizacion->cliente_id;
    $facturar->moneda_id=$cotizacion->moneda_id;
    $facturar->forma_pago_id=$cotizacion->forma_pago_id;
    $facturar->comisionista=$cotizacion->comisionista_id;
    $facturar->fecha_emision=$request->get('fecha_emision');
    $facturar->fecha_vencimiento=$request->get('fecha_vencimiento');
    $facturar->estado='0';
    $facturar->tipo='servicio';
    $facturar->user_id =auth()->user()->id;
    $facturar->save();

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
    return redirect()->route('facturacion.show',$id_cotizador);
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
        $boleta_codigo='BO-0000'.$suma;

        $cotizacion_registro=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
            foreach ($cotizacion_registro as $cotizacion_registros) {
                $array[]=Servicios::where('id',$cotizacion_registros->servicio_id)->first();
            }
            return view('transaccion.venta.servicios.cotizacion.boletear', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta','i','boleta_codigo'));

    }
//GUARDADO DE COTIZACION A BOLETA
    public function boletear_store(Request $request){

    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion_Servicios::where('id',$id_cotizador)->first();
    $cotizacion->estado=1;
    $cotizacion->save();
    $fac= Boleta::all()->count();
    $suma=$fac+1;
    $cod_bol='FC-000'.$suma;

    // Creacion de Facturacion
    $boletear=new Boleta;
    $boletear->codigo_boleta=$cod_bol;
    $boletear->id_cotizador_servicio=$request->get('id_cotizador');
    $boletear->orden_compra=$request->get('orden_compra');
    $boletear->guia_remision=$request->get('guia_remision');
    $boletear->cliente_id=$cotizacion->cliente_id;
    $boletear->moneda_id=$cotizacion->moneda_id;
    $boletear->forma_pago_id=$cotizacion->forma_pago_id;
    $boletear->comisionista=$cotizacion->comisionista_id;
    $boletear->fecha_emision=$request->get('fecha_emision');
    $boletear->fecha_vencimiento=$request->get('fecha_vencimiento');
    $boletear->estado='0';
    $boletear->tipo='servicio';
    $boletear->user_id =auth()->user()->id;
    $boletear->save();

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

    return redirect()->route('boleta.show',$id_cotizador);
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
        foreach ($cotizacion_registro as $cotizacion_registros) {
           $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
       }

        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
       $cotizacion=Cotizacion_Servicios::find($id);
       $empresa=Empresa::first();
       $sum=0;
       $igv=Igv::first();
       $sub_total=0;
       $end=0;
       $regla=$cotizacion->tipo;
       
       return view('transaccion.venta.servicios.cotizacion.print' ,compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','regla','sum','igv',"array","sub_total","moneda",'banco','end','igv_p'));
   }
}
