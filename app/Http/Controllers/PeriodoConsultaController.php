<?php

namespace App\Http\Controllers;
use App\PeriodoConsulta_registro;
use App\PeriodoConsulta;
use App\kardex_entrada;
use App\kardex_entrada_registro;
use App\Almacen;
use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro;
use App\Categoria;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Illuminate\Http\Request;

class PeriodoConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $periodo_consultas=PeriodoConsulta::all();
        // return view('inventario.periodo-consulta.index',compact('periodo_consultas'));
        $categorias=Categoria::all();
        $almacenes=Almacen::all();
        return view('inventario.periodo-consulta.index',compact('almacenes','categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias=Categoria::all();
        $almacenes=Almacen::all();
        return view('inventario.periodo-consulta.create',compact('almacenes','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajax_periodo(Request $request){
        // consultas
        // 1 = Compra 
        // 2 = Venta 
        // 3 = Compara y venta
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        if($categoria=="1"){
            // falta validacion si $request->consulta_p es un numero del 1 al 3
            $consulta=$request->consulta_p;
            if($consulta=="1"){
                //productos + compra------------------------------------------
                $kardex_entrada_registro=kardex_entrada_registro::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                if (!isset($kardex_entrada_registro)) {
                    $kardex_entrada_registro[]="";
                }
                $json=$kardex_entrada_registro;
            }elseif($consulta=="2"){
                //productos + venta ------------------------------------------
                    //facturacion
                $facturaciones=Facturacion::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                foreach($facturaciones as $facturacion){
                    $factura_id[]=$facturacion->id;
                }
                if (!isset($factura_id)) {
                    $factura_id[]="";
                }

                $factura= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->get();
                    //boleta
                $boletas=Boleta::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                foreach($boletas as $boleta){
                    $boleta_id[]=$boleta->id;
                }
                if (!isset($boleta_id)) {
                    $boleta_id[]="";
                }

                $boleta= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->get();

                //union de jsons
                $json=array_merge(json_decode($factura, true),json_decode($boleta, true));
            }else{
                //productos + compra + venta ------------------------------------------

                //productos + compra
                $kardex_entarda_registro=kardex_entrada_registro::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();

                //productos + venta
                    //facturacion
                $facturaciones=Facturacion::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                foreach($facturaciones as $facturacion){
                    $factura_id[]=$facturacion->id;
                }
                if (!isset($factura_id)) {
                    $factura_id[]="";
                }

                $factura= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->get();
                    //boleta
                $boletas=Boleta::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                foreach($boletas as $boleta){
                    $boleta_id[]=$boleta->id;
                }
                if (!isset($boleta_id)) {
                    $boleta_id[]="";
                }

                $boleta= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->get();

                //union de jsons
                $json=array_merge(json_decode($kardex_entarda_registro, true),json_decode($factura, true),json_decode($boleta, true));

            }
        }elseif($categoria=="2"){
            $consulta=2;
            return "este es servicio";
        }else{
            return "categoria incorrecta";
        }
        
        return response(json_encode($json),200)->header('content-type','text/plain');

    }

    public function store(Request $request)
    {
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function pdf(Request $request){
        return $request;
        // $contacto = Contacto::all();
        // $mi_empresa=Empresa::first();
        // $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
          // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
          // $pdf=App::make('dompdf.wrapper');
          // $pdf=loadView('welcome').;
        $archivo="123";
        $pdf=PDF::loadView('inventario.periodo-consulta.show_pdf');
              // return $pdf->download();
              return "hola";
        return $pdf->download('Periodo consulta - '.$archivo.' .pdf');
  
        // return view('inventario.periodo-consulta.',compact('garantia_guia_ingreso','mi_empresa'));
  
      }

    //   public function print(Request $request){
    //     $mi_empresa=Empresa::first();
    //     $contacto = Contacto::all();
    //     $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
    //     return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa','contacto'));
    //   }
}
