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
use App\Kardex_entrada;
use App\Servicios;
use App\TipoCambio;
use App\Almacen;
use App\Codigo_guia_almacen;
use Carbon\Carbon;
use App\Ventas_registro;
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
    public function create(Request $request)
    {
        $inventario_inicial=Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ( $inventario_inicial->estado==1) {
                return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
            }
        }

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
                $igv_precio[]=$servicio->precio_nacional;
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=round(($servicio->precio_nacional+$utilidad[$index]),2);

            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $igv_precio[]=$servicio->precio_extranjero;
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=round($servicio->precio_extranjero+$utilidad[$index],2);

            }
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $empresa=Empresa::first();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        // $user_id =auth()->user();
        // if($user_id->name=="Administrador"){
        //     $almacenes=Almacen::all();
        // }else{
        //     $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        // }
        // $almacen=1;
        $almacen = $request->get('almacen');
        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();
        $codigo_guia = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $boleta_cod_fac=$codigo_guia->cod_boleta;
        if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
            $boleta_cod_fac++;
            $sucursal_nr = str_pad($codigo_guia->serie_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta+1;
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $codigo_guia->serie_boleta;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        // return $sucursal_nr;
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;
        return view('transaccion.venta.servicios.boleta.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacen','empresa','boleta_numero','sucursal','igv_precio'));
    }

    public function create_ms(Request $request)
    {
        $inventario_inicial=Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ( $inventario_inicial->estado==1) {
                return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
            }
        }

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
                $igv_precio[]=round(($servicio->precio_nacional)/$tipo_cambio->paralelo,2);
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=round(($servicio->precio_nacional+$utilidad[$index])/$tipo_cambio->paralelo,2);

            }
        }else{
            foreach ($servicios as $index => $servicio) {
                $utilidad[]=$servicio->precio_extranjero*($servicio->utilidad)/100;
                $igv_precio[]=round(($servicio->precio_extranjero)*$tipo_cambio->paralelo,2);
                $igv[]=$igv_precio[$index]*$igv_total/100;
                $array[]=round(($servicio->precio_extranjero+$utilidad[$index])*$tipo_cambio->paralelo,2);

            }
        }
        $almacen = $request->get('almacen');
        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $empresa =Empresa::first();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();

        // $user_id =auth()->user();
        // if($user_id->name=="Administrador"){
        //     $almacenes=Almacen::all();
        // }else{
        //     $almacenes=Almacen::where('id',$user_id->almacen_id)->get();
        // }
        $sucursal=Almacen::where('id', $almacen)->first();
        $codigo_guia = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $boleta_cod_fac=$codigo_guia->cod_boleta;
        if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
            $boleta_cod_fac++;
            $sucursal_nr = str_pad($codigo_guia->serie_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
            if($boleta_num == 99999999){
                $ultima_boleta= $almacen_codigo->serie_boleta+1;
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $codigo_guia->serie_boleta;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;
        return view('transaccion.venta.servicios.boleta.create_ms',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta','almacenes','sucursal','boleta_numero','almacen','empresa','igv_precio'));
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
        $tipo_cambio=TipoCambio::latest('created_at')->first();

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
            //Comision segun comisionista
            $comi=$comisionista_buscador->comision;
            $comision_id = $comisionista_buscador->id;
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
        $almacen=$request->get('almacen');
        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();
        $codigo_guia = Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        $boleta_cod_fac=$codigo_guia->cod_boleta;
        if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
            $boleta_cod_fac++;
            $sucursal_nr = str_pad($codigo_guia->serie_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_boleta','DESC')->latest()->first();
            // return $almacen_codigo;
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta+1;
                $almacen_save_last = Codigo_guia_almacen::find($codigo_guia->id);
                $almacen_save_last->serie_boleta = $almacen_codigo->serie_boleta+1;
                $almacen_save_last->save();
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $codigo_guia->serie_boleta;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;

        $igv=Igv::first();
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
            $boleta->comisionista= $comisionista_buscador->id;
        }
        $boleta->user_id =auth()->user()->id;
        $boleta->estado='0';
        $boleta->tipo='servicio';
        $boleta->save();

        $total_comi=$request->get('total_comi');

        // return $request;
        if(isset($comision_id)){
            $comisionista_porcentaje=Personal_venta::where('id',$comision_id)->first();
            $comisionista=new Ventas_registro;
            $comisionista->comisionista=$comision_id;
            $comisionista->tipo_moneda=$moneda->id;
            $comisionista->estado_aprobado='0';
            $comisionista->estado_pagado='0';
            $comisionista->estado_anular_fac_bol='0';
            $comisionista->monto_final_fac_bol=$total_comi;
            $porcentaje_igv=100+$igv->igv_total;
            $porcentaje=100+$comisionista_porcentaje->comision;
            $comisionista->monto_comision=((100*$total_comi/$porcentaje_igv)*100/$porcentaje)*$comisionista_porcentaje->comision/100;
            // $comisionista->id_coti_produc=$cotizador;
            $comisionista->id_bol=$boleta->id;
            $comisionista->observacion='Boleta';
            $comisionista->save();
        }

        $check = $request->input('descuento_unitario');
        $count_check=count($check);

        $boleta_primera=Codigo_guia_almacen::where('almacen_id', $sucursal->id)->first();
        if(is_numeric($boleta_primera->cod_boleta)){
            $boleta_primera->cod_boleta='NN';
            $boleta_primera->save();
        }

        // Obtención del IGV -----------------------------------------------------------------------------------------------------

        $igv_total=$igv->igv_total;

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
                        $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                        $pre_prome=$servicio->precio_nacional;
                        $boleta_registro->promedio_original=$pre_prome;
                        // $igv=$igv_precio*$igv_total/100;
                        $array=$servicio->precio_nacional+$utilidad;
                        $boleta_registro->precio=$array;
                        // return 1;
                    }else{
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                        $pre_prome=$servicio->precio_extranjero;
                        $boleta_registro->promedio_original=$pre_prome;
                        // $igv=$igv_precio*$igv_total/100;
                        $array=$servicio->precio_extranjero+$utilidad;
                        $boleta_registro->precio=$array;
                        // return 2;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera'){
                        $utilidad=$servicio->precio_extranjero*($servicio->utilidad)/100;
                        $pre_prome=round(($servicio->precio_extranjero+$utilidad)*$tipo_cambio->paralelo,2);
                        $boleta_registro->promedio_original=$pre_prome;
                        // $igv=$igv_precio*$igv_total/100;
                        $array=round(($servicio->precio_extranjero+$utilidad)*$tipo_cambio->paralelo,2);
                        $boleta_registro->precio=$array;
                        // return 3;

                    }else{

                        $utilidad=$servicio->precio_nacional*($servicio->utilidad)/100;
                        $pre_prome=round($servicio->precio_nacional/$tipo_cambio->paralelo,2);
                        $boleta_registro->promedio_original=$pre_prome;
                        // $igv=$igv_precio*$igv_total/100;
                        $array=round((($servicio->precio_nacional+$utilidad)/$tipo_cambio->paralelo),2);
                        $boleta_registro->precio=$array;
                        // return 4;

                    }
                }
            $boleta_registro->cantidad=$request->get('cantidad')[$i];
            $boleta_registro->descuento=$request->get('check_descuento')[$i];
            $boleta_registro->comision=$comi;
                //precio unitario descuento ----------------------------------------
            $desc_comprobacion=$request->get('check_descuento')[$i];

            if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                $igv=Igv::first();
                $igv_ac = $igv->igv_total;
            }else{
                $igv_ac = 0;
            }
                
            if($desc_comprobacion <> 0){
                $precio_uni = $array - ($pre_prome*$desc_comprobacion/100);
                $boleta_registro->precio_unitario_desc=$precio_uni+($precio_uni*($igv_ac/100));
                // return $array*($igv->igv_total/100);
            }else{
                $precio_uni = $array + ($array*($igv_ac/100));
                $boleta_registro->precio_unitario_desc=$precio_uni;
                // return $array_pre_prom;
            }
            // return $precio_uni;
                //precio unitario comision ----------------------------------------
            if($desc_comprobacion <> 0){
                 $precio_uni = $array - ($pre_prome*$desc_comprobacion/100);
                 $precio_comi = $precio_uni+($precio_uni*($comi/100));
                 $boleta_registro->precio_unitario_comi=$precio_comi+($precio_comi*($igv_ac/100));
            }else{
                $precio_comi = $array+($array*($comi/100));
                $boleta_registro->precio_unitario_comi=($precio_comi)+($precio_comi*($igv_ac/100));
            }
                 //TIPO DE AFECTACION
                $cotizacion_2=Boleta::find($boleta->id);
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                    $cotizacion_2->op_gravada += round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                    $cotizacion_2->op_exonerada += round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2);
                }
                if(strpos($servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                    $cotizacion_2->op_inafecta += round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2);
                }
                $cotizacion_2->save();

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
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=kardex_entrada::where('estado',2)->first();
        if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id=Boleta::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('boleta.index'); }

        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::all();
        $empresa=Empresa::first();
        $sub_total=0;
        $boleta=Boleta::find($id);
        // return $boleta->id;
        return view('transaccion.venta.servicios.boleta.show', compact('boleta','empresa','banco','boleta_registro','igv','sub_total'));
        // return $boleta;
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
