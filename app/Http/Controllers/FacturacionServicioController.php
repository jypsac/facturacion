<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Banco;
use App\Cliente;
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
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacturacionServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','1')->first();

        // if($moneda->tipo =='nacional'){
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio_nacional*($servicio->utilidad)/100;
        //         $array[]=$servicio->precio_nacional+$utilidad[$index];
        //     }
        // }else{
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
        //         $array[]=$servicio->precio_extranjero+$utilidad[$index]*$tipo_cambio->paralelo;
        //     }
        // }

        if($moneda->tipo =='nacional'){
            foreach ($servicios as $index => $servicio) {
                $precio_prom[]=$servicio->precio_nacional;
                $utilidad[]=$servicio->precio_nacional*($servicio->utilidad/100);
                $array[]=round($servicio->precio_nacional+$utilidad[$index],2);
            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $precio_prom[]=$servicio->precio_extranjero;
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad/100);
                $array[]=round($servicio->precio_extranjero+$utilidad[$index],2);
            }
        }

        $empresa = Empresa::first();
        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();

        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();
        $sucursal= Almacen::first();
        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacenes=Almacen::all();
        }else{
            $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        }
        $almacen=$request->get('almacen');

        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();

        $factura_cod_fac=$sucursal->cod_fac;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($sucursal->codigo_sunat, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_factura=Facturacion::where('almacen_id',$sucursal->id)->latest()->first();
            $factura_num=$ultima_factura->codigo_fac;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;
            $factura_num++;
            $sucursal_nr = str_pad($sucursal->codigo_sunat, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="F".$sucursal_nr."-".$factura_nr;
        return view('transaccion.venta.servicios.facturacion.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes','precio_prom','empresa','sucursal','factura_numero'));
    }

    public function create_ms(Request $request)
    {

        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','0')->first();

        // if($moneda->tipo =='extranjera'){
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
        //         $array[]=($servicio->precio_extranjero+$utilidad[$index])/$tipo_cambio->paralelo;
        //     }
        // }else{
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio_nacional*($servicio->utilidad)/100;
        //         $array[]=$servicio->precio_nacional+$utilidad[$index];
        //     }
        // }

        if($moneda->tipo =='extranjera'){
            foreach ($servicios as $index => $servicio) {
                $precio_prom[]=round($servicio->precio_nacional/$tipo_cambio->paralelo,2);
                $utilidad[]=$servicio->precio_nacional*($servicio->utilidad)/100;
                $array[]=round(($servicio->precio_nacional+$utilidad[$index])/$tipo_cambio->paralelo,2);
            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $precio_prom[]=round($servicio->precio_extranjero*$tipo_cambio->paralelo,2);
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $array[]=round(($servicio->precio_extranjero+$utilidad[$index])*$tipo_cambio->paralelo,2);
            }
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::where('principal','0')->first();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();
        $empresa = Empresa::first();
        $user_id =auth()->user();
        if($user_id->name=="Administrador"){
            $almacenes=Almacen::all();
        }else{
            $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        }
        $almacen=$request->get('almacen');

        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();

        $factura_cod_fac=$sucursal->cod_fac;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($sucursal->codigo_sunat, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_factura=Facturacion::where('almacen_id',$sucursal->id)->latest()->first();
            $factura_num=$ultima_factura->codigo_fac;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;
            $factura_num++;
            $sucursal_nr = str_pad($sucursal->codigo_sunat, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="F".$sucursal_nr."-".$factura_nr;
        return view('transaccion.venta.servicios.facturacion.create_ms',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes','precio_prom','factura_numero','empresa','sucursal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //buscador al cambio -----------------------------------------------------------------------------------------------------------
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        //codigo para convertir nombre a producto ------------------------------------------------------------------------------------
        $articulo = $request->input('articulo');
        $count_servicio=count($articulo);

        for($i=0 ; $i<$count_servicio;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $servicio_id[$i]=strstr($articulos[$i], ' ', true);
        }

        //validacion para la no incersion de dobles articulos -------------------------------------------------------------------------
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

        // Comisionista convertir id --------------------------------------------------------------------------------------------------
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

        //Convertir nombre del cliente a id --------------------------------------------------------------------------------------------
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);
        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();


        $forma_pago_id=$request->get('forma_pago');
        $formapago= Forma_pago::find($forma_pago_id);
        $dias= $formapago->dias;

        //Fecha de vencimiento ------------------------------------------------------------------------------------------------------------
        $fecha =date("d-m-Y");
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
        $nuevafechas = date("d-m-Y", $nuevafecha );

        // Moneda -----------------------------------------------------------------------------------------------------------------------
        $moneda_input=$request->get('moneda');
        $moneda=Moneda::where('nombre',$moneda_input)->first();

        // Almacen ---------------------------------------------------------------------------------------------------------------------
        $almacen=auth()->user()->almacen_id;
        $user_tipo=auth()->user()->name;
        if($user_tipo=='Administrador'){
            $almacen=$request->get('almacen');
        }

        // Codigo de Facturación -------------------------------------------------------------------------------------------------------
        // obtencion de la sucursal
        //obtencion del almacen
        $sucursal=Almacen::where('codigo_sunat', $almacen)->first();

        $factura_cod_fac=$sucursal->cod_fac;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // expreción del numero de fatura
            // generacion del numero de la factura
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

        // Guardado de Facturacion ------------------------------------------------------------------------------------------------------
        $facturacion=new Facturacion;
        $facturacion->codigo_fac=$factura_numero;
        $facturacion->almacen_id=$almacen;                        //corregit almacen
        $facturacion->orden_compra=$request->get('orden_compra');
        $facturacion->guia_remision=$request->get('guia_r');
        $facturacion->cliente_id=$cliente_buscador->id;
        $facturacion->moneda_id=$moneda->id;
        $facturacion->forma_pago_id=$request->get('forma_pago');
        $facturacion->fecha_emision=$request->get('fecha_emision');
        $facturacion->fecha_vencimiento=$nuevafechas;
        $facturacion->cambio=$cambio->paralelo;
        $facturacion->observacion=$request->get('observacion');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $facturacion->comisionista= $comisionista_buscador->id;
        }
        $facturacion->user_id =auth()->user()->id;
        $facturacion->estado='0';
        $facturacion->tipo='servicio';
        $facturacion->save();

        $check = $request->input('descuento_unitario');
        $count_check=count($check);
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        //validacion dependiendo de la moneda escogida ----------------------------------------------------------------------------
        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$facturacion->moneda_id;

        if($count_servicio = $count_check){
            for($i=0;$i<$count_servicio;$i++){
                $facturacion_registro=new Facturacion_registro();
                $facturacion_registro->facturacion_id=$facturacion->id;
                $facturacion_registro->servicio_id=$servicio_id[$i];

                $servicio=Servicios::where('id',$servicio_id[$i])->where('estado_anular',0)->first();
                //Precio -----------------------------------------------------------------------------------------
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional'){
                        $precio_prom = $servicio->precio_nacional;
                        $facturacion_registro->promedio_original= $precio_prom;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                        $array=$servicio->precio_nacional+$utilidad;
                    }else{
                        $precio_prom = $servicio->precio_extranjero;
                        $facturacion_registro->promedio_original=$precio_prom;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                        $array=$servicio->precio_extranjero+$utilidad;
                        return '1';
                    }
                }else{
                    if ($moneda->tipo == 'extranjera'){
                        $precio_prom = $servicio->precio_extranjero*$tipo_cambio->paralelo;
                        $facturacion_registro->promedio_original=$precio_prom;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                        $array=round(($servicio->precio_extranjero+$utilidad)*$tipo_cambio->paralelo,2);
                        return '2';
                    }else{
                        $precio_prom = $servicio->precio_nacional/$tipo_cambio->paralelo;
                        $facturacion_registro->promedio_original=$precio_prom;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                        $array=round(($servicio->precio_nacional+$utilidad)/$tipo_cambio->paralelo,2);
                        // return $array;
                    }
                }


                $facturacion_registro->precio=$array;
                $facturacion_registro->cantidad=$request->get('cantidad')[$i];
                $facturacion_registro->comision=$comi;
                $descuento_verificacion=$request->get('check_descuento')[$i];
                $facturacion_registro->descuento=$descuento_verificacion;

                if($descuento_verificacion <> 0){
                $facturacion_registro->precio_unitario_desc=$array-($precio_prom*$descuento_verificacion/100);
                }else{
                    $facturacion_registro->precio_unitario_desc=$array;
                }
                    //precio unitario comision ----------------------------------------
                if($descuento_verificacion <> 0){
                    $prec_uni_des=$array-($precio_prom*$descuento_verificacion/100);
                    $facturacion_registro->precio_unitario_comi=($prec_uni_des+($prec_uni_des*$comi/100));
                }else{
                    $facturacion_registro->precio_unitario_comi=$array+($array*$comi/100);
                }
                $facturacion_registro->save();
            }
        }else {
            return redirect()->route('facturacion_servicio.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('facturacion_servicio.show',$facturacion->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $empresa=Empresa::first();
        $facturacion=Facturacion::find($id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();

        return view('transaccion.venta.servicios.facturacion.show', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
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
