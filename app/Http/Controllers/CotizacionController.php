<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Banco;
use App\Boleta;
use App\Boleta_registro;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_Servicios;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use Illuminate\Support\Facades\Storage;
use App\Facturacion;
use App\Facturacion_registro;
use App\Forma_pago;
use App\Igv;
use App\Kardex_entrada;
use App\Marcas;
use App\Moneda;
use App\Personal;
use App\Personal_venta;
use App\Producto;
use App\TipoCambio;
use App\Unidad_medida;
use App\User;
use App\Ventas_registro;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
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

    public function descripcion_ajax(Request $request){
        $articulo=$request->get('articulo');
        $id=explode(" ",$articulo);
        $producto=Producto::where('id',$id[0])->first();
        $descripcion= $producto->descripcion;
        return $descripcion;
    }

    public function create_factura(Request $request)
    {

   // $kardex_prod=kardex_entrada_registro::join("productos","kardex_entrada_registro.producto_id","productos.id")
        // ->where('estado',1)->get();

        $almacen_p=$request->get('almacen');
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

        //return $kardex_entrada;
        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
            return "no hay prodcutos en el almacen seleccionado";
        }

        // return $nueva;
        $lista=array_values(array_unique($prod));
        $lista_count=count($lista);
        // return $lista_count;

        for($x=0;$x<$lista_count;$x++){
            $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
        }
        /**/
        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        // return $kardex_prod;

         //aplicamiento de logica para llamar un producto hacia kardex
        $moneda=Moneda::where('principal','1')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        if ($moneda->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                // return $index;
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

        // return $productos;

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
        $almacen_p=$request->get('almacen');
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
            return "no hay prodcutos en el almacen seleccionado";
        }

        $lista=array_values(array_unique($prod));
        $lista_count=count($lista);

        for($x=0;$x<$lista_count;$x++){
            $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
        }

        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
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
                        return redirect()->route('cotizacion.index')->with('repite', 'Datos repetidos - No permitidos!');
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

        if(!$cliente_buscador){
            return 'NO hay';
        }

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
        //}//calculo para el stock del producto
        $almacen_producto_validacion=$request->get('almacen');
        for($i=0;$i<$count_articulo;$i++){
            $kardex_entrada_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->get();
            $kardex_entrada_count_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->count();

            //return $kardex_entrada;
            foreach($kardex_entrada_v as $kardex_entradas_v){
                $kadex_entrada_id_v[]=$kardex_entradas_v->id;
            }
            // return $kardex_entrada;
            for($x=0;$x<$kardex_entrada_count_v;$x++){
                if(Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first()){
                    $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first();
                }
            }
            $comparacion_v=$nueva_v;
            //buble para la cantidad
            $cantidad_v=0;
            foreach($comparacion_v as $comparaciones_v){
                $cantidad_v=$comparaciones_v->cantidad+$cantidad_v;
            }
            $cantidad_entrada=$request->get('cantidad')[$i];
            if($cantidad_v<$cantidad_entrada){
             return "cantidad mayor al stock";
         }

     }


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
            $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->first();
                // $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
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
        $almacen_p=$request->get('almacen');
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
            return "no hay prodcutos en el almacen seleccionado";
        }

        $lista=array_values(array_unique($prod));
        $lista_count=count($lista);

        for($x=0;$x<$lista_count;$x++){
            $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
        }


        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

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
        $clientes=Cliente::where('documento_identificacion','dni')->get();
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

        return view('transaccion.venta.cotizacion.boleta.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','cotizacion_numero','sucursal'));
        // 'boleta_codigo',
        //return view('transaccion.venta.cotizacion.boleta.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio'));
    }

    //agregamiento de una nueva funcion create_boleta a monde secundaria comnetado
    public function create_boleta_ms(Request $request)
    {
        $almacen_p=$request->get('almacen');
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get();
                foreach( $nueva as $nuevas){
                    $prod[]=$nuevas->producto_id;
                }
            }
        }
        //validacion si hay prductos en el almacen
        if(!isset($prod)){
            return "no hay prodcutos en el almacen seleccionado";
        }

        $lista=array_values(array_unique($prod));
        $lista_count=count($lista);

        for($x=0;$x<$lista_count;$x++){
            $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
        }
        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
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
        $clientes=Cliente::where('documento_identificacion','dni')->get();

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
                        return redirect()->route('cotizacion.index')->with('repite', 'Datos repetidos - No permitidos!');
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

        if(!$cliente_buscador){
           return 'NO hay';
        }


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

        $almacen_producto_validacion=$request->get('almacen');
        for($i=0;$i<$count_articulo;$i++){
            $kardex_entrada_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->get();
            $kardex_entrada_count_v=Kardex_entrada::where('almacen_id',$almacen_producto_validacion)->count();

            //return $kardex_entrada;
            foreach($kardex_entrada_v as $kardex_entradas_v){
                $kadex_entrada_id_v[]=$kardex_entradas_v->id;
            }
            // return $kardex_entrada;
            for($x=0;$x<$kardex_entrada_count_v;$x++){
                if(Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first()){
                    $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first();
                }
            }
            $comparacion_v=$nueva_v;
            //buble para la cantidad
            $cantidad_v=0;
            foreach($comparacion_v as $comparaciones_v){
                $cantidad_v=$comparaciones_v->cantidad+$cantidad_v;
            }
            $cantidad_entrada=$request->get('cantidad')[$i];
            if($cantidad_v<$cantidad_entrada){
             return "cantidad mayor al stock";
         }

     }


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
            $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->first();
                // $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
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
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    $factura= Facturacion::where('id_cotizador',$id)->first();
    $boleta=Boleta::where('id_cotizador',$id)->first();
    /*registros boleta y factura*/
    if ($regla=='factura') {
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif ($regla=='boleta') {
        $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/

    /*de numeros a Letras*/
    foreach ($cotizacion_registro as $cotizacion_registros) {
        $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
        $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
        if ($regla=='factura') {$end=round($sub_total, 2)+round($igv_p, 2);} elseif ($regla=='boleta') {$end=round($sub_total, 2);}
    }
    /* Finde numeros a Letras*/
    $firma= EmailConfiguraciones::where('id_usuario',$cotizacion->user_id)->pluck('firma_digital')->first();
        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
    $empresa=Empresa::first();
    $sum=0;
    $i=1;

        //para mandar una nueva cotizacion en la vista .show como un boton
    $almacen=auth()->user()->almacen_id;
    $nueva_cot='cotizacion.create_'.$regla;

    return view('transaccion.venta.cotizacion.show', compact('cotizacion','empresa','cotizacion_registro','sum','igv',"sub_total","regla",'banco','end','igv_p','almacen','nueva_cot','banco_count','i','boleta','factura','firma'));
    // return $firma;
}

public function print($id){
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();

    /*registros boleta y factura*/
    if($regla=='factura'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif($regla=='boleta'){
        $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/
    /*de numeros a Letras*/

    foreach($cotizacion_registro as $cotizacion_registros){
        $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
        $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
        if ($regla=='factura') {$end=round($sub_total, 2)+round($igv_p, 2);} elseif ($regla=='boleta') {$end=round($sub_total, 2);}
    }

    /* Finde numeros a Letras*/
    $empresa=Empresa::first();
    $sum=0;
    $i=1;

    return view('transaccion.venta.cotizacion.print', compact('cotizacion','empresa','cotizacion_registro','sum','igv',"sub_total","regla",'banco','i','end','igv_p','banco_count'));
}
public function pdf(Request $request,$id){
    $name = $request->get('name');
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    /*registros boleta y factura*/
    if($regla=='factura'){
      $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
  }elseif($regla=='boleta'){
      $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
  }
  /* FIN registros boleta y factura*/
  /*de numeros a Letras*/
  foreach($cotizacion_registro as $cotizacion_registros){
      $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
      $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
      if ($regla=='factura') {$end=round($sub_total, 2)+round($igv_p, 2);} elseif ($regla=='boleta') {$end=round($sub_total, 2);}
  }
  /* Finde numeros a Letras*/
  $empresa=Empresa::first();
  $sum=0;
  $i=1;
  $regla=$cotizacion->tipo;
  $archivo=$name.$regla.$id.".pdf";
  $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count'));
  return $pdf->download('Cotizacion - '.$archivo.'.pdf');
}
    //envio hacia facturar cambiar en caso incluya algo
public function facturar(Request $request,$id){

    $cotizacion=Cotizacion::where('id',$id)->first();
    $cotizacion_moneda=$cotizacion->moneda_id;

    $tipo_cambio=TipoCambio::latest('created_at')->first();
    $moneda1=Moneda::where('principal',1)->first();
    $moneda2=Moneda::where('principal',0)->first();

    $productos=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    foreach($productos as $lista){
        $produc[]=Producto::where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
            // $produc[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
    }
        // $produc=Producto::where('producto_id',$id)->get();
        // return $produc;

    if($cotizacion_moneda==$moneda1->id){

        if ($moneda1->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }
    }elseif($cotizacion_moneda==$moneda2->id){
        if ($moneda2->tipo == 'extranjera'){
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
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

    $cotizacion=Cotizacion::find($id);

    $empresa=Empresa::first();
    $sum=0;
    $igv=Igv::first();
    $sub_total=0;

    $almacen=$request->get('almacen');

    //obtencion del almacen
    $sucursal=Almacen::where('codigo_sunat', $almacen)->first();

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

    // $cod_fac='- - -';

    return view('transaccion.venta.cotizacion.facturar', compact('cotizacion','empresa','sum','igv',"array","sub_total","moneda",'cod_fac','productos','array_cantidad','validor'));
}


public function facturar_store(Request $request)
{
    $date_sp = Carbon::now();
        $data_g = str_replace(' ', '_',$date_sp);
        $carbon_sp = str_replace(':','-',$data_g);
        $id = $request->get('id');
            //buscador al cambio
    $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
    if(!$cambio){
        return "error por no hacer el cambio diario";
    }
    $tipo_cambio=TipoCambio::latest('created_at')->first();
    // return $request;
    // cambio de Estado Cotizador
    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion::where('id',$id_cotizador)->first();
    $cotizacion->estado=1;
    $cotizacion->save();

    //CODIGO DE LA FACTURA
    $almacen=$cotizacion->almacen_id;
       //obtencion del almacen
    $sucursal=Almacen::where('codigo_sunat', $almacen)->first();

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

     $factura_numero="F".$sucursal_nr."-".$factura_nr;

           // Comisionista convertir id

     $comisionista=$cotizacion->comisionista_id;
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

        // Creacion de Facturacion
     $facturar=new Facturacion;
     $facturar->codigo_fac=$factura_numero;
     $facturar->almacen_id=$cotizacion->almacen_id;
     $facturar->id_cotizador=$request->get('id_cotizador');
     $facturar->orden_compra=$request->get('orden_compra');
     $facturar->guia_remision=$request->get('guia_remision');
     $facturar->cliente_id=$cotizacion->cliente_id;
     $facturar->moneda_id=$cotizacion->moneda_id;
     $facturar->forma_pago_id=$cotizacion->forma_pago_id;
     $facturar->fecha_emision=$request->get('fecha_emision');
     $facturar->fecha_vencimiento=$request->get('fecha_vencimiento');
     $facturar->cambio=$cambio->paralelo;
     $facturar->observacion=$cotizacion->observacion;
     $facturar->comisionista=$cotizacion->comisionista_id;
     $facturar->user_id =auth()->user()->id;
     $facturar->estado='0';
     $facturar->tipo='producto';
     $facturar->save();

        // modificacion para que se cierre el codigo en almacen
        // obtencion de la sucursal
     $sucursal=auth()->user()->almacen->codigo_sunat;
        //obtencion del almacen
     $factura_primera=Almacen::where('codigo_sunat', $sucursal)->first();
     $factura_primera->cod_fac='NN';
     $factura_primera->save();

     $buscador_id=Cotizacion::where('id',$facturar->id_cotizador)->first();

        // $cotizaciones_facturaciones=Cotizacion_factura_registro::where('cotizacion_id',$buscador_id->id)->get();
     $productos=Cotizacion_factura_registro::where('cotizacion_id',$buscador_id->id)->get();
     foreach($productos as $lista){
        $produc[]=Producto::where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
                // $produc[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
    }

        //validacion dependiendo de la amoneda escogida
    $moneda=Moneda::where('principal',1)->first();
    $moneda_registrada=$facturar->moneda_id;

    $moneda1=Moneda::where('principal',1)->first();
    $moneda2=Moneda::where('principal',0)->first();

    if($facturar->moneda_id==$moneda1->id){

        if ($moneda1->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }
    }elseif($facturar->moneda_id==$moneda2->id){
        if ($moneda2->tipo == 'extranjera'){
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }
    }

    foreach ($productos as $index => $cotizacion_facturacion) {
        if($validor[$index]=1){
            $facturacion_registro=new Facturacion_registro;
            $facturacion_registro->facturacion_id=$facturar->id;
            $facturacion_registro->producto_id=$p[$index];
            $facturacion_registro->numero_serie=$request->get('numero_serie')[$index];

            $producto=Producto::where('id',$p[$index])->where('estado_id',1)->first();
                // $producto=Producto::where('id',$p[$index])->where('estado_id',1)->where('estado_anular',1)->first();
                    //stock --------------------------------------------------------
            $stock=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->sum('cantidad');
            $facturacion_registro->stock=$stock;
                //precio --------------------------------------------------------
            if($moneda->id == $moneda_registrada){
                if ($moneda->tipo == 'nacional') {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional');
                    $facturacion_registro->promedio_original=$array2;
                        // respectividad de la moneda deacurdo al id
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $array=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')+$utilidad;
                    $facturacion_registro->precio=$array;
                }else {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero');
                    $facturacion_registro->promedio_original=$array2;
                        // validacion para la otra moneda con igv paralelo
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')+$utilidad;
                    $facturacion_registro->precio=$array;
                }
            }else{
                if ($moneda->tipo == 'extranjera') {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero');
                    $facturacion_registro->promedio_original=$array2;
                        // respectividad de la moneda deacuerdo al id
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $array=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')+$utilidad)*$cambio->paralelo;
                    $facturacion_registro->precio=$array;
                }else{
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional');
                    $facturacion_registro->promedio_original=$array2;
                        // validacion para la otra moneda con igv paralelo
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $array=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')+$utilidad)/$cambio->paralelo;
                    $facturacion_registro->precio=$array;
                }
            }
            $facturacion_registro->cantidad=$cotizacion_facturacion->cantidad;
            $facturacion_registro->descuento=$cotizacion_facturacion->descuento;
            $facturacion_registro->comision=$cotizacion_facturacion->comision;
                //precio unitario descuento ----------------------------------------
            $desc_comprobacion=$cotizacion_facturacion->descuento;

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
     $validacion = $request->get('validacion');
    if($validacion==1){
        //pdf request
    $name = $request->get('name');
    $banco=Banco::where('estado','0')->get();
    $banco_count=Banco::where('estado','0')->count();
    $cotizacion=Cotizacion::find($id);
    $regla=$cotizacion->tipo;
    $sub_total=0;
    $igv=Igv::first();
    /*registros boleta y factura*/
    if($regla=='factura'){
        $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
    }elseif($regla=='boleta'){
        $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    }
    /* FIN registros boleta y factura*/
    /*de numeros a Letras*/
    foreach($cotizacion_registro as $cotizacion_registros){
        $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
        $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
        if ($regla=='factura') {$end=round($sub_total, 2)+round($igv_p, 2);} elseif ($regla=='boleta') {$end=round($sub_total, 2);}
    }
    /* Finde numeros a Letras*/
    $empresa=Empresa::first();
    $sum=0;
    $i=1;
    $regla=$cotizacion->tipo;

    $archivo=$name.'_'.$id.".pdf";
    $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count'));
    $content = $pdf->download();
    //pdf fin
    $especif = $carbon_sp.$archivo;
    Storage::disk('mailbox')->put($especif,$content);
    $date = $carbon_sp;

    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    $firma=$correo_busqueda->firma;
    $mensaje_html = $request->get('mensaje');
    if($firma == null){
      $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
     .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
      table{
        width:100%;
      }
      </style>'.$mensaje_html.'</body>';
    }else{
      $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
      .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
      table{
        width:100%;
      }
      </style>'.$mensaje_html.'</body><br/><footer><img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="550px" height="auto" /></footer>';
    }
    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL
    $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
    $port = $correo_busqueda->port;
    $encryption = $correo_busqueda->encryption;
    $yourEmail = $correo;
    $estado = '0';
    //$mailbackup =  ; // = $request->yourmail
    $yourPassword = $correo_busqueda->password;
    $sendto = $request->get('remitente') ;
    $titulo = "Envio de Factura Automatico";
    $mensaje = $mensaje_con_firma;
    $bakcup=    $correo_busqueda->email_backup ;

    // $file = $request->archivo;
    $pdf=$archivo;
    // $carpet =$request->get('redict');
    $pdfile = public_path().'/archivos/'.$especif;

    $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
    $mailer =new \Swift_Mailer($transport);

    $newfile = $request->file('archivos');
    if($request->hasfile('archivos')){
        foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            $especif = $carbon_sp.$nombre;
            \Storage::disk('mailbox')->put( $especif ,  \File::get($file));

            $news[] = public_path().'/archivos/'.$especif;
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
            $message->attach(\Swift_Attachment::fromPath($pdfile));
            foreach ($news as $attachment) {
                $message->attach(\Swift_Attachment::fromPath($attachment));
            }
        }
    }else{
        $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');
        $message->attach(\Swift_Attachment::fromPath($pdfile));
    }
    if($mailer->send($message)){
        $mensaje =$request->get('mensaje') ;
        $texto= strip_tags($mensaje);
        $mail = new EmailBandejaEnvios;
        $mail->id_usuario =auth()->user()->id;
        $mail->destinatario =$correo;
        $mail->remitente =$request->get('remitente') ;
        $mail->asunto =$titulo;
        $mail->mensaje =$mensaje_con_firma;
        $mail->mensaje_sin_html =$texto ;
        $mail->estado= $estado;
        $mail->fecha_hora =Carbon::now() ;
        $mail-> save();
        $newfile2 = $request->file('archivos');
        if($request->hasfile('archivos')){
            foreach ($newfile2 as $file2) {
                $guardar_email_archivo=new EmailBandejaEnviosArchivos;
                $guardar_email_archivo->id_bandeja_envios=$mail->id;
                $guardar_email_archivo->archivo= $file2->getClientOriginalName();
                $guardar_email_archivo->fecha_hora= $carbon_sp;
                $guardar_email_archivo->save();
            }
        }
        $archivo_pdf = new EmailBandejaEnviosArchivos;
        $archivo_pdf->id_bandeja_envios=$mail->id;
        $archivo_pdf->archivo=$pdf;
        $archivo_pdf->fecha_hora= $especif;
        $archivo_pdf->save();
        return redirect()->route('facturacion.show',$facturar->id);
    }else{
        return "Something went wrong :(";
    }
    }else{
        return redirect()->route('facturacion.show',$facturar->id);
    }
}

public function boletear(Request $request,$id)
{
    $cotizacion=Cotizacion::where('id',$id)->first();
    $cotizacion_moneda=$cotizacion->moneda_id;

    $tipo_cambio=TipoCambio::latest('created_at')->first();
    $moneda1=Moneda::where('principal',1)->first();
    $moneda2=Moneda::where('principal',0)->first();

    $productos=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
    foreach($productos as $lista){
        $produc[]=Producto::where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
        // $produc[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
    }

    $igv=Igv::where('id','1')->first();

    if($cotizacion_moneda==$moneda1->id){

        if ($moneda1->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index]+$igv_p[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index]+$igv_p[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }
    }elseif($cotizacion_moneda==$moneda2->id){
        if ($moneda2->tipo == 'extranjera'){
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index]+$igv_p[$index])/$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index]+$igv_p[$index])*$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }
    }

    $empresa=Empresa::first();
    $sum=0;
    $igv=Igv::first();
    $sub_total=0;
       $almacen=$request->get('almacen');

    //obtencion del almacen
    $sucursal=Almacen::where('codigo_sunat', $almacen)->first();

    $factura_cod_bol=$sucursal->cod_bol;
    if (is_numeric($factura_cod_bol)) {
        // exprecion del numero de fatura
        $factura_cod_bol++;
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($factura_cod_bol, 8, "0", STR_PAD_LEFT);
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

    $cod_bol="F".$sucursal_nr."-".$boleta_nr;

    return view('transaccion.venta.cotizacion.boletear', compact('cotizacion','empresa','productos','sum','igv',"array","sub_total",'moneda' ,'cod_bol','validor','array_cantidad'));
}

public function boletear_store(Request $request)
{
    $date_sp = Carbon::now();
    $data_g = str_replace(' ', '_',$date_sp);
    $carbon_sp = str_replace(':','-',$data_g);
    $id = $request->get('id');
          //buscador al cambio
    $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
    if(!$cambio){
        return "error por no hacer el cambio diario";
    }
    $tipo_cambio=TipoCambio::latest('created_at')->first();
    // cambio de Estado Cotizador
    $id_cotizador=$request->get('id_cotizador');
    $cotizacion=Cotizacion::where('id',$id_cotizador)->first();
    $cotizacion->estado=1;
    $cotizacion->save();

    // obtencion de la sucursal
    $almacen=$cotizacion->almacen_id;
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
        $ultima_factura=Boleta::latest()->first();
        $boleta_num=$ultima_factura->codigo_boleta;
        $boleta_num_string_porcion= explode("-", $boleta_num);
        $boleta_num_string=$boleta_num_string_porcion[1];
        $boleta_num=(int)$boleta_num_string;
        $boleta_num++;
        $sucursal_nr = str_pad($sucursal->id, 3, "0", STR_PAD_LEFT);
        $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
    }
    $boleta_numero="B".$sucursal_nr."-".$boleta_nr;

    // Comisionista convertir id

    $comisionista=$cotizacion->comisionista_id;
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

    // Creacion de Boleta
    $boletear=new Boleta;
    $boletear->codigo_boleta=$boleta_numero;
    $boletear->almacen_id=$cotizacion->almacen_id;
    $boletear->orden_compra=$request->get('orden_compra');
    $boletear->guia_remision=$request->get('guia_remision');
    $boletear->id_cotizador=$request->get('id_cotizador');
    $boletear->cliente_id=$cotizacion->cliente_id;
    $boletear->moneda_id=$cotizacion->moneda_id;
    $boletear->forma_pago_id=$cotizacion->forma_pago_id;
    $boletear->fecha_emision=$request->get('fecha_emision');
    $boletear->fecha_vencimiento=$request->get('fecha_vencimiento');
    $boletear->cambio=$cambio->paralelo;
    $boletear->observacion=$cotizacion->observacion;
    $boletear->comisionista=$cotizacion->comisionista_id;
    $boletear->user_id =auth()->user()->id;
    $boletear->estado='0';
    $boletear->tipo='producto';
    $boletear->save();

    // modificacion para que se cierre el codigo en almacen
    // obtencion de la sucursal
    $sucursal=auth()->user()->almacen->codigo_sunat;
    //obtencion del almacen
    $factura_primera=Almacen::where('codigo_sunat', $sucursal)->first();
    $factura_primera->cod_bol='NN';
    $factura_primera->save();

    $buscador_id=Cotizacion::where('id',$boletear->id_cotizador)->first();

    $productos=Cotizacion_boleta_registro::where('cotizacion_id',$buscador_id->id)->get();
    foreach($productos as $lista){
        $produc[]=Producto::where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
            // $produc[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista->producto_id)->first();
    }

    //validacion dependiendo de la amoneda escogida
    $moneda=Moneda::where('principal',1)->first();
    $moneda_registrada=$boletear->moneda_id;

    $moneda1=Moneda::where('principal',1)->first();
    $moneda2=Moneda::where('principal',0)->first();

    $igv=Igv::first();

    if($boletear->moneda_id==$moneda1->id){
        if ($moneda1->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index]+$igv_p[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index]+$igv_p[$index];
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }
    }elseif($boletear->moneda_id==$moneda2->id){
        if ($moneda2->tipo == 'extranjera'){
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index]+$igv_p[$index])/$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_nacional');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }else{
            foreach ($productos as $index => $producto) {
                $p[]=$producto->producto_id;
                $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')*($produc[$index]->utilidad-$producto->descuento1)/100;
                $igv_p[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index])*($igv->igv_total/100);
                $array[]=(kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero')+$utilidad[$index]+$igv_p[$index])*$tipo_cambio->paralelo;
                $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->sum('cantidad');
                $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->producto_id)->where('estado',1)->avg('precio_extranjero');
                if($array_cantidad[$index]>=$producto->producto_id){
                    $validor[]=1;
                }else{
                    $validor[]=0;
                }
            }
        }
    }




    // $cotizaciones_boletaciones=Cotizacion_boleta_registro::where('cotizacion_id',$buscador_id->id)->get();

    foreach ($productos as $index => $cotizacion_boleta) {
        if($validor[$index]=1){
            $boleta_registro=new Boleta_registro;
            $boleta_registro->boleta_id=$boletear->id;
            $boleta_registro->producto_id=$p[$index];
            $boleta_registro->numero_serie=$request->get('numero_serie')[$index];

            $producto=Producto::where('id',$p[$index])->where('estado_id',1)->first();
            // $producto=Producto::where('id',$p[$index])->where('estado_id',1)->where('estado_anular',1)->first();
                //stock --------------------------------------------------------
            $stock=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->sum('cantidad');
            $boleta_registro->stock=$stock;
            //precio --------------------------------------------------------
            if($moneda->id == $moneda_registrada){
                if ($moneda->tipo == 'nacional') {
                    //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional');
                    $boleta_registro->promedio_original=$array2;
                    // respectividad de la moneda deacurdo al id
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')+$utilidad)*($igv->igv_total/100);
                    $array=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')+$utilidad+$igv_p;
                    $boleta_registro->precio=$array;
                }else {
                    //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero');
                    $boleta_registro->promedio_original=$array2;
                    // validacion para la otra moneda con igv paralelo
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')+$utilidad)*($igv->igv_total/100);
                    $array=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')+$utilidad+$igv_p;
                    $boleta_registro->precio=$array;
                }
            }else{
                if ($moneda->tipo == 'extranjera') {
                    //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero');
                    $boleta_registro->promedio_original=$array2;
                    // respectividad de la moneda deacuerdo al id
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')+$utilidad)*($igv->igv_total/100);
                    $array=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_extranjero')+$utilidad+$igv_p)*$cambio->paralelo;
                    $boleta_registro->precio=$array;
                }else{
                    //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                    $array2=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional');
                    $boleta_registro->promedio_original=$array2;
                    // validacion para la otra moneda con igv paralelo
                    $utilidad=kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                    $igv_p=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')+$utilidad)*($igv->igv_total/100);
                    $array=(kardex_entrada_registro::where('producto_id',$p[$index])->where('estado',1)->avg('precio_nacional')+$utilidad+$igv_p)/$cambio->paralelo;
                    $boleta_registro->precio=$array;
                }
            }
            $boleta_registro->cantidad=$cotizacion_boleta->cantidad;
            $boleta_registro->descuento=$cotizacion_boleta->descuento;
            $boleta_registro->comision=$cotizacion_boleta->comision;

            //precio unitario descuento ----------------------------------------
            $desc_comprobacion=$cotizacion_boleta->descuento;

            if($desc_comprobacion <> 0){
                $boleta_registro->precio_unitario_desc=$array-($array*$desc_comprobacion/100);
            }else{
                $boleta_registro->precio_unitario_desc=$array;
            }
            //precio unitario comision ----------------------------------------
            if($desc_comprobacion <> 0){
                $boleta_registro->precio_unitario_comi=($array-($array*$desc_comprobacion/100))+($array*$comi/100);
            }else{
                $boleta_registro->precio_unitario_comi=$array+($array*$comi/100);
            }
            $boleta_registro->save();


        }

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
    $validacion = $request->get('validacion');
    if($validacion==1){
        $name = $request->get('name');
        $banco=Banco::where('estado','0')->get();
        $banco_count=Banco::where('estado','0')->count();
        $cotizacion=Cotizacion::find($id);
        $regla=$cotizacion->tipo;
        $sub_total=0;
        $igv=Igv::first();
        /*registros boleta y factura*/
        if($regla=='factura'){
          $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
          }elseif($regla=='boleta'){
              $cotizacion_registro=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
          }
          /* FIN registros boleta y factura*/
          /*de numeros a Letras*/
          foreach($cotizacion_registro as $cotizacion_registros){
              $sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total;
              $simbologia=$cotizacion->moneda->simbolo.$igv_p=round($sub_total, 2)*$igv->igv_total/100;
              if ($regla=='factura') {$end=round($sub_total, 2)+round($igv_p, 2);} elseif ($regla=='boleta') {$end=round($sub_total, 2);}
          }
          /* Finde numeros a Letras*/
          $empresa=Empresa::first();
          $sum=0;
          $i=1;
          $regla=$cotizacion->tipo;

            $archivo=$name.'_'.$id.".pdf";
            $pdf=PDF::loadView('transaccion.venta.cotizacion.pdf',compact('cotizacion','empresa','cotizacion_registro','regla','sum','igv','sub_total','banco','i','end','igv_p','banco_count'));
            $content = $pdf->download();
            $especif = $carbon_sp.$archivo;
            Storage::disk('mailbox')->put($especif,$content);
            $date = $carbon_sp;

            $id_usuario=auth()->user()->id;
            $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
            $correo=$correo_busqueda->email;

            $firma=$correo_busqueda->firma;
            $mensaje_html = $request->get('mensaje');
            if($firma == null){
              $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
              <script>
              $(document).ready(function(){
                  $("table").removeClass("table table-bordered").addClass("css");
              });
              </script>
              <style>
             .css,table,tr,td{
              padding: 15px;
              border: 1px solid black;
              border-collapse: collapse;
                }
              table{
                width:100%;
              }
              </style>'.$mensaje_html.'</body>';
            }else{
              $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
              <script>
              $(document).ready(function(){
                  $("table").removeClass("table table-bordered").addClass("css");
              });
              </script>
              <style>
              .css,table,tr,td{
              padding: 15px;
              border: 1px solid black;
              border-collapse: collapse;
                }
              table{
                width:100%;
              }
              </style>'.$mensaje_html.'</body><br/><footer><img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="550px" height="auto" /></footer>';
            }
            /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL
            $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
            $port = $correo_busqueda->port;
            $encryption = $correo_busqueda->encryption;
            $yourEmail = $correo;
            $estado = '0';
            //$mailbackup =  ; // = $request->yourmail
            $yourPassword = $correo_busqueda->password;
            $sendto = $request->get('remitente') ;
            $titulo = "Envio de Factura Automatico";
            $mensaje = $mensaje_con_firma;
            $bakcup=    $correo_busqueda->email_backup ;

            // $file = $request->archivo;
            $pdf=$archivo;
            // $carpet =$request->get('redict');
            $pdfile = public_path().'/archivos/'.$especif;

            $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
            $mailer =new \Swift_Mailer($transport);

            $newfile = $request->file('archivos');
            if($request->hasfile('archivos')){
              foreach ($newfile as $file) {
                $nombre =  $file->getClientOriginalName();
                $especif = $carbon_sp.$nombre;
                \Storage::disk('mailbox')->put( $especif ,  \File::get($file));

                $news[] = public_path().'/archivos/'.$especif;
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
                $message->attach(\Swift_Attachment::fromPath($pdfile));
                foreach ($news as $attachment) {
                  $message->attach(\Swift_Attachment::fromPath($attachment));
                }
              }
            }else{
              $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');
              $message->attach(\Swift_Attachment::fromPath($pdfile));
            }
            if($mailer->send($message)){
              $mensaje =$request->get('mensaje') ;
              $texto= strip_tags($mensaje);
              $mail = new EmailBandejaEnvios;
              $mail->id_usuario =auth()->user()->id;
              $mail->destinatario =$correo;
              $mail->remitente =$request->get('remitente') ;
              $mail->asunto =$titulo;
              $mail->mensaje =$mensaje_con_firma;
              $mail->mensaje_sin_html =$texto ;
              $mail->estado= $estado;
              $mail->fecha_hora =Carbon::now() ;
              $mail-> save();

              $newfile2 = $request->file('archivos');
              if($request->hasfile('archivos')){
                foreach ($newfile2 as $file2) {
                  $guardar_email_archivo=new EmailBandejaEnviosArchivos;
                  $guardar_email_archivo->id_bandeja_envios=$mail->id;
                  $guardar_email_archivo->archivo= $file2->getClientOriginalName();
                  $guardar_email_archivo->fecha_hora= $carbon_sp;
                  $guardar_email_archivo->save();
                }
              }
              $archivo_pdf = new EmailBandejaEnviosArchivos;
              $archivo_pdf->id_bandeja_envios=$mail->id;
              $archivo_pdf->archivo=$pdf;
              $archivo_pdf->fecha_hora= $especif;
              $archivo_pdf->save();
              // $id_cotizador=$request->get('id_cotizador');
              // $cotizacion=Cotizacion_Servicios::where('id',$id_cotizador)->first();
              // $cotizacion->estado=1;
              // $cotizacion->save();

             return redirect()->route('boleta.show',$boletear->id);
            }else{
                return "Something went wrong :(";
            }
    }else{
         return redirect()->route('boleta.show',$boletear->id);
    }
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


}


}