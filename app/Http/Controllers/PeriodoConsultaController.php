<?php

namespace App\Http\Controllers;
use App\PeriodoConsulta_registro;
use App\PeriodoConsulta;
use App\kardex_entrada;
use App\kardex_entrada_registro;
use App\Almacen;
use App\Empresa;
use App\Igv;
use App\Moneda;
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
                    $kardex_entrada_registros=kardex_entrada_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo_registro_id',1)->get();
                }else{
                    $kardex_entrada_registros=kardex_entrada_registro::where('almacen_id',$almacen)->where('tipo_registro_id',1)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->get();
                }
                if(count($kardex_entrada_registros) == 0){
                    $json = [];
                    goto fin_kardex;
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
                        $kardex_entrada_r_cantidad_inicial=kardex_entrada_registro::where('producto_id',$array_unico_productos[$a])->where('tipo_registro_id',1)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad_inicial');

                        $kardex_entrada_r_precio_nacional=kardex_entrada_registro::where('producto_id',$array_unico_productos[$a])->where('tipo_registro_id',1)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_nacional');

                        $kardex_entrada_r_precio_extranjero=kardex_entrada_registro::where('producto_id',$array_unico_productos[$a])->where('tipo_registro_id',1)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_extranjero');
                    }else{
                        $kardex_entrada_r_cantidad_inicial=kardex_entrada_registro::where('almacen_id',$almacen)->where('tipo_registro_id',1)->where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('cantidad_inicial');

                        $kardex_entrada_r_precio_nacional=kardex_entrada_registro::where('almacen_id',$almacen)->where('tipo_registro_id',1)->where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_nacional');

                        $kardex_entrada_r_precio_extranjero=kardex_entrada_registro::where('almacen_id',$almacen)->where('tipo_registro_id',1)->where('producto_id',$array_unico_productos[$a])->whereBetween('created_at',[$fecha_inicio,$fecha_final])->sum('precio_extranjero');
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
                fin_kardex:
            }else{
                $json=[];
            }
        }elseif($categoria=="2"){
            $json=[];
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
        $moneda_nac = Moneda::where('tipo','nacional')->first();
        $moneda_ex = Moneda::where('tipo','extranjera')->first();
        if($categoria=="1"){
            // falta validacion si $request->consulta_p es un numero del 1 al 3
            $consulta=$request->consulta_p;

            if($consulta=="2" or $consulta=="3"){
                $productos = Producto::whereBetween('tipo_afectacion_id', [1,8])->pluck('id');
                $factura_registro =Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('producto_id',$productos)->get();
                $boleta_registro = Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('producto_id',$productos)->get();
            if(count($factura_registro) == 0){
                $data_fac =[];
                goto fact_fin_aj;
            }
            //FACTURA
            foreach ($factura_registro as $f_reg) {
                if($almacen == 0){
                    $factura = Facturacion::where('id',$f_reg->facturacion_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->first();
                }else{
                    $factura = Facturacion::where('id',$f_reg->facturacion_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('almacen_id',$almacen)->first();
                }
                //MONEDA NACIONAL
                if($factura->moneda_id == $moneda_nac->id){
                    $f_reg_pre_nac = $f_reg->precio_unitario_comi;
                    $f_reg_pre_ex = number_format(round($f_reg->precio_unitario_comi/$factura->cambio,1),2);
                }else{
                    $f_reg_pre_nac = number_format(round($f_reg->precio_unitario_comi*$factura->cambio, 1, PHP_ROUND_HALF_UP),2);
                    $f_reg_pre_ex = $f_reg->precio_unitario_comi;
                }
                // $cant_fact_pro =
                $prod_fact[] = $f_reg->producto->nombre;
                $data_extra_f[]=array('tipo' => 'Factura' ,'producto' => $f_reg->producto->nombre ,'cantidad' => $f_reg->cantidad  ,'precio nacional' => $f_reg_pre_nac, 'precio extranjero' => $f_reg_pre_ex);

            }
            $uniq_prod_fac =   array_unique($prod_fact);

            $data_fact =  $data_extra_f;

            foreach ($uniq_prod_fac as  $prods_fac ) {
                foreach ($data_fact as  $value_fac) {
                    // return $value;
                    if( $prods_fac == $value_fac['producto'] ){
                        $cantidad_fac[] = $value_fac['cantidad'];
                        $precio_nac_total_fac[] =   $value_fac['precio nacional'];
                        $precio_ex_total_fac[] =   $value_fac['precio extranjero'];
                    }
                }

                $data_final_fac[] = array('tipo' => 'Factura' ,'producto' => $prods_fac,'precio nacional' => array_sum($precio_nac_total_fac) ,'cantidad' => array_sum($cantidad_fac)  ,'precio extranjero' =>array_sum($precio_ex_total_fac) );
                unset($precio_nac_total_fac);
                unset($precio_ex_total_fac);
                unset($cantidad_fac);
            }
            $data_fac = $data_final_fac;
            fact_fin_aj:
            // return $data_final_fac;
            if(count($boleta_registro) == 0){
                $data_bol =[];
                goto bol_fin_aj;
            }
            //BOLETA
            foreach ($boleta_registro as $b_reg) {
                if($almacen == 0){
                    $boleta = Boleta::where('id',$b_reg->boleta_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->first();
                }else{
                    $boleta = Boleta::where('id',$b_reg->boleta_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('almacen_id',$almacen)->first();
                }


                if($boleta->moneda_id == $moneda_nac->id){
                    $b_reg_pre_nac = $b_reg->precio_unitario_comi;
                    $b_reg_pre_ex = number_format(round($b_reg->precio_unitario_comi/$boleta->cambio,1),2);
                }else{
                    $b_reg_pre_nac = number_format(round($b_reg->precio_unitario_comi*$boleta->cambio, 1, PHP_ROUND_HALF_UP),2);
                    $b_reg_pre_ex = $b_reg->precio_unitario_comi;
                }
                $prod_bol[] = $b_reg->producto->nombre;
                $data_extra_b[] = array('tipo'=> 'Boleta' ,'producto' => $b_reg->producto->nombre,'cantidad' => $b_reg->cantidad  ,'precio nacional' => $b_reg_pre_nac, 'precio extranjero' => $b_reg_pre_ex);
            }
            $uniq_prod_bol =   array_unique($prod_bol);

            $data_bol =  $data_extra_b;

            // return $data_bol;
            foreach ($uniq_prod_bol as  $prods_bol ) {
                foreach ($data_bol as  $value_bol) {
                    // return $value_bol['productos'];
                    if( $prods_bol == $value_bol['producto'] ){
                        $cantidad_bol[] = $value_bol['cantidad'];
                        $precio_nac_total_bol[] =   $value_bol['precio nacional'];
                        $precio_ex_total_bol[] =   $value_bol['precio extranjero'];
                    }
                }

                $data_final_bol[] = array('tipo' => 'Boleta' ,'producto' => $prods_bol, 'cantidad' => array_sum($cantidad_bol) ,'precio nacional' => round(array_sum($precio_nac_total_bol),2) ,'precio extranjero' =>array_sum($precio_ex_total_bol) );
                unset($precio_nac_total_bol);
                unset($precio_ex_total_bol);
                unset($cantidad_bol);
            }
            $data_bol = $data_final_bol;
            bol_fin_aj:
                //union de jsons
                $json=array_merge($data_fac,$data_bol);
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
        $moneda_nac = Moneda::where('tipo','nacional')->first();
        $moneda_ex = Moneda::where('tipo','extranjera')->first();
        $empresa = Empresa::first();
        $igv = Igv::first();
        $igv_t = $igv->igv_total;
        $almacen=$request->almacen;
        $fecha_inicio=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_inicio);
        $fecha_final=Carbon::createFromFormat('Y-m-d\TH:i',$request->fecha_final);
        $categoria=$request->categoria;
        $consulta = $request->consulta_p;
        $jsons = 1;
        if($consulta == "1" or $consulta == "3"){
            if($almacen==0){
                $kardex_entrada_registros=kardex_entrada_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo_registro_id',1)->get();
            }else{
                $kardex_entrada_registros=kardex_entrada_registro::where('almacen_id',$almacen)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('tipo_registro_id',1)->get();
            }

            if (count($kardex_entrada_registros) == 0) {
                
                goto salto_kard_ent;
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
            
            $productos=$kardex_entrada_r;
            // return $productos;
            salto_kard_ent:
        }
        if($consulta == "2" or $consulta == "3" ){

            $cantidad_inicial=0;
            $precio_nacional=0;
            $precio_extranjero=0;
            // if($almacen == 0){
                $prod_k_e = Producto::whereBetween('tipo_afectacion_id', [1,8])->pluck('id');
                $factura_registro =Facturacion_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('producto_id',$prod_k_e)->get();
                $boleta_registro = Boleta_registro::whereBetween('created_at',[$fecha_inicio,$fecha_final])->whereIn('producto_id',$prod_k_e)->get();
                // return count($boleta_registro);
            if (count($factura_registro) == 0 && count($boleta_registro) == 0  ) {

                goto salto_fc_factura;
            }


            //FACTURA
            foreach ($factura_registro as $f_reg) {
                if($almacen == 0){
                    $factura = Facturacion::where('id',$f_reg->facturacion_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->first();
                }else{
                    $factura = Facturacion::where('id',$f_reg->facturacion_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('almacen_id',$almacen)->first();
                }
                //MONEDA NACIONAL
                if($factura->moneda_id == $moneda_nac->id){
                    $f_reg_pre_nac = $f_reg->precio_unitario_comi;
                    $f_reg_pre_ex = number_format(round($f_reg->precio_unitario_comi/$factura->cambio,1),2);
                }else{
                    $f_reg_pre_nac = number_format(round($f_reg->precio_unitario_comi*$factura->cambio, 1, PHP_ROUND_HALF_UP),2);
                    $f_reg_pre_ex = $f_reg->precio_unitario_comi;
                }
                // $cant_fact_pro = 
                $prod_fact[] = $f_reg->producto->nombre;
                $data_extra_f[]=array('tipo' => 'Factura' ,'producto' => $f_reg->producto->nombre ,'cantidad' => $f_reg->cantidad  ,'precio nacional' => $f_reg_pre_nac, 'precio extranjero' => $f_reg_pre_ex);

            } 
            $uniq_prod_fac =   array_unique($prod_fact);

            $data_fact =  $data_extra_f;
            
            foreach ($uniq_prod_fac as  $prods_fac ) {
                foreach ($data_fact as  $value_fac) {
                    // return $value;
                    if( $prods_fac == $value_fac['producto'] ){
                        $cantidad_fac[] = $value_fac['cantidad'];
                        $precio_nac_total_fac[] =   $value_fac['precio nacional'];       
                        $precio_ex_total_fac[] =   $value_fac['precio extranjero'];      
                    }
                }
                
                $data_final_fac[] = array('tipo' => 'Factura' ,'producto' => $prods_fac,'precio nacional' => array_sum($precio_nac_total_fac) ,'cantidad' => array_sum($cantidad_fac)  ,'precio extranjero' =>array_sum($precio_ex_total_fac) );
                unset($precio_nac_total_fac);
                unset($precio_ex_total_fac);
                unset($cantidad_fac);
            }
            $data_final_fac= $data_final_fac;
            salto_fc_factura:
            // return $data_final_fac;

            //BOLETA
            if (count($boleta_registro) == 0  ) {

                goto salto_fc_boleta;
            }

            foreach ($boleta_registro as $b_reg) {
                if($almacen == 0){
                    $boleta = Boleta::where('id',$b_reg->boleta_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->first();
                }else{
                    $boleta = Boleta::where('id',$b_reg->boleta_id)->whereBetween('created_at',[$fecha_inicio,$fecha_final])->where('almacen_id',$almacen)->first();
                }


                if($boleta->moneda_id == $moneda_nac->id){
                    $b_reg_pre_nac = $b_reg->precio_unitario_comi;
                    $b_reg_pre_ex = number_format(round($b_reg->precio_unitario_comi/$boleta->cambio,1),2);
                }else{
                    $b_reg_pre_nac = number_format(round($b_reg->precio_unitario_comi*$boleta->cambio, 1, PHP_ROUND_HALF_UP),2);
                    $b_reg_pre_ex = $b_reg->precio_unitario_comi;
                }
                $prod_bol[] = $b_reg->producto->nombre;
                $data_extra_b[] = array('tipo'=> 'Boleta' ,'producto' => $b_reg->producto->nombre,'cantidad' => $b_reg->cantidad  ,'precio nacional' => $b_reg_pre_nac, 'precio extranjero' => $b_reg_pre_ex);
            } 
            $uniq_prod_bol =   array_unique($prod_bol);

            $data_bol =  $data_extra_b;
            
            // return $data_bol;
            foreach ($uniq_prod_bol as  $prods_bol ) {
                foreach ($data_bol as  $value_bol) {
                    // return $value_bol['productos'];
                    if( $prods_bol == $value_bol['producto'] ){
                        $cantidad_bol[] = $value_bol['cantidad'];
                        $precio_nac_total_bol[] =   $value_bol['precio nacional'];       
                        $precio_ex_total_bol[] =   $value_bol['precio extranjero'];      
                    }
                }
                
                $data_final_bol[] = array('tipo' => 'Boleta' ,'producto' => $prods_bol,'precio nacional' => array_sum($precio_nac_total_bol) , 'cantidad' => array_sum($cantidad_bol) ,'precio extranjero' =>array_sum($precio_ex_total_bol) );
                unset($precio_nac_total_bol);
                unset($precio_ex_total_bol);
                unset($cantidad_bol);
            }
            $data_final_bol = $data_final_bol;
            salto_fc_boleta:
        }

        // return view('inventario.periodo-consulta.show_pdf',compact('fecha_inicio','fecha_final','almacen','empresa','igv','productos','consulta','data_final_fac','data_final_bol','moneda_ex','moneda_nac','total_producto_k_e'));
        $archivo="Periodo - Consulta";
        $pdf=PDF::loadView('inventario.periodo-consulta.show_pdf',compact('fecha_inicio','fecha_final','almacen','empresa','igv','productos','consulta','data_final_fac','data_final_bol','moneda_ex','moneda_nac','total_producto_k_e'));
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
