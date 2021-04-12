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
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use App\Stock_almacen;
use App\Stock_producto;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
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
        $user_login =auth()->user();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen=Almacen::where('estado',0)->get();
        $almacen_primero=Almacen::where('estado',0)->first();

        return view('transaccion.venta.facturacion.index', compact('facturacion','user_login','conteo_almacen','almacen','almacen_primero'));
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
    public function create(Request $request){

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
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->get();
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
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }

        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        // return $kardex_prod;

         //aplicamiento de logica para llamar un producto hacia kardex
         $moneda=Moneda::where('principal','1')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
         if ($moneda->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]),2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'),2);
            }
         }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]),2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'),2);
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
        // $empresa = Empresa::all();
        // obtencion de la sucursal
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

        return view('transaccion.venta.facturacion.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','factura_numero','sucursal','empresa'));
    }

    public function create_ms(Request $request){
        $almacen_p=$request->get('almacen');
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

        //return $kardex_entrada;
        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->get();
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
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }
        $moneda=Moneda::where('principal','0')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();

        if ($moneda->tipo == 'extranjera'){
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo,2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')/$tipo_cambio->paralelo,2);
            }
        }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo,2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*$tipo_cambio->paralelo,2);
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

        return view('transaccion.venta.facturacion.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','factura_numero','sucursal'));
    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id_moneda)
    {
        $facturacion_input=$request->get('facturacion');

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
                        return redirect()->route('facturacion.index')->with('repite', 'Asegurese que los productos no se deben repetir !');
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



        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        // CODIGO FACTURACION
        // obtencion de la sucursal
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

       //calculo para el stock del producto
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

        $facturacion=new facturacion;
        $facturacion->codigo_fac=$factura_numero;
        $facturacion->almacen_id =$request->get('almacen');
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
        // $sucursal=Almacen::where('id',$);
        //obtencion del almacen
        $factura_primera=Almacen::where('id', $sucursal->id)->first();
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

        if($count_articulo = $count_cantidad = $count_check){
            for($i=0;$i<$count_articulo;$i++){
                $facturacion_registro= new Facturacion_registro();
                $facturacion_registro->facturacion_id=$facturacion->id;
                $facturacion_registro->producto_id=$producto_id[$i];
                $facturacion_registro->numero_serie=$request->get('numero_serie')[$i];
                $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();
                //stock --------------------------------------------------------
                $stock=Stock_almacen::where('producto_id',$producto_id[$i])->where('almacen_id',$almacen)->sum('stock');
                $facturacion_registro->stock=$stock;

                //precio --------------------------------------------------------
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional') {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional');
                        $facturacion_registro->promedio_original=$array2;
                        // respectividad de la moneda deacurdo al id
                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad;
                        $facturacion_registro->precio=$array;
                    }else {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero');
                        $facturacion_registro->promedio_original=$array2;
                        // validacion para la otra moneda con igv paralelo
                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad;
                        $facturacion_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera') {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*$cambio->paralelo,2);
                        $facturacion_registro->promedio_original=$array2;
                        // respectividad de la moneda deacuerdo al id
                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round((Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad)*$cambio->paralelo,2);
                        $facturacion_registro->precio=$array;
                    }else{
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')/$cambio->paralelo,2);
                        $facturacion_registro->promedio_original=$array2;
                        // validacion para la otra moneda con igv paralelo
                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round((Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad)/$cambio->paralelo,2);
                        $facturacion_registro->precio=$array;
                    }
                }
                $facturacion_registro->cantidad=$request->get('cantidad')[$i];
                $facturacion_registro->descuento=$request->get('check_descuento')[$i];
                $facturacion_registro->comision=$comi;
                //precio unitario descuento ----------------------------------------
                $desc_comprobacion=$request->get('check_descuento')[$i];
                if($desc_comprobacion <> 0){
                    $facturacion_registro->precio_unitario_desc=$array-($array2*$desc_comprobacion/100);
                }else{
                    $facturacion_registro->precio_unitario_desc=$array;
                }
                //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                    $factura_desc = $array-($array2*$desc_comprobacion/100);
                    $facturacion_registro->precio_unitario_comi=$factura_desc+($factura_desc*$comi/100);
                }else{
                    $facturacion_registro->precio_unitario_comi=$array+($array*$comi/100);
                }
                $facturacion_registro->save();

                $almacen=$facturacion->almacen_id;
                $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen)->get();
                $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen)->count();

                //return $kardex_entrada;
                foreach($kardex_entrada as $kardex_entradas){
                    $kadex_entrada_id[]=$kardex_entradas->id;
                }
                // return $kardex_entrada;
                for($x=0;$x<$kardex_entrada_count;$x++){
                    if(Kardex_entrada_registro::where('producto_id',$facturacion_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->first()){
                        $nueva[]=Kardex_entrada_registro::where('producto_id',$facturacion_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->first();
                    }
                }
                // $kardex_e_r= Kardex_entrada_registro::first();
                // $kardex_entrada_reg =Kardex_entrada_registro::where('producto_id',1)->where('kardex_entrada_id',$kardex_e_r->kardex_entrada_reg_id->id)->first();
                // return $kardex_entrada_reg;
                // return $nueva;
                $comparacion=$nueva;
                //buble para la cantidad
                $cantidad=0;
                foreach($comparacion as $comparaciones){
                    $cantidad=$comparaciones->cantidad+$cantidad;
                }
                    if(isset($comparacion)){
                        $var_cantidad_entrada=$facturacion_registro->cantidad;
                        $contador=0;
                        foreach ($comparacion as $p) {
                            if($p->cantidad>$var_cantidad_entrada){
                                $cantidad_mayor=$p->cantidad;
                                $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                                $p->cantidad=$cantidad_final;
                                if($cantidad_final==0){
                                    $p->estado=0;
                                    $p->save();
                                    break;
                                }else{
                                    $p->save();
                                    break;
                                }
                            }elseif($p->cantidad==$var_cantidad_entrada){
                                $p->cantidad=0;
                                $p->estado=0;
                                $p->save();
                                break;
                            }
                            else{
                                $var_cantidad_entrada=$var_cantidad_entrada-$p->cantidad;
                                $p->cantidad=0;
                                $p->estado=0;
                                $p->save();
                            }
                        }
                    }
                    //Resta en la tabla stock almacen
                    Stock_almacen::egreso($facturacion->almacen_id,$producto_id[$i],$facturacion_registro->cantidad);
            }
        }else {
            return redirect()->route('facturacion.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('facturacion.show',$facturacion->id);
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

    public function pdf(Request $request,$id){
        $name = $request->get('name');
        // $regla=$cotizacion->tipo;
        $empresa=Empresa::first();
        $facturacion=Facturacion::find($id);
        $facturacion_registro=Facturacion_registro::where('facturacion_id',$id)->get();
        $sum=0;
        $igv=Igv::first();
        $sub_total=0;
        $banco=Banco::where('estado',0)->get();
        $banco_count=Banco::where('estado','0')->count();
        $i = 1;

        $archivo=$name.'_'.$id;
        $pdf=PDF::loadView('transaccion.venta.facturacion.pdf',compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco','banco_count','i'));
        return $pdf->download('Facturacion - '.$archivo.'.pdf');

        // return view('transaccion.venta.facturacion.print', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
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
