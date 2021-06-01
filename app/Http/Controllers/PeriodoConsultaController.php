<?php

namespace App\Http\Controllers;
use App\PeriodoConsulta_registro;
use App\PeriodoConsulta;
use App\kardex_entrada;
use App\kardex_entrada_registro;
use App\Almacen;
use App\Empresa;
use App\Igv;
use App\Facturacion;
use App\Facturacion_registro;
use App\Boleta;
use App\Boleta_registro;
use App\Categoria;
use App\Producto;
use Carbon\Carbon;
use App\Provedor;
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
            if($consulta=="1" or $consulta=="3"){
                //productos + compra------------------------------------------
                if($almacen==0){
                    $kardex_entrada_registros=kardex_entrada_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                }else{
                    $kardex_entrada_registros=kardex_entrada_registro::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                }

                $cantidad_inicial=0;
                $precio_nacional=0;
                $precio_extranjero=0;
                foreach($kardex_entrada_registros as $kardex_entrada_registro_f){
                    $producto_id[]=$kardex_entrada_registro_f->producto_id;
                }
                $array_unico_productos=array_values(array_unique($producto_id));


                $contador_prod=count($array_unico_productos);

                for($a=0;$a<$contador_prod;$a++){
                    $producto=Producto::where('id',$array_unico_productos[$a])->first();
                    if($almacen==0){
                        $kardex_entrada_r_cantidad_inicial=kardex_entrada_registro::where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad_inicial');

                        $kardex_entrada_r_precio_nacional=kardex_entrada_registro::where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_nacional');

                        $kardex_entrada_r_precio_extranjero=kardex_entrada_registro::where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_extranjero');
                    }else{
                        $kardex_entrada_r_cantidad_inicial=kardex_entrada_registro::where('almacen_id',$almacen)->where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad_inicial');

                        $kardex_entrada_r_precio_nacional=kardex_entrada_registro::where('almacen_id',$almacen)->where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_nacional');

                        $kardex_entrada_r_precio_extranjero=kardex_entrada_registro::where('almacen_id',$almacen)->where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_extranjero');
                    }
                    $cantidad_inicial=$cantidad_inicial+$kardex_entrada_r_cantidad_inicial;
                    $precio_nacional=$precio_nacional+$kardex_entrada_r_precio_nacional;
                    $precio_extranjero=$precio_extranjero+round($kardex_entrada_r_precio_extranjero,2);

                    $kardex_entrada_r[$a]=array("producto" => $producto->nombre, "cantidad_inicial" => $kardex_entrada_r_cantidad_inicial , "precio_nacional" => $kardex_entrada_r_precio_nacional, "precio_extranjero" => round($kardex_entrada_r_precio_extranjero,2));
                }
                //suma para los totales
                $kardex_entrada_r[$contador_prod]=array("producto" => "Total", "cantidad_inicial" => $cantidad_inicial , "precio_nacional" => $precio_nacional, "precio_extranjero" => round($precio_extranjero,2));

                if (!isset($kardex_entrada_r)) {
                    $kardex_entrada_r[]="";
                }
                $json=$kardex_entrada_r;
            }else{
                $json=[];
            }
        }elseif($categoria=="2"){
            $consulta=2;
            return "este es servicio";
        }else{
            return "categoria incorrecta";
        }

        return response(json_encode($json),200)->header('content-type','text/plain');

    }

    public function ajax_periodo_ventas(Request $request){
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

            if($consulta=="2" or $consulta=="3"){
                if($almacen==0){
                    $factura= Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    $boleta= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();

                    //factura
                    $cantidad_f=Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad');
                    $precio_f=Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio');
                    $stock_f=Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('stock');

                    //boleta
                    $cantidad_b=Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad');
                    $precio_b=Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio');
                    $stock_b=Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('stock');
                }else{
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

                    $cantidad=Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('cantidad')+Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('cantidad');
                    $precio=Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('cantidad')+Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('precio');
                    $stock=Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('cantidad')+Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('facturacion_id',$factura_id)->sum('stock');
                    $data_extra_f[]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);

                    //boleta
                    $boletas=Boleta::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                    foreach($boletas as $boleta){
                        $boleta_id[]=$boleta->id;
                    }
                    if (!isset($boleta_id)) {
                        $boleta_id[]="";
                    }

                    $boleta= Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->get();
                    $cantidad=Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('cantidad');
                    $precio=Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('precio');
                    $stock=Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('cantidad')+Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('boleta_id',$boleta_id)->sum('stock');
                    $data_extra_b[]=array('id' => $jsons+1,'fecha_compra' => "Total",'codigo_guia' => "",'provedor_id'=>"", 'factura'=>"" , 'subtotal' => $subtotal , 'igv' => $igv_t , 'precio_nacional_total'=>$total);
                }


                //union de jsons
                $json=array_merge(json_decode($factura, true),json_decode($boleta, true));
            }else{
                $json=[];
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
        // consultas
        // 1 = Compra
        // 2 = Venta
        // 3 = Compara y venta
        $empresa = Empresa::first();
        $igv = Igv::first();
        $igv_t = $igv->igv_total;
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        $consulta = $request->consulta_p;
        $jsons = 1;
        // return $request;
        // return $consulta;
        if($consulta == "2" or $consulta == "3" or $consulta == "1" ){
            if($almacen == 0){
                $kardex_entrada =  kardex_entrada::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
            }else{
                $kardex_entrada =  kardex_entrada::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('almacen_id',$almacen)->get();
            }
        // }else{
            if($almacen == 0){
                $factura = Facturacion::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                // $fac_count = count($factura);
                foreach($factura as $facturacion){
                    $factura_reg_precio = Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('precio_unitario_comi');
                    $factura_reg_cant = Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('facturacion_id',$facturacion->id)->sum('cantidad');
                    $data_extra_f[]=array('id' => $facturacion->created_at,'codigo_guia'=>$facturacion->codigo_fac,'tipo'=> 'Factura','cantidad'=>$factura_reg_cant,'precio'=>$factura_reg_precio);
                }
                //BOLETAS
                $boleta = Boleta::whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();

                foreach ($boleta as $boleta_reg) {
                    $boleta_reg_precio = Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('precio_unitario_comi');
                    $boleta_reg_cant = Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('boleta_id',$boleta_reg->id)->sum('cantidad');
                    $data_extra_b[]=array('id' => $boleta_reg->created_at,'codigo_guia'=>$boleta_reg->codigo_boleta,'tipo'=> 'Boleta','cantidad'=>$boleta_reg_cant,'precio'=>$boleta_reg_precio);
                }

                // if(!isset($data_extra_f)){
                //     $json=$data_extra_f;
                // }if(!isset($data_extra_b)){
                //     $json=$data_extra_b;
                // }else{
                //     $json=array_merge($data_extra_f,$data_extra_b);
                // }
            }
        }
        // return view('inventario.periodo-consulta.show_pdf',compact('fecha_inicio','fecha_final','almacen','empresa','igv','kardex_entrada','consulta','json'));
        $archivo="Periodo - Consulta";
        $pdf=PDF::loadView('inventario.periodo-consulta.show_pdf',compact('fecha_inicio','fecha_final','almacen','empresa','igv','kardex_entrada','consulta','data_extra_f','data_extra_b'));
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
