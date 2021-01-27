<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Boleta;
use App\Boleta_registro;
use App\Cliente;
use App\Cotizacion_Servicios;
use App\Empresa;
use App\Forma_pago;
use App\Igv;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Servicios;
use App\TipoCambio;
use App\Almacen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BoletaServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','1')->first();
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        // if($moneda->tipo =='nacional'){
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
        //         $igv[]=$servicio->precio*$igv_total/100;
        //         $array[]=$servicio->precio+$utilidad[$index]+$igv[$index];
        //     }
        // }else{
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
        //         $igv[]=$servicio->precio*$igv_total/100;
        //         $array[]=($servicio->precio+$utilidad[$index]+$igv[$index])*$tipo_cambio->paralelo;
        //     }
        // }

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

        return view('transaccion.venta.servicios.boleta.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes'));
    }

    public function create_ms()
    {

        $servicios=Servicios::where('estado_anular',0)->get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        $moneda=Moneda::where('principal','0')->first();
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        // if($moneda->tipo =='extranjera'){
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
        //         $igv[]=$servicio->precio*$igv_total/100;
        //         $array[]=($servicio->precio+$utilidad[$index]+$igv[$index])/$tipo_cambio->paralelo;
        //     }
        // }else{
        //     foreach ($servicios as $index => $servicio) {
        //         $utilidad[]=$servicio->precio*($servicio->utilidad)/100;
        //         $igv[]=$servicio->precio*$igv_total/100;
        //         $array[]=$servicio->precio+$utilidad[$index]+$igv[$index];
        //     }
        // }

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
                $array[]=($servicio->precio_extranjero+$utilidad[$index]+$igv[$index])/$tipo_cambio->paralelo;
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

        return view('transaccion.venta.servicios.boleta.create_ms',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes'));
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

        //codigo para convertir nombre a producto --------------------------------------------------------------------------------------
        $articulo = $request->input('articulo');
        $count_servicio=count($articulo);

        for($i=0 ; $i<$count_servicio;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $servicio_id[$i]=strstr($articulos[$i], ' ', true);
        }

        //validacion para la no incersion de dobles articulos  -------------------------------------------------------------------------
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

        // Fecha vencimiento ------------------------------------------------------------------------------------------------------------
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
        $sucursal=Almacen::where('codigo_sunat', $almacen)->first();

        $boletear_cod_bol=$sucursal->cod_fac;
        if (is_numeric($boletear_cod_bol)) {
            // exprecion del numero de fatura
            $boletear_cod_bol++;
            $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boletear_cod_bol, 8, "0", STR_PAD_LEFT);
        }else{
            // expreción del numero de fatura
            // generacion del numero de la factura
            $ultima_boleta=Boleta::latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            $boleta_num++;
            $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;

        // Guardado de Boleta ------------------------------------------------------------------------------------------------------
        $boleta=new Boleta;
        $boleta->codigo_boleta=$boleta_numero;
        $boleta->almacen_id=$almacen;
        $boleta->orden_compra=$request->get('orden_compra');
        $boleta->guia_remision=$request->get('guia_r');
        $boleta->cliente_id=$cliente_buscador->id;
        $boleta->moneda_id=$moneda->id;
        $boleta->forma_pago_id=$request->get('forma_pago');
        $boleta->fecha_emision=$request->get('fecha_emision');
        $boleta->fecha_vencimiento=$nuevafechas;
        $boleta->cambio=$cambio->paralelo;
        $boleta->observacion=$request->get('observacion');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $boleta->comisionista_id= $comisionista_buscador->id;
        }
        $boleta->user_id =auth()->user()->id;
        $boleta->estado='0';
        $boleta->tipo='servicio';
        $boleta->save();

        $check = $request->input('descuento_unitario');
        $count_check=count($check);

        // Obtención del IGV -----------------------------------------------------------------------------------------------------
        $igv_proceso=Igv::first();
        $igv_total=$igv_proceso->igv_total;

        //validacion dependiendo de la moneda escogida ----------------------------------------------------------------------------
        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$boleta->moneda_id;
        //ultimo tipo de cambio
        $tipo_cambio=TipoCambio::latest('created_at')->first();

        if($count_servicio = $count_check){
            for($i=0;$i<$count_servicio;$i++){
                $boleta_registro=new Boleta_registro();
                $boleta_registro->boleta_id=$boleta->id;
                $boleta_registro->servicio_id=$servicio_id[$i];

                $servicio=Servicios::where('id',$servicio_id[$i])->where('estado_anular',0)->first();
                //Precio -----------------------------------------------------------------------------------------
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional'){
                        $boleta_registro->promedio_original=$servicio->precio_nacional;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                        $igv=$servicio->precio_nacional*$igv_total/100;
                        $array=$servicio->precio_nacional+$utilidad+$igv;
                         $boleta_registro->precio=$array;
                    }else{
                        $boleta_registro->promedio_original=$servicio->precio_extranjero;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                        $igv=$servicio->precio_extranjero*$igv_total/100;
                        $array=($servicio->precio_extranjero+$utilidad+$igv)*$tipo_cambio->paralelo;
                         $boleta_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera'){
                        $boleta_registro->promedio_original=$servicio->precio_extranjero;
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                        $igv=$servicio->precio_extranjero*$igv_total/100;
                        $array=($servicio->precio_extranjero+$utilidad+$igv)/$tipo_cambio->paralelo;
                         $boleta_registro->precio=$array;
                    }else{
                        $boleta_registro->promedio_original=$servicio->precio_nacional;
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                        $igv=$servicio->precio_nacional*$igv_total/100;
                        $array=$servicio->precio_nacional+$utilidad+$igv;
                         $boleta_registro->precio=$array;
                    }
                }



                $boleta_registro->cantidad=$request->get('cantidad')[$i];

                //descuento
                $descuento_verificacion=$request->get('check_descuento')[$i];
                if($descuento_verificacion <> 0){
                    $boleta_registro->descuento=$servicio->descuento;
                    $desc_comprobacion=$servicio->descuento;
                }else{
                    $boleta_registro->descuento=0;
                    $desc_comprobacion=0;
                }

                //precio unitario descuento
                if($desc_comprobacion <> 0){
                    $boleta_registro->precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                    $precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                }else{
                    $boleta_registro->precio_unitario_desc=$array;
                    $precio_unitario_desc=$array;
                }

                $boleta_registro->comision=$comi;
                $boleta_registro->precio_unitario_comi=$precio_unitario_desc+($precio_unitario_desc*$comi/100);


                $boleta_registro->save();
            }
        }else {
            return redirect()->route('boleta_servicio.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('boleta_servicio.show',$boleta->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::all();
        $empresa=Empresa::first();
        $sub_total=0;
        $boleta=Boleta::find($id);
        // return $boleta->id;
        return view('transaccion.venta.servicios.boleta.show', compact('boleta','empresa','banco','boleta_registro','igv','sub_total'));
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
