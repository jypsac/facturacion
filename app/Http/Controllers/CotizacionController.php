<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Banco;
use App\Boleta;
use App\Boleta_registro;
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
use App\Unidad_medida;
use App\User;
use App\Ventas_registro;
use App\kardex_entrada_registro;
use App\TipoCambio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $cotizacion=Cotizacion::all();
        $user_login =auth()->user();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen=Almacen::where('estado',0)->get();
        $almacen_primero=Almacen::where('estado',0)->first();

        return view('transaccion.venta.cotizacion.index',compact('cotizacion','conteo_almacen','user_login','almacen','almacen_primero'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_factura(Request $request)
    {
        
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
        
        //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion::latest()->first();
        if($ultima_factura){
            $code=$ultima_factura->id;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTPF ".$sucursal_nr."-".$cotizacion_nr;
        
        return view('transaccion.venta.cotizacion.factura.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','cotizacion_numero','sucursal'));
    }

    //create factura modensa secundaruia

    public function create_factura_ms(Request $request)
    {
        
        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        $moneda=Moneda::where('principal','0')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();

        if ($moneda->tipo == 'extranjera'){
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

        //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion::latest()->first();
        if($ultima_factura){
            $code=$ultima_factura->id;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTPF ".$sucursal_nr."-".$cotizacion_nr;

        return view('transaccion.venta.cotizacion.factura.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','cotizacion_numero','sucursal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     ///agregamiento de un parametro extra
    public function store_factura(Request $request,$id_moneda)
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
            // $produc=Producto::all()->get();

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
                        return redirect()->route('cotizacion.create_factura')->with('repite', 'Datos repetidos - No permitidos!');
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
            //Comision segun comisionista
            // $personal_venta=Personal_venta::where('id_personal',$comisionista_buscador->id)->first();
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
        /*Fecha vencimiento*/
        $fecha =date("d-m-Y");
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
        $nuevafechas = date("d-m-Y", $nuevafecha );


        //PARA GENERAR EL CODIGO DE LA COTIZACION   
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion::latest()->first();
        if($ultima_factura){
            $code=$ultima_factura->id;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTPF ".$sucursal_nr."-".$cotizacion_nr;

        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        //PARA SELECCIONAR EL ALMACEN CODIGO PARA AÑADIR
        //if(auth()->user()->name == "Administrador"){
          //  $almacen=$request->get('almacen');
        //}else{
          //  $almacen=Almacen::where('id',auth()->user()->almacen_id)->first();
        //}
        
        $cotizacion=new Cotizacion;
        $cotizacion->cod_cotizacion=$cotizacion_numero;
        $cotizacion->almacen_id=$request->get('almacen');
        $cotizacion->cliente_id=$cliente_buscador->id;
        $cotizacion->moneda_id=$id_moneda;
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->estado_aprovar='0';
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

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores del check descuento
        $check = $request->input('check_descuento');
        $count_check=count($check);

        //validacion dependiendo de la amoneda escogida
        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$cotizacion->moneda_id;

        if($count_articulo = $count_cantidad  = $count_check){
            for($i=0;$i<$count_articulo;$i++){
                $cotizacion_registro=new Cotizacion_factura_registro;
                $cotizacion_registro->cotizacion_id=$cotizacion->id;
                $cotizacion_registro->producto_id=$producto_id[$i];
                $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
                //stock --------------------------------------------------------
                $stock=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->sum('cantidad');
                $cotizacion_registro->stock=$stock;
                
                //precio --------------------------------------------------------
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional') {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional');
                        $cotizacion_registro->promedio_original=$array2;

                        // respectividad de la moneda deacurdo al id
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad;
                        $cotizacion_registro->precio=$array;
                    }else {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero');
                        $cotizacion_registro->promedio_original=$array2;
                        
                        // validacion para la otra moneda con igv paralelo
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad;
                        $cotizacion_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera') {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero');
                        $cotizacion_registro->promedio_original=$array2;

                        // respectividad de la moneda deacuerdo al id
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad)*$cambio->paralelo;
                        $cotizacion_registro->precio=$array;
                    }else{
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional');
                        $cotizacion_registro->promedio_original=$array2;

                        // validacion para la otra moneda con igv paralelo
                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad)/$cambio->paralelo;
                        $cotizacion_registro->precio=$array;
                    }
                }
                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];
                $cotizacion_registro->descuento=$request->get('check_descuento')[$i];
                $cotizacion_registro->comision=$comi;
                //precio unitario descuento ----------------------------------------
                $desc_comprobacion=$request->get('check_descuento')[$i];
                if($desc_comprobacion <> 0){
                    $cotizacion_registro->precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                }else{
                    $cotizacion_registro->precio_unitario_desc=$array;
                }
                //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                    $cotizacion_registro->precio_unitario_comi=($array-($array*$desc_comprobacion/100))+($array*$comi/100);
                }else{
                    $cotizacion_registro->precio_unitario_comi=$array+($array*$comi/100);
                }
                $cotizacion_registro->save();
            }
        }else {
            return redirect()->route('cotizacion.create_factura')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('cotizacion.show',$cotizacion->id);

        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function create_boleta(Request $request)
    {
        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        $moneda=Moneda::where('principal','1')->first();

        $igv=Igv::where('id','1')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        if ($moneda->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])*($igv->igv_total/100);
                
                $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index]+$igv_p[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional');
            }
        }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*($igv->igv_total/100);
                
                $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index]+$igv_p[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero');
            }
        }


        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        $moneda=Moneda::where('principal','1')->first();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();


        $empresa=Empresa::first();

        //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion::latest()->first();
        if($ultima_factura){
            $code=$ultima_factura->id;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTPB ".$sucursal_nr."-".$cotizacion_nr;

        return view('transaccion.venta.cotizacion.boleta.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','boleta_codigo','cotizacion_numero','sucursal'));
        
        //return view('transaccion.venta.cotizacion.boleta.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio'));
    }

    //agregamiento de una nueva funcion create_boleta a monde secundaria comnetado
    public function create_boleta_ms(Request $request)
    {
        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        $moneda=Moneda::where('principal','0')->first();
        $igv=Igv::first();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        if ($moneda->tipo == 'extranjera') {
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index]+$igv_p[$index])/$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional');
            }
        }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*($igv->igv_total/100);
                
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index]+$igv_p[$index])*$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_extranjero');
            }
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::where('documento_identificacion','ruc')->get();
        
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        

        $empresa=Empresa::first();

        //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion::latest()->first();
        if($ultima_factura){
            $code=$ultima_factura->id;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTPB ".$sucursal_nr."-".$cotizacion_nr;

        return view('transaccion.venta.cotizacion.boleta.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','cotizacion_numero','sucursal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  agregar una nueva parametro para recibirtipo de moneda
    public function store_boleta(Request $request,$id_moneda)
    {
        //El input esta activo

        // return $request;
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
            // $produc=Producto::all()->get();

            return view('transaccion.venta.cotizacion.boleta.fast_print',compact('producto_codigo','unidad_medida','sub_total','igv','cliente_id','forma_pago_id','validez','user_id','observacion','producto_id','stock','cantidad','precio','check_descuento','promedio_original','descuento','precio_unitario_descuento','comision','precio_unitario_comision'));
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
                        return redirect()->route('cotizacion.create_boleta')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }

            }
        }
        // Comisionista convertir id

        $comisionista=$request->get('comisionista');
        if($comisionista!="" and $comisionista!="Sin comision - 0"){
            $numero = strstr($comisionista, '-',true);

            // $numero_doc=personal::where('numero_documento',$numero)->first();
            // $id_personal=$numero_doc->id;

            $cod_vendedor=Personal_venta::where('cod_vendedor',$numero)->first();
            $id_personal=$cod_vendedor->id;

            $comisionista_buscador=Personal_venta::where('id',$id_personal)->first();
            //Comision segun comisionista
            // $personal_venta=Personal_venta::where('id_personal',$comisionista_buscador->id)->first();
            $comi=$comisionista_buscador->comision;
        }else{
            $comi=0;
        }



        //Convertir nombre del cliente a id
        $cliente_nombre=$request->get('cliente');
        $nombre = strstr($cliente_nombre, '-',true);

        $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();
        // return $cliente_buscador->id;

        $personal_contador= Cotizacion::all()->count();
        $suma=$personal_contador+1;
        $cod_comision='COBOL-0000'.$suma;


        $forma_pago_id=$request->get('forma_pago');
        $formapago= Forma_pago::find($forma_pago_id);
        $dias= $formapago->dias;
        /*Fecha vencimiento*/
        $fecha =date("d-m-Y");
        $nuevafecha = strtotime ( '+'.$dias.' day' , strtotime ( $fecha ) ) ;
        $nuevafechas = date("d-m-Y", $nuevafecha );

        //PARA GENERAR EL CODIGO DE LA COTIZACION   
        //CODIGO COTIZACION
        $sucursal=$request->get('almacen');
        $sucursal=Almacen::where('id',$sucursal)->first();
        $ultima_factura=Cotizacion::latest()->first();
        if($ultima_factura){
            $code=$ultima_factura->id;
            $code++;
        }else{
            $code=1;
        }
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $cotizacion_nr=str_pad($code, 8, "0", STR_PAD_LEFT);
        $cotizacion_numero="COTPB ".$sucursal_nr."-".$cotizacion_nr;

        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        //PARA SELECCIONAR EL ALMACEN CODIGO PARA AÑADIR
        // if(auth()->user()->name == "Administrador"){
        //     $almacen=$request->get('almacen');
        // }else{
        //     $almacen=Almacen::where('id',auth()->user()->almacen_id)->first();
        // }
        

        $cotizacion=new Cotizacion;
        $cotizacion->cod_cotizacion=$cotizacion_numero;
        $cotizacion->almacen_id=$request->get('almacen');
        $cotizacion->cliente_id=$cliente_buscador->id;
        $cotizacion->moneda_id=$id_moneda;
        $cotizacion->forma_pago_id=$request->get('forma_pago');
        $cotizacion->estado_aprovar='0';
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

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores del check descuento
        $check = $request->input('check_descuento');
        $count_check=count($check);

        // $igv_proceso=Igv::first();
        // $igv_total=$igv_proceso->igv_total;

        $igv=Igv::first();

        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$cotizacion->moneda_id;


        if($count_articulo = $count_cantidad  = $count_check){
            for($i=0;$i<$count_articulo;$i++){
                $cotizacion_registro=new Cotizacion_boleta_registro;
                $cotizacion_registro->cotizacion_id=$cotizacion->id;
                $cotizacion_registro->producto_id=$producto_id[$i];
                $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
                //stock --------------------------------------------------------
                $stock=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->sum('cantidad');
                $cotizacion_registro->stock=$stock;
                
                //precio --------------------------------------------------------
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional'){
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional');
                        $cotizacion_registro->promedio_original=$array2;

                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad)*($igv->igv_total/100);
                        $array=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad+$igv_p);
                        $cotizacion_registro->precio=$array;
                    }else{
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero');
                        $cotizacion_registro->promedio_original=$array2;

                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad)*($igv->igv_total/100);
                        $array=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad+$igv_p);
                        $cotizacion_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera'){
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero');
                        $cotizacion_registro->promedio_original=$array2;

                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad)*($igv->igv_total/100);
                        $array=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_extranjero')+$utilidad+$igv_p);
                        $cotizacion_registro->precio=$array*$cambio->paralelo;
                    }else{
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional');
                        $cotizacion_registro->promedio_original=$array2;

                        $utilidad=kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad)*($igv->igv_total/100);
                        $array=((kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('estado',1)->avg('precio_nacional')+$utilidad)+$igv_p);
                        $cotizacion_registro->precio=$array/$cambio->paralelo;
                    }
                }
                $cotizacion_registro->cantidad=$request->get('cantidad')[$i];
                $cotizacion_registro->descuento=$request->get('check_descuento')[$i];
                $cotizacion_registro->comision=$comi;
                //precio unitario descuento ----------------------------------------
                $desc_comprobacion=$request->get('check_descuento')[$i];
                if($desc_comprobacion <> 0){
                    $cotizacion_registro->precio_unitario_desc=$array-($array*$desc_comprobacion/100);
                }else{
                    $cotizacion_registro->precio_unitario_desc=$array;
                }
                //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                    $cotizacion_registro->precio_unitario_comi=($array-($array*$desc_comprobacion/100))+($array*$comi/100);
                }else{
                    $cotizacion_registro->precio_unitario_comi=$array+($array*$comi/100);
                }
                $cotizacion_registro->save();
            }
        }else {
            return redirect()->route('cotizacion.create_boleta')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('cotizacion.show',$cotizacion->id);

    }

    public function show($id)
    {
        $facturacion=Facturacion::where('id_cotizador',$id)->first();
        $boleta=Boleta::where('id_cotizador',$id)->first();
        $banco=Banco::where('estado','0')->get();
        $moneda=Moneda::where('principal',1)->first();
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
        $cotizacion_registro2=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
        foreach ($cotizacion_registro as $cotizacion_registros) {
           $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
       }

        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
       $cotizacion=Cotizacion::find($id);
       $empresa=Empresa::first();
       $sum=0;
       $igv=Igv::first();
       $sub_total=0;

       $regla=$cotizacion->tipo;

       return view('transaccion.venta.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','sum','igv',"array","sub_total","moneda","regla",'banco','facturacion','boleta'));
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

    // public function fast_print(Request $request){
    //     $atencion=$request->get('atencion');
    //     return view('transaccion.venta.cotizacion.fast_print',compact('atencion'));
    // }

    public function print($id){
        $banco=Banco::where('estado','0')->get();
        $moneda=Moneda::where('principal',1)->first();
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
        $cotizacion_registro2=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
        foreach ($cotizacion_registro as $cotizacion_registros) {
           $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
       }

       $cotizacion=Cotizacion::find($id);
       $empresa=Empresa::first();
       $sum=0;
       $igv=Igv::first();
       $sub_total=0;

       $regla=$cotizacion->tipo;

       return view('transaccion.venta.cotizacion.print' ,compact('cotizacion','empresa','cotizacion_registro','cotizacion_registro2','regla','sum','igv',"array","sub_total","moneda",'banco'));
   }

//envio hacia facturar cambiar en caso ingluya algo
   public function facturar($id){
    $moneda=Moneda::where('principal',1)->first();
    $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();

    foreach ($cotizacion_registro as $cotizacion_registros) {
       $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
   }

   $cotizacion=Cotizacion::find($id);
   /*Fecha vencimiento*/
         // $cotizacion_dias_pago= $cotizacion->forma_pago->dias;
         // $fecha =date("d-m-Y");
         // $nuevafecha = strtotime ( '+'.$cotizacion_dias_pago.' day' , strtotime ( $fecha ) ) ;
         // $nuevafechas = date("d-m-Y", $nuevafecha );

   $empresa=Empresa::first();
   $sum=0;
   $igv=Igv::first();
   $sub_total=0;

   $fac= Facturacion::all()->count();
   $suma=$fac+1;
   $cod_fac='FC-000'.$suma;

   return view('transaccion.venta.cotizacion.facturar', compact('cotizacion','empresa','cotizacion_registro','sum','igv',"array","sub_total","moneda",'cod_fac'));
}


public function facturar_store(Request $request)
{

    // cambio de Estado Cotizador
    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion::where('id',$id_cotizador)->first();
    $cotizacion->estado=1;
    $cotizacion->save();
    $fac= Facturacion::all()->count();
    $suma=$fac+1;
    $cod_fac='FC-000'.$suma;


            // Creacion de Facturacion
    $facturar=new Facturacion;
    $facturar->codigo_fac=$cod_fac;
    $facturar->id_cotizador=$request->get('id_cotizador');
    $facturar->orden_compra=$request->get('orden_compra');
    $facturar->guia_remision=$request->get('guia_remision');
    $facturar->fecha_emision=$request->get('fecha_emision');
    $facturar->fecha_vencimiento=$request->get('fecha_vencimiento');
    $facturar->estado='0';
    $facturar->tipo='producto';
    $facturar->user_id =auth()->user()->id;
    $facturar->save();

    $buscador_id=Cotizacion::where('id',$facturar->id_cotizador)->first();

    $cotizaciones_facturaciones=Cotizacion_factura_registro::where('cotizacion_id',$buscador_id->id)->get();

    foreach ($cotizaciones_facturaciones as $index => $cotizacion_facturacion) {
        $facturacion_registro=new Facturacion_registro;
        $facturacion_registro->facturacion_id=$facturar->id;
        $facturacion_registro->numero_serie=$request->get('numero_serie')[$index];
        $facturacion_registro->producto_id=$cotizacion_facturacion->producto_id;
        $facturacion_registro->stock=$cotizacion_facturacion->stock;
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
    $comisionista=Cotizacion::where('id',$cotizador)->first();
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
   return redirect()->route('cotizacion.show',$id_cotizador);
}

public function boletear($id)

{
    $moneda=Moneda::where('principal',1)->first();
    $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    foreach ($cotizacion_registro as $cotizacion_registros) {
       $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
   }

   $cotizacion=Cotizacion::find($id);
   /*Fecha vencimiento*/
         // $cotizacion_dias_pago= $cotizacion->forma_pago->dias;
         // $fecha =date("d-m-Y");
         // $nuevafecha = strtotime ( '+'.$cotizacion_dias_pago.' day' , strtotime ( $fecha ) ) ;
         // $nuevafechas = date("d-m-Y", $nuevafecha );

   $empresa=Empresa::first();
   $sum=0;
   $igv=Igv::first();
   $sub_total=0;


   $boleta_contador= Boleta::all()->count();
   $banco= Banco::all();
   $suma=$boleta_contador+1;
   $boleta_codigo='BO-0000'.$suma;

   return view('transaccion.venta.cotizacion.boletear', compact('cotizacion','empresa','cotizacion_registro','sum','igv',"array","sub_total",'moneda' ,'boleta_codigo','banco'));
}

public function boletear_store(Request $request)
{


            // cambio de Estado Cotizador
    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion::where('id',$id_cotizador)->first();
    $cotizacion->estado=1;
    $cotizacion->save();

    $boleta_contador= Boleta::all()->count();
    $suma=$boleta_contador+1;
    $boleta_codigo='BO-0000'.$suma;

            // Creacion de Facturacion
    $boletear=new Boleta;
    $boletear->codigo_boleta=$boleta_codigo;
    // $boletear->codigo_fac=$request->get('codigo_bol');
    $boletear->id_cotizador=$request->get('id_cotizador');
    $boletear->orden_compra=$request->get('orden_compra');
    $boletear->guia_remision=$request->get('guia_remision');
    $boletear->fecha_emision=$request->get('fecha_emision');
    $boletear->fecha_vencimiento=$request->get('fecha_vencimiento');
    $boletear->estado='0';
    $boletear->user_id =auth()->user()->id;
    $boletear->tipo='producto';
    $boletear->save();

    $buscador_id=Cotizacion::where('id',$boletear->id_cotizador)->first();

    $cotizaciones_boletaciones=Cotizacion_boleta_registro::where('cotizacion_id',$buscador_id->id)->get();

    foreach ($cotizaciones_boletaciones as $index => $cotizacion_boleta) {
        $boleta_registro=new Boleta_registro;
        $boleta_registro->boleta_id=$boletear->id;
        $boleta_registro->numero_serie=$request->get('numero_serie')[$index];
        $boleta_registro->producto_id=$cotizacion_boleta->producto_id;
        $boleta_registro->stock=$cotizacion_boleta->stock;
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
    $comisionista=Cotizacion::where('id',$cotizador)->first();
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


   return redirect()->route('cotizacion.show',$id_cotizador);


}

public function aprobar(Request $request, $id)
{

    $cotizacion=Cotizacion::find($id);
        // $usuario=$cotizacion->user_id;

    $cotizacion->estado_aprovar='1';
    if (!isset($cotizacion->aprobado_por)) {
     $cotizacion->aprobado_por=auth()->user()->id;
 }

 $cotizacion->save();

 return redirect()->route('cotizacion.index');
        // return redirect()->route('productos.index');

}


}