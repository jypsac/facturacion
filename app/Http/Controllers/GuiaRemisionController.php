<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Banco;
use App\Cliente;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_factura_registro;
use App\Empresa;
use App\Guia_remision;
use App\Igv;
use App\MotivoTraslado;
use App\Personal;
use App\Producto;
use App\TransportePublico;
use App\Vehiculo;
use App\g_remision_registro;
use App\kardex_entrada_registro;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class GuiaRemisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_login =auth()->user();
      $guia_remision=Guia_remision::all();
      $almacen=Almacen::where('estado',0)->get();
      $almacen_primero=Almacen::where('estado',0)->first();
      $conteo_almacen=Almacen::where('estado',0)->count();
      return view('transaccion.venta.guia_remision.index',compact('guia_remision','almacen','conteo_almacen','almacen_primero','user_login'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      /*Codigo*/
        //Guardado de almacen para inventario-inicial
      $almacen=$request->get('almacen');
      $id_almacen=Almacen::where('id',$almacen)->first();
      $almacen_serie_remision=$id_almacen->serie_remision;/*Codigo que brinda sunat a cada sucursal*/
      $almacen_codigo = Almacen::orderBy('serie_remision','DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO
      if ($id_almacen->cod_guia=='NN'){
        $agrupar_almacen=Guia_remision::where('almacen_id',$almacen)->get()->last();
        $numero = substr(strstr($agrupar_almacen->cod_guia, '-'), 1);
        if($numero == 99999999){
          $ultima_serie = $almacen_codigo->serie_remision+1;
          $numero = 00000000;
        }else{
          $ultima_serie = $almacen_serie_remision;
        }
      } else{
        $numero=$id_almacen->cod_guia;
        $ultima_serie = $almacen_serie_remision;
      }
      $numero++;
      $cantidad_sucursal=str_pad($ultima_serie, 3, "0", STR_PAD_LEFT);
      $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
      $codigo_guia='GR'.$cantidad_sucursal.'-'.$cantidad_registro;

      /* Fin de Codigo*/


      $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
      foreach ($productos as $index => $producto) {
        $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')*($producto->utilidad-$producto->descuento1)/100;
        $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional')+$utilidad[$index];
        $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio_nacional');
      }

      $clientes=Cliente::all();
      $personal=Personal::all();
      $motivo_traslado=MotivoTraslado::all();
      $vehiculo=Vehiculo::where('estado_activo',0)->get();
      $transporte_publico=TransportePublico::where('estado',0)->get();
      $empresa=Empresa::first();
      $igv=Igv::first();
      return view('transaccion.venta.guia_remision.create',compact('productos','clientes','array','array_cantidad','igv','array_promedio','empresa','vehiculo','motivo_traslado','codigo_guia','almacen','personal','transporte_publico'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      /*Codigo*/
        //Guardado de almacen para inventario-inicial
      $almacen=$request->get('almacen');
      $id_almacen=Almacen::where('id',$almacen)->first();
      $almacen_serie_remision=$id_almacen->serie_remision;/*Codigo que brinda sunat a cada sucursal*/
      $almacen_codigo = Almacen::orderBy('serie_remision','DESC')->latest()->first(); // NUYMERO SERIE DE REMISIONMAS ALTO PARA EL CAMBIO
      if ($id_almacen->cod_guia=='NN') {
        $agrupar_almacen=Guia_remision::where('almacen_id',$almacen)->get()->last();
        $numero = substr(strstr($agrupar_almacen->cod_guia, '-'), 1);
        if($numero == 99999999){
          $ultima_serie = $almacen_codigo->serie_remision+1;
          $almacen_update = Almacen::find($id_almacen->id);
          $almacen_update->serie_remision = $ultima_serie;
          $almacen_update->save();
          $numero = 00000000;
        }else{
          $ultima_serie = $almacen_serie_remision;
        }
      } else{
        $numero = $id_almacen->cod_guia;
        $ultima_serie = $almacen_serie_remision;
      }
      $numero++;
      $cantidad_sucursal=str_pad($ultima_serie, 3, "0", STR_PAD_LEFT);
      $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
      $codigo_guia='GR'.$cantidad_sucursal.'-'.$cantidad_registro;

      /* Fin de Codigo*/

             //id del cliente de create_2
      $id_cliente=$request->get('cliente_id');
      $id_cotizacion=$request->get('id');
            //Buscador Cliente
      if (isset($id_cliente)) {
       $cliente_id=$request->get('cliente_id');
     }
     else{
      $cliente_nombre=$request->get('cliente');
      $nombre = strstr($cliente_nombre, '-',true);
      $cliente_buscador=Cliente::where('numero_documento',$nombre)->first();
      $cliente_id=$cliente_buscador->id;
    }
    $tipo_transporte=$request->get('tipo_transporte');

    $guia_remision=new Guia_remision;
    $guia_remision->cod_guia=$codigo_guia;
    $guia_remision->cliente_id=$cliente_id;
    $guia_remision->almacen_id=$id_almacen->id;
    $guia_remision->fecha_emision=$request->get('fecha_emision');
    $guia_remision->fecha_entrega=$request->get('fecha_entrega');
    if ($tipo_transporte==1) {
      $guia_remision->vehiculo_publico=$request->get('vehiculo_publico');
    }elseif ($tipo_transporte==2) {
      $guia_remision->vehiculo_id=$request->get('vehiculo');
      $guia_remision->conductor_id=$request->get('conductor');
    }
    $guia_remision->tipo_transporte=$tipo_transporte;
    //0= sin transporte 
    //1= transporte publico 
    //2= transporte privado
    $guia_remision->motivo_traslado=$request->get('motivo_traslado');
    $guia_remision->observacion=$request->get('observacion');
    $guia_remision->estado_anulado='0';
    $guia_remision->estado_registrado='0';
    $guia_remision->user_id=auth()->user()->id;
    $guia_remision->save();

    $almacen=Almacen::find($id_almacen->id);
    $almacen->cod_guia='NN';
    $almacen->save();

    if (isset($id_cliente)) {
      $cotizacion_estado_aprobado=Cotizacion::find($id_cotizacion);
      $cotizacion_estado_aprobado->estado_aprobado='1';
      $cotizacion_estado_aprobado->save();
    }

    //registro de productos de la tabla guia de remision
    $articulo = $request->input('articulo');
    $count_articulo=count($articulo);

    $stock = $request->input('stock');
    $count_stock=count($stock);

    $cantidad = $request->input('cantidad');
    $count_cantidad=count($cantidad);

    $series = $request->input('series');
    $count_series=count($series);

    $peso = $request->input('peso');
    $count_peso=count($peso);

    for($i=0 ; $i<$count_articulo;$i++){
      $articulos[$i]= $request->input('articulo')[$i];
      $producto_id[$i]=strstr($articulos[$i], ' ', true);
    }

    if($count_articulo = $count_stock  = $count_cantidad = $count_series = $count_peso){
      for($i=0;$i<$count_articulo;$i++){
        $guia_remision_registro=new g_remision_registro;
        $guia_remision_registro->producto_id=$producto_id[$i];
        $guia_remision_registro->cantidad=$request->get('cantidad')[$i];
        $guia_remision_registro->numero_serie=$request->get('series')[$i];
        $guia_remision_registro->guia_remision_id=$guia_remision->id;
        $guia_remision_registro->estado=1;
        $guia_remision_registro->peso=$request->get('peso')[$i];
        $guia_remision_registro->save();
      }
    }else{
      return "campos no completados";
    }


    return redirect()->route('guia_remision.show',$guia_remision->id);

  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id){
      $banco_count=Banco::where('estado','0')->count();
      $guia_remision=Guia_remision::find($id);
      $guia_registro=g_remision_registro::where('guia_remision_id',$guia_remision->id)->get();
      $banco=Banco::where('estado','0')->get();
      $empresa=Empresa::first();

      return view('transaccion.venta.guia_remision.print',compact('empresa','banco','guia_remision','guia_registro','banco_count'));

    }
    public function pdf(Request $request,$id){
      $banco_count=Banco::where('estado','0')->count();
      $guia_remision=Guia_remision::find($id);
      $guia_registro=g_remision_registro::where('guia_remision_id',$guia_remision->id)->get();
      $banco=Banco::where('estado','0')->get();
      $empresa=Empresa::first();

     // $archivo=$name.$regla.$id.".pdf";
      $pdf=PDF::loadView('transaccion.venta.guia_remision.pdf',compact('guia_remision','guia_registro','banco','empresa','banco_count'));
      return $pdf->download('GuiaRemision - '.'.pdf');
    }

    public function show($id)
    {
      $banco_count=Banco::where('estado','0')->count();
      $guia_remision=Guia_remision::find($id);
      $guia_registro=g_remision_registro::where('guia_remision_id',$guia_remision->id)->get();
      // $suma_peso=sum($guia_registro->peso);
      // return $suma_peso;
      $banco=Banco::where('estado','0')->get();
      $empresa=Empresa::first();

      return view('transaccion.venta.guia_remision.show',compact('empresa','banco','guia_remision','guia_registro','banco_count'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      return view('transaccion.venta.guia_remision.edit');
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $guia_remision= Guia_remision::find($id);
      $guia_remision->estado_anulado='1';
      $guia_remision->save();
      return redirect()->route('guia_remision.index');
    }

    public function seleccionar()
    {
      $activos=Cotizacion::where('estado_aprovar','1')->get();

      return view('transaccion.venta.guia_remision.selecionar_cotizacion',compact('activos'));

    }
    public function cotizacion($id)
    {

      $cotizacion=Cotizacion::find($id);
      $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
      $cotizacion_registro_boleta=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();

      $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
      foreach ($productos as $index => $producto) {
        $utilidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')*($producto->utilidad-$producto->descuento1)/100;
        $array[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio')+$utilidad[$index];
        $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        $array_promedio[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->avg('precio');
      }

      $clientes=Cliente::all();
      $vehiculo=Vehiculo::where('estado_activo',0)->get();
      $empresa=Empresa::first();
      $igv=Igv::first();
      return view('transaccion.venta.guia_remision.create_2',compact('cotizacion','productos','clientes','array','array_cantidad','igv','array_promedio','empresa','cotizacion_registro','vehiculo','cotizacion_registro_boleta'));
    }


  }