<?php

namespace App\Http\Controllers;

use App\Banco;
use App\Boleta;
use App\Boleta_registro;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Facturacion;
use App\Forma_pago;
use App\Igv;
use App\Marcas;
use App\Moneda;
use App\Cuotas_credito;
use App\Personal;
use App\Personal_venta;
use App\Producto;
use App\Unidad_medida;
use App\User;
use App\Ventas_registro;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use App\TipoCambio;
use App\Tipo_operacion_f;
use App\Stock_almacen;
use App\Stock_producto;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Almacen;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Luecano\NumeroALetras\NumeroALetras;

class BoletaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boletas=Boleta::all();
        $user_login =auth()->user();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen=Almacen::where('estado',0)->get();
        $almacen_primero=Almacen::where('estado',0)->first();
        return view('transaccion.venta.boleta.index', compact('boletas','user_login','conteo_almacen','almacen','almacen_primero'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        $almacen_p=$request->get('almacen');
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();


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
        //validar almacen con prodcutos vacios
        if(!isset($prod)){
            return redirect()->route('boleta.index')->with('repite', 'No hay productos en el almacen seleccionado');
        }

        $lista=array_values(array_unique($prod));
        $lista_count=count($lista);

       for($x=0;$x<$lista_count;$x++){
           $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }

        $moneda=Moneda::where('principal','1')->first();

        $igv=Igv::where('id','1')->first();

        $tipo_cambio=TipoCambio::latest('created_at')->first();
        if ($moneda->tipo == 'nacional') {
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]);

                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]),2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional'),2);
            }
        }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]);
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]),2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero'),2);
            }
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::all();
        $moneda=Moneda::where('principal','1')->first();
        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $tipo_operacion = Tipo_operacion_f::all();
        $empresa=Empresa::first();

        // obtencion de la sucursal
        $almacen=$request->get('almacen');
        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();
        $boleta_cod_fac=$sucursal->cod_bol;
        if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
            $boleta_cod_fac++;
            $sucursal_nr = str_pad($sucursal->serie_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            //CONDICIONAL PARA SERIE BOLETA
            $almacen_codigo = Almacen::orderBy('serie_boleta','DESC')->latest()->first();
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta+1;
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $sucursal->serie_boleta;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;

        return view('transaccion.venta.boleta.create',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','sucursal','boleta_numero','tipo_operacion'));

    }

    public function create_ms(Request $request)
    {

        $almacen_p=$request->get('almacen');
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();


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
        //validar almacen con prodcutos vacios
        if(!isset($prod)){
            return redirect()->route('boleta.index')->with('repite', 'No hay productos en el almacen seleccionado');
        }

        $lista=array_values(array_unique($prod));
        $lista_count=count($lista);

       for($x=0;$x<$lista_count;$x++){
           $validacion[$x]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            if(!$validacion[$x]==NULL){
                $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
            }
            // $productos[]=Producto::where('estado_anular',1)->where('estado_id','!=',2)->where('id',$lista[$x])->first();
        }
        $moneda=Moneda::where('principal','0')->first();
        $igv=Igv::first();
        $tipo_cambio=TipoCambio::latest('created_at')->first();
        if ($moneda->tipo == 'extranjera') {
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index]);
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')+$utilidad[$index])/$tipo_cambio->paralelo,2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_nacional')/$tipo_cambio->paralelo,2);
            }
        }else{
            foreach ($productos as $index => $producto) {
                $utilidad[]=Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                $igv_p[]=(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index]);
                $array[]=round((Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')+$utilidad[$index])*$tipo_cambio->paralelo,2);
                $array_cantidad[]=Stock_almacen::where('producto_id',$producto->id)->where('almacen_id',$almacen_p)->sum('stock');
                $array_promedio[]=round(Stock_producto::where('producto_id',$producto->id)->avg('precio_extranjero')*$tipo_cambio->paralelo,2);
            }
        }

        $forma_pagos=Forma_pago::all();
        $clientes=Cliente::all();

        $personales=Personal::all();
        $p_venta=Personal_venta::where('estado','0')->get();
        $tipo_operacion = Tipo_operacion_f::all();

        $empresa=Empresa::first();

        // obtencion de la sucursal
        $almacen=$request->get('almacen');
        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();
        $boleta_cod_fac=$sucursal->cod_fac;
        if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
            $boleta_cod_fac++;
            $sucursal_nr = str_pad($sucursal->serie_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_factura=Facturacion::where('almacen_id',$sucursal->id)->latest()->first();
            $boleta_num=$ultima_factura->codigo_fac;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            //CONDICIONAL PARA SERIE BOLETA
            $almacen_codigo = Almacen::orderBy('serie_boleta','DESC')->latest()->first();
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta+1;
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $sucursal->serie_boleta;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;

        return view('transaccion.venta.boleta.create_ms',compact('productos','forma_pagos','clientes','personales','array','array_cantidad','igv','moneda','p_venta','array_promedio','empresa','boleta_numero','sucursal','tipo_operacion'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id_moneda)
    {
        $print=$request->get('print');

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
                        return redirect()->route('boleta.create')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }

            }
        }
        // Comisionista cobnvertir id

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
            $comision_id  = $comisionista_buscador->id;
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



        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        // obtencion de la sucursal
        $almacen=$request->get('almacen');
        //obtencion del almacen
        $sucursal=Almacen::where('id', $almacen)->first();
        $boleta_cod_fac=$sucursal->cod_bol;
        if (is_numeric($boleta_cod_fac)) {
            // exprecion del numero de fatura
            $boleta_cod_fac++;
            $sucursal_nr = str_pad($sucursal->serie_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_cod_fac, 8, "0", STR_PAD_LEFT);
        }else{
            // exprecion del numero de fatura
            // GENERACION DE NUMERO DE FACTURA
            $ultima_boleta=Boleta::where('almacen_id',$sucursal->id)->latest()->first();
            $boleta_num=$ultima_boleta->codigo_boleta;
            $boleta_num_string_porcion= explode("-", $boleta_num);
            $boleta_num_string=$boleta_num_string_porcion[1];
            $boleta_num=(int)$boleta_num_string;
            //CONDICIONAL PARA SERIE BOLETA
            $almacen_codigo = Almacen::orderBy('serie_boleta','DESC')->latest()->first();
            if($boleta_num == 99999999){
                $ultima_boleta = $almacen_codigo->serie_boleta+1;
                $almacen_save_last = Almacen::find($sucursal->id);
                $almacen_save_last->serie_boleta = $almacen_codigo->serie_boleta+1;
                $almacen_save_last->save();
                $boleta_num = 00000000;
            }else{
                $ultima_boleta = $sucursal->serie_boleta;
            }
            $boleta_num++;
            $sucursal_nr = str_pad($ultima_boleta, 3, "0", STR_PAD_LEFT);
            $boleta_nr=str_pad($boleta_num, 8, "0", STR_PAD_LEFT);
        }
        $boleta_numero="B".$sucursal_nr."-".$boleta_nr;


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
                if(Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->first()){
                    $nueva_v[]=Kardex_entrada_registro::where('producto_id',$producto_id[$i])->where('kardex_entrada_id',$kadex_entrada_id_v[$x])->where('estado',1)->where('tipo_registro_id','!=',2)->first();
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
        // CODIGO PARA BUSCAR EL ID DEL TIPO DE DOCUMENTO
        $operacion=$request->get('tipo_operacion');
        $nombre = strstr($operacion, '-',true);
        $busca_ope=Tipo_operacion_f::where('codigo',$nombre)->first();
        $igv=Igv::first();
        $boleta=new Boleta;
        $boleta->codigo_boleta=$boleta_numero;
        $boleta->almacen_id =$request->get('almacen');
        $boleta->orden_compra=$request->get('orden_compra');
        $boleta->guia_remision=$request->get('guia_r');
        $boleta->cliente_id=$cliente_buscador->id;
        $boleta->moneda_id=$id_moneda;
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
        $boleta->tipo='producto';
        $boleta->tipo_documento_id = 3;
        $boleta->tipo_operacion_id = $busca_ope->id;
        $boleta->save();
        
        if($boleta->forma_pago_id == 2){

            $fecha_pago = $request->input('fecha_pago');
            $contador_for = count($fecha_pago);
            $monto_pago = $request->input('monto_pago');
            // foreach($contador_for as $cuotas => $index ){
            for($c = 0; $c<$contador_for;$c++ ){
                $cuota_cred = new Cuotas_credito;
                $cuota_cred->boleta_id = $boleta->id;
                $cuota_cred->numero_cuota = $c+1;
                $cuota_cred->monto = $monto_pago[$c];
                $cuota_cred->fecha_pago = $fecha_pago[$c];
                $cuota_cred->save();
            }
        }
        $total_comi=$request->get('total_comi');


        if(isset($comision_id)){
            $comisionista_porcentaje=Personal_venta::where('id',$comision_id)->first();
            $comisionista=new Ventas_registro;
            $comisionista->comisionista=$comision_id;
            $comisionista->tipo_moneda=$id_moneda;
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
        // modificacion para que se cierre el codigo en almacen
        // obtencion de la sucursal
        // $sucursal=auth()->user()->almacen->serie_boleta;
        //obtencion del almacen
        $factura_primera=Almacen::where('id', $sucursal->id)->first();
        $factura_primera->cod_bol='NN';
        $factura_primera->save();


        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //contador de valores del check descuento
        $check = $request->input('check_descuento');
        $count_check=count($check);



        $moneda=Moneda::where('principal',1)->first();
        $moneda_registrada=$boleta->moneda_id;

        if($count_articulo = $count_cantidad  = $count_check){
            for($i=0;$i<$count_articulo;$i++){
                $boleta_registro=new Boleta_registro;
                $boleta_registro->boleta_id=$boleta->id;
                $boleta_registro->producto_id=$producto_id[$i];
                $boleta_registro->numero_serie=$request->get('numero_serie')[$i];
                //producto
                $producto=Producto::where('id',$producto_id[$i])->where('estado_id',1)->where('estado_anular',1)->first();

                //stock --------------------------------------------------------
                $stock=Stock_almacen::where('producto_id',$producto_id[$i])->sum('stock');
                $boleta_registro->stock=$stock;
                // precio
                if($moneda->id == $moneda_registrada){
                    if ($moneda->tipo == 'nacional'){
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional');
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad);
                        $array=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad);
                        $boleta_registro->precio=$array;
                    }else{
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero');
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad);
                        $array=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad);
                        $boleta_registro->precio=$array;
                    }
                }else{
                    if ($moneda->tipo == 'extranjera'){
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*$cambio->paralelo,2);
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero')+$utilidad);
                        $array=round((Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_extranjero'))*$cambio->paralelo+$utilidad,2);
                        $boleta_registro->precio=$array;
                    }else{
                        //promedio original revisar que es  promedio nacional--------------------------------------------------------
                        $array2=round(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')/$cambio->paralelo,2);
                        $boleta_registro->promedio_original=$array2;

                        $utilidad=Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
                        $igv_p=(Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad);
                        $array=round((Stock_producto::where('producto_id',$producto_id[$i])->avg('precio_nacional')+$utilidad)/$cambio->paralelo,2);
                        $boleta_registro->precio=$array;
                    }
                }

                $boleta_registro->cantidad=$request->get('cantidad')[$i];
                $boleta_registro->descuento=$request->get('check_descuento')[$i];
                $boleta_registro->comision=$comi;
                    //precio unitario descuento ----------------------------------------
                $desc_comprobacion=$request->get('check_descuento')[$i];
                if($desc_comprobacion <> 0){
                    $precio_uni = $array - ($array2*$desc_comprobacion/100);
                    $boleta_registro->precio_unitario_desc=$precio_uni+($precio_uni*($igv->igv_total/100));
                    // return $array*($igv->igv_total/100);
                }else{
                    $boleta_registro->precio_unitario_desc=$array+($array*($igv->igv_total/100));
                    // return $array_pre_prom;
                }
                    //precio unitario comision ----------------------------------------
                if($desc_comprobacion <> 0){
                     $precio_uni = $array - ($array2*$desc_comprobacion/100);
                     $precio_comi = $precio_uni+($precio_uni*($comi/100));
                     $boleta_registro->precio_unitario_comi=$precio_comi+($precio_comi*($igv->igv_total/100));
                }else{
                    $precio_comi = $array+($array*($comi/100));
                    $boleta_registro->precio_unitario_comi=($precio_comi)+($precio_comi*($igv->igv_total/100));
            }
             //TIPO DE AFECTACION
            $boleta_2=Boleta::find($boleta->id);
            if(strpos($producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                $boleta_2->op_gravada += round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                $boleta_2->op_exonerada += round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2);
            }
            if(strpos($producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                $boleta_2->op_inafecta += round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2);
            }
            $boleta_2->save();
            $boleta_registro->save();
                // return $array;

                $almacen=$boleta->almacen_id;
                $nueva=Kardex_entrada_registro::where('producto_id',$boleta_registro->producto_id)->where('almacen_id',$almacen)->where('estado',1)->get();

                $comparacion=$nueva;
                //buble para la cantidad
                $cantidad=0;
                foreach($comparacion as $comparaciones){
                    $cantidad=$comparaciones->cantidad+$cantidad;
                }
                    if(isset($comparacion)){
                        $var_cantidad_entrada=$boleta_registro->cantidad;
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
                    Stock_almacen::egreso($boleta->almacen_id,$producto_id[$i],$boleta_registro->cantidad);
                    //resta de cantidades de productos para la tabla stock productos
                    $stock_productos=Stock_producto::where('producto_id',$producto_id[$i])->first();
                    $stock_productos->stock=$stock_productos->stock-$boleta_registro->cantidad;
                    $stock_productos->save();
            }
            Kardex_entrada_registro::stock_producto_precio();
        }else {
            return redirect()->route('boleta.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('boleta.show',$boleta->id);
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
        return view('transaccion.venta.boleta.show', compact('boleta','empresa','banco','boleta_registro','igv','sub_total'));
    }

    public function print($id){
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::all();
        $empresa=Empresa::first();
        $sub_total=0;
        $boleta=Boleta::find($id);
        return view('transaccion.venta.boleta.print', compact('boleta','empresa','banco','boleta_registro','igv','sub_total'));
    }
    public function pdf(Request $request,$id){
        $name = $request->get('name');
        // $regla=$cotizacion->tipo;
        $boleta_registro=Boleta_registro::where('boleta_id',$id)->get();
        $igv=Igv::first();
        $banco=Banco::all();
        $banco_count=Banco::where('estado','0')->count();
        $empresa=Empresa::first();
        $sub_total=0;
        $boleta=Boleta::find($id);
        $i=1;
        $archivo=$name.'_'.$id;
        $pdf=PDF::loadView('transaccion.venta.boleta.pdf', compact('boleta','empresa','banco','boleta_registro','igv','sub_total','banco_count','i'));
        return $pdf->download('Boleta - '.$archivo.'.pdf');

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
    public function ticket_ajax_boleta(Request $request){

    $ids = $request->get('id');
    $boleta=Boleta::find($ids);
    $boleta_registro= Boleta_registro::where('boleta_id',$ids)->get();
    $empresa=Empresa::first();
    $moneda = Moneda::where('id',$boleta->moneda_id)->first();
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
    $printer->text("BOLETA ELECTRONICA\n");
    $printer->text($boleta->codigo_boleta."\n");
    $printer->text("===============================\n");
    $printer->text($boleta->created_at."\n");
    $printer->text($empresa->nombre."\n");
    $printer->setEmphasis(true);
    $printer->text("RUC: ".$empresa->ruc."\n");
    // $printer->setEmphasis(false);
    $printer->text($empresa->calle." - ".$empresa->ciudad." - ".$empresa->region_provincia."\n");
    $printer->text("Telefono: ".$empresa->telefono);
    $printer->setEmphasis(false);
    $printer->text("\n===============================\n");

    //Cliente
    $cliente_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Cliente", ':', $boleta->cliente->nombre);
    $printer->text($cliente_dato."\n");
    $cliente_id= sprintf('%-15.20s %-2.2s %-21.21s', $boleta->cliente->documento_identificacion, ':', $boleta->cliente->numero_documento);
    $printer->text($cliente_id);
    $printer->text("\n===============================\n");

    //Productos
    if($boleta->tipo == "producto"){
        $leyenda = sprintf('%-14.14s %6.6s %8.8s  %8.8s', 'Producto', 'Cant.', 'P.Unit', 'Total');
    }else{
        $leyenda = sprintf('%-14.14s %6.6s %8.8s  %8.8s', 'Servicio', 'Cant.', 'P.Unit', 'Total');
    }
    $printer->text( $leyenda);
    $printer->text("\n");
     foreach($boleta_registro as $bol_regs){
        // $printer -> selectPrintMode(Printer::MODE_UNDERLINE);
        $subtotal = ($bol_regs->precio_unitario_comi * $bol_regs->cantidad);
        // %-4.2s $facturacion->moneda->simbolo,
        if($boleta->tipo == "producto"){
            $line = sprintf('%-14.14s %6.0d %8.2F %8.2F', $bol_regs->producto->nombre, $bol_regs->cantidad, $bol_regs->precio_unitario_comi, $subtotal);
        }else{
            $line = sprintf('%-14.14s %6.0d %8.2F %8.2F', $bol_regs->servicio->nombre, $bol_regs->cantidad, $bol_regs->precio_unitario_comi, $subtotal);
        }
        // $printer->setJustification(Printer::JUSTIFY_LEFT);
        // $printer->text( ("%.2fx%s\n", , ));
        // $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text( $line);
        $printer->text("\n");
        // $printer -> selectPrintMode();
        // $total += $subtotal;
    }

    $sub_total=($boleta->op_gravada)+($boleta->op_inafecta)+($boleta->op_exonerada);
    $sub_total_gravado=($boleta->op_gravada);
    // $igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100;
    $end=round($sub_total, 2)+round($igv_p, 2);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("\n===============================\n");
    $printer->setJustification(Printer::JUSTIFY_RIGHT);

    $subtotal = sprintf('%20.20s %-2.2s %15.2F', "SUBTOTAL ".$moneda->simbolo, " : ", $sub_total);
    $printer->text($subtotal."\n");
    $op_gravada = sprintf('%20.20s %-2.2s %15.2F', "OP. Gravada ".$moneda->simbolo, " : ", $boleta->op_gravada);
    $printer->text($op_gravada."\n");
    $op_inafecta = sprintf('%20.20s %-2.2s %15.2F', "OP. Inafecta ".$moneda->simbolo, " : ", $boleta->op_inafecta);
    $printer->text($op_inafecta."\n");
    $op_exonerada = sprintf('%20.20s %-2.2s %15.2F', "OP. Exonerada ".$moneda->simbolo, " : ", $boleta->op_exonerada);
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
