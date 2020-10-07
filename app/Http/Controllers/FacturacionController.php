<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Banco;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_registro;
use App\Forma_pago;
use App\Igv;
use App\Marcas;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Producto;
use App\Servicios;
use App\TipoCambio;
use App\Unidad_medida;
use App\User;
use App\Ventas_registro;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturacion=Facturacion::all();
        return view('transaccion.venta.facturacion.index', compact('facturacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax()
    {
        $msg = "Ejemplo rapido";
        return response()->json(array('msg'=> $msg), 200);
    }

// creacion para productos
    public function create(){

        // $kardex_prod=kardex_entrada_registro::join("productos","kardex_entrada_registro.producto_id","productos.id")
        // ->where('estado',1)->get();

        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        // return $kardex_prod;

         //aplicamiento de logica para llamar un producto hacia kardex
         $moneda=Moneda::where('principal','1')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
         if ($moneda->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional');
            }
         }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero');
            }
        }

        

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();
        $empresa=Empresa::first();
        $personal_contador= Facturacion::all()->count();
        $suma=$personal_contador+1;
        $categoria='producto';

        // obtencion de la sucursal
        $sucursal=auth()->user()->almacen->codigo_sunat;
        //obtencion del almacen
        $factura_primera=Almacen::where('codigo_sunat', $sucursal)->first();
        $factura_cod_fac=$factura_primera->cod_fac;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($sucursal, 3, "0", STR_PAD_LEFT);
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

            $sucursal_nr = str_pad($sucursal, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="F".$sucursal_nr."-".$factura_nr;

        return view('transaccion.venta.facturacion.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','factura_numero'));
}

    public function create_ms(){
        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        $moneda=Moneda::where('principal','0')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        
        if ($moneda->tipo == 'extranjero'){
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional');
            }
        }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero');
            }
        }


        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();

        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $igv=Igv::first();
        $empresa=Empresa::first();
        $personal_contador= Facturacion::all()->count();
        $suma=$personal_contador+1;
        $categoria='producto';

        // obtencion de la sucursal
        $sucursal=auth()->user()->almacen->codigo_sunat;
        //obtencion del almacen
        $factura_primera=Almacen::where('codigo_sunat', $sucursal)->first();
        $factura_cod_fac=$factura_primera->cod_fac;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($sucursal, 3, "0", STR_PAD_LEFT);
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
            $sucursal_nr = str_pad($sucursal, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="F".$sucursal_nr."-".$factura_nr;

        return view('transaccion.venta.facturacion.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','factura_numero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id_moneda)
    {
        $facturacion_input=$request->get('facturacion');
        if ($facturacion_input=='producto') {
          $print=$request->get('print');

          if($print==1){
            $cliente_id=$request->get('cliente');

            $sub_total=0;
            $igv=Igv::first();

            $forma_pago_id=$request->get('forma_pago');
            $moneda_id=$id_moneda;
            $validez=$request->get('validez');
            $garantia=$request->get('garantia');
            $user_id =auth()->user()->id;
            $observacion=$request->get('observacion');

            $articulo = $request->input('articulo');
            $count_articulo=count($articulo);

            $cantidad_p = $request->input('cantidad');
            $count_cantidad_p=count($cantidad_p);

            for($i=0 ; $i<$count_cantidad_p;$i++){
                $articulos[$i]= $request->input('articulo')[$i];
                $producto_id[$i]=strstr($articulos[$i], ' ', true);
                $producto_codigo[$i]=Producto::where('id',$producto_id[$i])->first();
                $unidad_medida[$i]=Unidad_medida::where('id',$producto_codigo[$i]->unidad_medida_id)->first();
            }

            for($i=0;$i<$count_articulo;$i++){
                $stock[]=$request->input('stock')[$i];
                $cantidad[]=$request->input('cantidad')[$i];
                $precio[]=$request->input('precio')[$i];
                $check_descuento[]=$request->input('check_descuento')[$i];
                $promedio_original[]=$request->input('promedio_original')[$i];
                $descuento[]=$request->input('descuento')[$i];
                $precio_unitario_descuento[]=$request->input('precio_unitario_descuento')[$i];
                $comision[]=$request->input('comision')[$i];
                $precio_unitario_comision[]=$request->input('precio_unitario_comision')[$i];
            }

            return view('transaccion.venta.cotizacion.factura.fast_print',compact('producto_codigo','unidad_medida','sub_total','igv','cliente_id','forma_pago_id','validez','user_id','observacion','producto_id','stock','cantidad','precio','check_descuento','promedio_original','descuento','precio_unitario_descuento','comision','precio_unitario_comision'));
        }

        //codigo para convertir nombre a producto
        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id[$i]=strstr($articulos[$i], ' ', true);
        }

        //contador de valores de articulos
        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        //validacion para la no incersion de dobles articulos
        for ($e=0; $e < $count_articulo; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_articulo ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial==$articulo_comparacion) {
                        return redirect()->route('facturacion.create')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }

            }
        }
        // Comisionista convertir id

        $comisionista=$request->get('comisionista');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $numero = strstr($comisionista, '-',true);

            $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            $id_personal=$cod_vendedor->id;

            $comisionista_buscador=Personal_venta::where('id',$id_personal)->first();
            //Comision segun comisionista
            $comi=$comisionista_buscador->comision;
        }else{
            $comi=0;
        }

        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);

        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();

        $forma_pago_id=$request->get('forma_pago');
        $formapago= Forma_pago::find($forma_pago_id);
        $dias= $formapago->dias;
        /*Fecha vencimiento --------------------------------------------------- */
        $fecha =date("d-m-Y");
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
        $nuevafechas = date("d-m-Y", $nuevafecha );

        $fac= Facturacion::all()->count();
        $suma=$fac+1;
        $cod_fac='FC-000'.$suma;

        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        $facturacion=new facturacion;
        $facturacion->codigo_fac=$cod_fac;
        $facturacion->orden_compra=$request->get('orden_compra');
        $facturacion->guia_remision=$request->get('guia_r');



        $facturacion->cliente_id=$cliente_buscador->id;
        $facturacion->moneda_id=$id_moneda;
        $facturacion->forma_pago_id=$request->get('forma_pago');
        $facturacion->fecha_emision=$request->get('fecha_emision');
        $facturacion->fecha_vencimiento=$nuevafechas;
        $facturacion->cambio=$cambio->paralelo;
        $facturacion->observacion=$request->get('observacion');
        $facturacion->comisionista='0';
        $facturacion->user_id =auth()->user()->id;
        $facturacion->estado='0';
        $facturacion->tipo='producto';
        $facturacion->save();

        // modificacion para que se cierre el codigo en almacen
        // obtencion de la sucursal
        $sucursal=auth()->user()->almacen->codigo_sunat;
        //obtencion del almacen
        $factura_primera=Almacen::where('codigo_sunat', $sucursal)->first();
        $factura_primera->cod_fac='NN';
        $factura_primera->save();

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores del check descuento
        $check = $request->input('check_descuento');
        $count_check=count($check);

        //validacion dependiendo de la amoneda escogida
        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$facturacion->moneda_id;

        if($count_articulo = $count_cantidad  = $count_check){
            for($i=0;$i<$count_articulo;$i++){
                $facturacion_registro=new Facturacion_registro();
                $facturacion_registro->facturacion_id=$facturacion->id;
                $facturacion_registro->producto_id=$producto_id[$i];
                //$facturacion_registro->servicio_id = no esta porque esto es registro para productos
                $facturacion_registro->numero_serie=$request->get('numero_serie')[$i];
                $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
                //stock --------------------------------------------------------
                $stock=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->sum('cantidad');
                $facturacion_registro->stock=$stock;
                //promedio original --------------------------------------------------------
                $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional');
                $facturacion_registro->promedio_original=$array2;
                //precio --------------------------------------------------------
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional') {
                        // respectividad de la moneda deacurdo al id
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad;
                        $facturacion_registro->precio=$array;
                    }else {
                        // validacion para la otra moneda con igv paralelo
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad;
                        $facturacion_registro->precio=$array;
                    }

                }else{
                    if ($moneda->tipo == 'extranjero') {
                        // respectividad de la moneda deacurdo al id
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad;
                        $facturacion_registro->precio=$array*$cambio->paralelo;
                    }else{
                        // validacion para la otra moneda con igv paralelo
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad;
                        $facturacion_registro->precio=$array*$cambio->paralelo;
                    }
                   
                }
                $facturacion_registro->cantidad=$request->get('cantidad')[$i];
                $facturacion_registro->descuento=$request->get('check_descuento')[$i];
                $facturacion_registro->comision=$comi;
                //precio unitario descuento ----------------------------------------
                $desc_comprobacion=$request->get('check_descuento')[$i];
                if($desc_comprobacion <> 0){
                    $facturacion_registro->precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                }else{
                    $facturacion_registro->precio_unitario_desc=$array;
                }
                //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                    $facturacion_registro->precio_unitario_comi=($array-($array*$desc_comprobacion/100))+($array*$comi/100);
                }else{
                    $facturacion_registro->precio_unitario_comi=$array+($array*$comi/100);
                }
                $facturacion_registro->save();

            }
        }else {
            return redirect()->route('facturacion.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('facturacion.show',$facturacion->id);
    }
    /*Producto fin*/
    /*Servicio inicio*/
    elseif ($facturacion_input=='servicio') {
                $hola='en curso';
                return $hola;
    }

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
        if ($facturacion->id_cotizador_servicio==NULL) {
            return view('transaccion.venta.facturacion.show', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
        }else{
            return view('transaccion.venta.facturacion.show_servicio', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
        }

    }

    function print($id){
        $empresa=Empresa::first();
        $facturacion=Facturacion::find($id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();

        return view('transaccion.venta.facturacion.print', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
    }

    public function show_boleta(Request $request,$id)
    {
        return view('transaccion.venta.facturacion.boleta');
    }

     public function create_boleta()
     {
         return view('transaccion.venta.facturacion.create_boleta');
     }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facturacion=Facturacion::find($id);
        return view('transaccion.venta.facturacion.edit', compact('facturacion'));
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
        $venta_registro=Ventas_registro::where('id_facturacion',$id)->first();
        $id_venta_r=$venta_registro->id;

        $venta=Ventas_registro::where('id',$id_venta_r)->first();
        $venta->estado_fac=1;
        $venta->save();

        $fac=Facturacion::where('id',$id)->first();
        $fac->estado=1;
        $fac->save();

        return redirect()->route('facturacion.index');
    }
}
