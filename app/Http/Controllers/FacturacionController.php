<?php

namespace App\Http\Controllers;

use App\Almacen;
Use App\Codigo_guia_almacen;
use App\Banco;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_registro;
use App\Forma_pago;
use App\Cuotas_credito;
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
use App\Tipo_operacion_f;
use App\Ventas_registro;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use App\Stock_almacen;
use App\Stock_producto;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=kardex_entrada::where('estado',2)->first();
        if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

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

        $inventario_inicial=Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ( $inventario_inicial->estado==1) {
                return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
            }
        }

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
            return redirect()->route('facturacion.index')->with('repite', 'No hay productos en el almacen seleccionado');
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
        $tipo_operacion = Tipo_operacion_f::all();
        // $empresa = Empresa::all();
        // obtencion de la sucursal
        $almacen=$request->get('almacen');

        //obtencion del almacen
        $sucursal =Almacen::where('id', $almacen)->first();
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
        // return $sucursal;
        $factura_cod_fac=$cod_guia->cod_factura;
        if (is_numeric($factura_cod_fac)) {
            // exprecion del numero de fatura
            $factura_cod_fac++;
            $sucursal_nr = str_pad($cod_guia->serie_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_factura=Facturacion::where('almacen_id',$sucursal->id)->latest()->first();
            $factura_num=$ultima_factura->codigo_fac;
            $factura_num_string_porcion= explode("-", $factura_num);
            $factura_num_string=$factura_num_string_porcion[1];
            $factura_num=(int)$factura_num_string;

            $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura','DESC')->latest()->first();
            //CONDICIONAL PARA QUE EMPIEZE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_factura+1;
                $factura_num = 00000000;

            }else{
                $ultima_factura = $cod_guia->serie_factura;
            }
            $factura_num++;
            $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
            $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
        }

        $factura_numero="F".$sucursal_nr."-".$factura_nr;

        return view('transaccion.venta.facturacion.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','factura_numero','sucursal','empresa','tipo_operacion'));
    }

    public function create_ms(Request $request){

        $inventario_inicial=Kardex_entrada::first();
        if (isset($inventario_inicial)) {
            if ( $inventario_inicial->estado==1) {
                return redirect()->route('kardex-entrada.show',$inventario_inicial->id);
            }
        }

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
            return redirect()->route('facturacion.index')->with('repite', 'No hay productos en el almacen seleccionado');
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
        $tipo_operacion = Tipo_operacion_f::all();

       // obtencion de la sucursal
       $almacen=$request->get('almacen');

       //obtencion del almacen
       $sucursal =Almacen::where('id', $almacen)->first();
        $cod_guia= Codigo_guia_almacen::where('almacen_id',$sucursal->id)->first();
       $factura_cod_fac=$cod_guia->cod_factura;
       if (is_numeric($factura_cod_fac)) {
           // exprecion del numero de fatura
           $factura_cod_fac++;
           $sucursal_nr = str_pad($cod_guia->serie_factura, 3, "0", STR_PAD_LEFT);
           $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
       }else{
           // exprecion del numero de fatura
           // GENERACION DE NUMERO DE FACTURA
           $ultima_factura=Facturacion::where('almacen_id',$sucursal->id)->latest()->first();
           $factura_num=$ultima_factura->codigo_fac;
           $factura_num_string_porcion= explode("-", $factura_num);
           $factura_num_string=$factura_num_string_porcion[1];
           $factura_num=(int)$factura_num_string;
           //CONDICIONAL PARA QUE EMPIEZE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL
           $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura','DESC')->latest()->first();
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_factura+1;
                $factura_num = 00000000;

            }else{
                $ultima_factura = $cod_guia->serie_factura;
            }
           $factura_num++;
           $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
           $factura_nr=str_pad($factura_num, 8, "0", STR_PAD_LEFT);
       }

       $factura_numero="F".$sucursal_nr."-".$factura_nr;

        return view('transaccion.venta.facturacion.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','suma','categoria','factura_numero','sucursal','tipo_operacion'));
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
        // return $request;
        // return $request->get('monto_pago');
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
            $comision_id = $comisionista_buscador->id;
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
       $almacen_id =Almacen::where('id', $almacen)->first();
        $sucursal = Codigo_guia_almacen::where('almacen_id',$almacen_id->id)->first();
       $factura_cod_fac=$sucursal->cod_factura;
       if (is_numeric($factura_cod_fac)) {
           // exprecion del numero de fatura
           $factura_cod_fac++;
           $sucursal_nr = str_pad($sucursal->serie_factura, 3, "0", STR_PAD_LEFT);
           $factura_nr=str_pad($factura_cod_fac, 8, "0", STR_PAD_LEFT);
       }else{
           // exprecion del numero de fatura
           // GENERACION DE NUMERO DE FACTURA
           $ultima_factura=Facturacion::where('almacen_id',$almacen_id->id)->latest()->first();
           $factura_num=$ultima_factura->codigo_fac;
           $factura_num_string_porcion= explode("-", $factura_num);
           $factura_num_string=$factura_num_string_porcion[1];
           $factura_num=(int)$factura_num_string;
           //CONDICIONAL PARA QUE EMPIEZE DE NUEVO EN 0001 PARA EL NUMERO DE SERIE Y EL CORRELATIVO -> FALTA PULIR/IDEA GENERAL --> SOLO PARA STORE
           $almacen_codigo = Codigo_guia_almacen::orderBy('serie_factura','DESC')->latest()->first();
            if($factura_num == 99999999){
                $ultima_factura = $almacen_codigo->serie_factura+1;
                $almacen_save_last = Codigo_guia_almacen::find($sucursal->id);
                $almacen_save_last->serie_factura = $almacen_codigo->serie_factura+1;
                $almacen_save_last->save();
                $factura_num = 00000000;
            }else{
                $ultima_factura = $sucursal->serie_factura;
            }
           $factura_num++;
           $sucursal_nr = str_pad($ultima_factura, 3, "0", STR_PAD_LEFT);
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
            // return $kadex_entrada_id_v;
            for($x=0;$x<$kardex_entrada_count_v;$x++){
                if(Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first()){
                    $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->first();
                }
            }
            // return $nueva_v;
            $comparacion_v=$nueva_v;
            //buble para la cantidad
            $cantidad_v=0;
            foreach($comparacion_v as $comparaciones_v){
                $cantidad_v=$comparaciones_v->cantidad+$cantidad_v;
            }
            // return $nueva_v;
            $cantidad_entrada=$request->get('cantidad')[$i];
            if($cantidad_v<$cantidad_entrada){
               return "cantidad mayor al stock";
            }

        }
        // CODIGO PARA BUSCAR EL ID DEL TIPO DE DOCUMENTO
        $operacion=$request->get('tipo_operacion');
        $nombre = strstr($operacion, '-',true);
        $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();
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
        $facturacion->comisionista= $comi;
        $facturacion->user_id =auth()->user()->id;
        $facturacion->estado='0';
        $facturacion->tipo='producto';
        $facturacion->tipo_operacion_id= $busca_ope->id;
        $facturacion->tipo_documento_id = 2;
        $facturacion->save();

        $precio_final_igv=$request->get('precio_final_igv');
        $sub_total_sin_igv=$request->get('sub_total_sin_igv');


        if(isset($comision_id)){
            $comisionista_porcentaje=Personal_venta::where('id',$comision_id)->first();
            $comisionista=new Ventas_registro;
            $comisionista->comisionista=$comision_id;
            $comisionista->tipo_moneda=$id_moneda;
            $comisionista->estado_aprobado='0';
            $comisionista->estado_pagado='0';
            $comisionista->estado_anular_fac_bol='0';
            $comisionista->monto_final_fac_bol=$precio_final_igv;
                $porcentaje=100+$comisionista_porcentaje->comision;
            $comisionista->monto_comision=(100*$sub_total_sin_igv/$porcentaje)*$comisionista_porcentaje->comision/100;
            // $comisionista->id_coti_produc=$cotizador;
            $comisionista->id_fac=$facturacion->id;
            $comisionista->observacion='Factura';
            $comisionista->save();
        }
        // modificacion para que se cierre el codigo en almacen
        $factura_primera=Codigo_guia_almacen::where('id', $sucursal->id)->first();
        if(is_numeric($factura_primera->cod_factura)){
            $factura_primera->cod_factura='NN';
            $factura_primera->save();
        }
        //FORMA DE PAGO
        if($facturacion->forma_pago_id == 2){

            $fecha_pago = $request->input('fecha_pago');
            $contador_for = count($fecha_pago);
            $monto_pago = $request->input('monto_pago');
            // foreach($contador_for as $cuotas => $index ){
            for($c = 0; $c<$contador_for;$c++ ){
                $cuota_cred = new Cuotas_credito;
                $cuota_cred->facturacion_id = $facturacion->id;
                $cuota_cred->numero_cuota = $c+1;
                $cuota_cred->monto = $monto_pago[$c];
                $cuota_cred->fecha_pago = $fecha_pago[$c];
                $cuota_cred->save();
            }
        }
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
                        $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional'),2);
                        $facturacion_registro->promedio_original=$array2;
                        // respectividad de la moneda deacurdo al id
                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad,2);
                        $facturacion_registro->precio=$array;
                    }else {
                        //promedio original ojo revisar que es precio nacional --------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero'),2);
                        $facturacion_registro->promedio_original=$array2;
                        // validacion para la otra moneda con igv paralelo
                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $array=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad,2);
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
                    $factura_desc = round($array-($array2*$desc_comprobacion/100),2);
                    $facturacion_registro->precio_unitario_comi=round($factura_desc+($factura_desc*$comi/100),2);
                }else{
                    $facturacion_registro->precio_unitario_comi=round($array+($array*$comi/100),2);
                }
                $facturacion_2=Facturacion::find($facturacion->id);
                if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                    $facturacion_2->op_gravada += round($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                    $facturacion_2->op_exonerada += round($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad,2);
                }
                if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                    $facturacion_2->op_inafecta += round($facturacion_registro->precio_unitario_comi*$facturacion_registro->cantidad,2);
                }
                // return $cotizacion_registro->precio_unitario_comi;
                $facturacion_2->save();
                $facturacion_registro->save();

                //empieza la busqueda total

                //en caso haya guia de remision esto ya no se efectua
                if($facturacion->guia_remision=="0"){
                    $almacen=$facturacion->almacen_id;

                    $nueva=Kardex_entrada_registro::where('producto_id',$facturacion_registro->producto_id)->where('almacen_id',$almacen)->where('estado',1)->get();

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
                    //resta de cantidades de productos para la tabla stock productos
                        $stock_productos=Stock_producto::where('producto_id',$producto_id[$i])->first();
                        $stock_productos->stock=$stock_productos->stock-$facturacion_registro->cantidad;
                        $stock_productos->save();

                }

            }
            Kardex_entrada_registro::stock_producto_precio();
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
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=kardex_entrada::where('estado',2)->first();
        if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id=Facturacion::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('facturacion.index'); }

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
        // REDIRECCION PARA MOSTRAR EL inventario_inicial
        $existe_id=kardex_entrada::where('estado',2)->first();
        if(empty($existe_id)){ return redirect()->route('kardex-entrada.index'); }

        //REDIRECCION PARA NO MOSTRAR ERROR LARAVEL DE ID SHOW
        $existe_id=Facturacion::where('id',$id)->first();
        if(empty($existe_id)){ return redirect()->route('facturacion.index'); }

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
        // return view('transaccion.venta.facturacion.print', compact('facturacion','empresa','facturacion_registro','sum','igv','sub_total','banco'));
        
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
        // return $id;
        $factura = Facturacion::where('id',$id)->first();
        if($factura->comisionista != 0){
            $venta_registro=Ventas_registro::where('id_facturacion',$id)->first();
            $id_venta_r=$venta_registro->id;

            $venta=Ventas_registro::where('id',$id_venta_r)->first();
            $venta->estado_fac=1;
            $venta->save();
        }
        $fac=Facturacion::where('id',$id)->first();
        $fac->estado=1;
        $fac->save();

        return redirect()->route('facturacion.index');
    }
    public function ticket_ajax(Request $request){

    $ids = $request->get('id');
    $facturacion=Facturacion::find($ids);
    $facturacion_registro=Facturacion_registro::where('facturacion_id',$ids)->get();
    $empresa=Empresa::first();
    $moneda = Moneda::where('id',$facturacion->moneda_id)->first();
    $igv=Igv::first();

    $nombre_impresora = "EPSONTICKET";

    $connector = new WindowsPrintConnector($nombre_impresora);
    $printer = new Printer($connector);
    #Mando un numero de respuesta para saber que se conecto correctamente.
    echo 1;

     //EMPRESA
    $empresa=Empresa::first();
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setEmphasis(true);
    $printer->text("FACTURA ELECTRONICA\n");
    $printer->text($facturacion->codigo_fac."\n");
    $printer->text("===============================\n");
    $printer->text($facturacion->created_at."\n");
    $printer->text($empresa->nombre."\n");
    $printer->setEmphasis(true);
    $printer->text("RUC: ".$empresa->ruc."\n");
    // $printer->setEmphasis(false);
    $printer->text($empresa->calle." - ".$empresa->ciudad." - ".$empresa->region_provincia."\n");
    $printer->text("Telefono: ".$empresa->telefono);
    $printer->setEmphasis(false);
    $printer->text("\n===============================\n");

    //Cliente    
    $cliente_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Cliente", ':', $facturacion->cliente->nombre);
    $printer->text($cliente_dato."\n");
    $cliente_id= sprintf('%-15.20s %-2.2s %-21.21s', $facturacion->cliente->documento_identificacion, ':', $facturacion->cliente->numero_documento);
    $printer->text($cliente_id);
    $printer->text("\n===============================\n");

    //Productos
    if($facturacion->tipo == "producto"){
        $leyenda = sprintf('%-14.14s %6.6s %8.8s  %8.8s', 'Producto', 'Cant.', 'P.Unit', 'Total');
    }else{
        $leyenda = sprintf('%-14.14s %6.6s %8.8s  %8.8s', 'Servicio', 'Cant.', 'P.Unit', 'Total');
    }
    $printer->text( $leyenda);
    $printer->text("\n"); 
     foreach($facturacion_registro as $fag_regs){
        // $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
        $subtotal = ($fag_regs->precio_unitario_comi * $fag_regs->cantidad);
        // %-4.2s $facturacion->moneda->simbolo, 
        if($facturacion->tipo == "producto"){
            $line = sprintf('%-14.14s %6.0d %8.2F %8.2F', $fag_regs->producto->nombre, $fag_regs->cantidad, $fag_regs->precio_unitario_comi, $subtotal);
        }else{
            $line = sprintf('%-14.14s %6.0d %8.2F %8.2F', $fag_regs->servicio->nombre, $fag_regs->cantidad, $fag_regs->precio_unitario_comi, $subtotal);
        }
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text( ("%.2fx%s\n", , ));
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text( $line);
        $printer->text("\n"); 
        // $printer -> selectPrintMode();
        // $total += $subtotal;
    }

    $sub_total=($facturacion->op_gravada)+($facturacion->op_inafecta)+($facturacion->op_exonerada);
    $sub_total_gravado=($facturacion->op_gravada);
    $igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100;
    $end=round($sub_total, 2)+round($igv_p, 2);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("\n===============================\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);

    $subtotal = sprintf('%20.20s %-2.2s %15.2F', "SUBTOTAL ".$moneda->simbolo, " : ", $sub_total);
    $printer->text($subtotal."\n");
    $op_gravada = sprintf('%20.20s %-2.2s %15.2F', "OP. Gravada ".$moneda->simbolo, " : ", $facturacion->op_gravada);
    $printer->text($op_gravada."\n");
    $op_inafecta = sprintf('%20.20s %-2.2s %15.2F', "OP. Inafecta ".$moneda->simbolo, " : ", $facturacion->op_inafecta);
    $printer->text($op_inafecta."\n");
    $op_exonerada = sprintf('%20.20s %-2.2s %15.2F', "OP. Exonerada ".$moneda->simbolo, " : ", $facturacion->op_exonerada);
    $printer->text($op_exonerada."\n");
    $igv = sprintf('%20.20s %-2.2s %15.2F', "I.G.V ".$moneda->simbolo, " : ", $igv_p);
    $printer->text($igv."\n");
    $printer->setEmphasis(true);
    $total = sprintf('%20.20s %-2.2s %15.2F', "TOTAL ".$moneda->simbolo, " : ", $end);
    $printer->text($total."\n");
    $printer->setEmphasis(false);

 
    //NUMEROS A LETRAS
    $formatter = new NumeroALetras();
    $num_let = $formatter->toInvoice($end);
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("Son: ".$num_let." ".$moneda->nombre."\n");

    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("\n===============================\n");
    $usuario = User::where('id',$facturacion->user_id)->first();
    $printer->text("Atendido por: ".$usuario->name."\n");
    $printer->text("Autorizado mediante resolucion\n");
    $printer->text("N° RS 018-005-0002243/SUNAT\n");
    $printer->text("Representación impresa de la \n");
    $printer->text("Boleta de Venta Electronica\n");
    $printer->text("Para consultar el documento\n");
    $printer->text("Ingrese a:\n");
    $printer->text("https://ww2.todasmisfacturas.com.pe\n");
    // $printer->text("Muchas gracias por su compra\n");
    /*Alimentamos el papel 3 veces*/
    $printer->feed(3);

    /*
        Cortamos el papel. Si nuestra impresora
        no tiene soporte para ello, no generará
        ningún error
    */
    $printer->cut();

    /*
        Por medio de la impresora mandamos un pulso.
        Esto es útil cuando la tenemos conectada
        por ejemplo a un cajón
    */
    $printer->pulse();

    /*
        Para imprimir realmente, tenemos que "cerrar"
        la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
    */
    $printer->close();
    }

}
