<?php

namespace App\Http\Controllers;

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
    public function create()
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

        return view('transaccion.venta.servicios.facturacion.create',compact('servicios','forma_pagos','clientes','personales','array','igv','moneda','p_venta'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

        //revisar que numero de factura a servicio es
        $personal_contador= Facturacion::all()->count();
        $suma=$personal_contador+1;
        $codigo='COFAC-0000'.$suma;

        $facturacion=new Facturacion;
        $facturacion->codigo_fac=$codigo;
        $facturacion->cliente_id=$cliente_buscador->id;
        $facturacion->forma_pago_id=$request->get('forma_pago');

        $facturacion->moneda_id=$request->get('moneda');

        $facturacion->user_id =auth()->user()->id;
        $facturacion->observacion=$request->get('observacion');
        $facturacion->fecha_emision=$request->get('fecha_emision');
        $facturacion->orden_compra=$request->get('orden_compra');
        $facturacion->fecha_vencimiento=$nuevafechas;
        $facturacion->guia_remision=$request->get('guia_r');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $facturacion->comisionista_id= $comisionista_buscador->id;
        }
        $facturacion->estado='0';
        $facturacion->tipo='servicio';
        $facturacion->save();

        $check = $request->input('descuento_unitario');
        $count_check=count($check);

        if($count_servicio = $count_check){
            for($i=0;$i<$count_servicio;$i++){
                $cotizacion_registro=new Facturacion_registro();
                $cotizacion_registro->facturacion_id=$facturacion->id;
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
