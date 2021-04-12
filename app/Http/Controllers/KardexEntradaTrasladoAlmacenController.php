<?php
namespace App\Http\Controllers;
use App\Almacen;
use App\Categoria;
use App\Empresa;
use App\InventarioInicial;
use App\Kardex_entrada;
use App\Moneda;
use App\Motivo;
use App\Producto;
use App\Provedor;
use App\TipoCambio;
use App\User;
use App\kardex_entrada_registro;
use Carbon\Carbon;
use DB;
use App\Stock_almacen;
use App\Stock_producto;
use App\Observers\KardexEntradaRegistroObserver;
use Illuminate\Http\Request;

class KardexEntradaTrasladoAlmacenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$almacen=Almacen::where('estado',0)->where('id','!=',1)->get();
    	$kardex_distribucion=Kardex_entrada::where('tipo_registro_id',2)->get();

    	return view('inventario.kardex.entrada.traslado_almacen.index',compact('kardex_distribucion','almacen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function stock_ajax_traslado(Request $request){
        // return $request;
        $articulo=$request->get('articulo');
        $almacen=$request->get('almacen_emisor');
        $id=explode(" ",$articulo);

        $almacen_encontrado=Almacen::where('nombre',$almacen)->first();

        // //buscador del almacen perteneciente kardex_entrada
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_encontrado->id)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_encontrado->id)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->get()){
                    $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->where('producto_id',$id[0])->get();
                    foreach( $nueva as $nuevas){
                        $id_kardex_entrada_registro[]=$nuevas->id;
                    }
            }
        }
        $stock=Kardex_entrada_registro::whereIn('id',$id_kardex_entrada_registro)->where('estado',1)->sum('cantidad');
        return $stock;
    }

    public function create(Request $request)
    {
    	$id_almacen_emisor=$request->get('almacen');
    	$almacen_emison=Almacen::where('id',$id_almacen_emisor)->first();


    	// $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();

        $almacen_p=$request->get('almacen');
        $id=explode(" ",$almacen_p);
        $almacen_buscar=Almacen::where('id',$id[0])->first();
        $almacen_nombre=$almacen_buscar->nombre;

        $almacen_p=$id[0];

        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

        foreach($kardex_entrada as $kardex_entradas){
            $kadex_entrada_id[]=$kardex_entradas->id;
        }

        for($x=0;$x<$kardex_entrada_count;$x++){
            if(Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->get()){
                $nueva=Kardex_entrada_registro::where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado',1)->get();
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

    	$almacenes=Almacen::where('estado','0')->where('id','!=',$id_almacen_emisor)->get();
    	$categorias=Categoria::all();
    	$user_login =auth()->user()->id;
    	$usuario=User::where('id',$user_login)->first();

    	return view('inventario.kardex.entrada.traslado_almacen.create',compact('almacenes','productos','categorias','usuario','almacen_emison'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        //ALMACEN
        $almacen_emisor_input=$request->input('almacen_emisor');
        $almacen_emisor_json=Almacen::where('nombre',$almacen_emisor_input)->first();

        $almacen_input=$request->input('almacen');

        $almacen_json=Almacen::where('id',$almacen_input)->first();

        $cantidad_p = $request->input('cantidad');
        $count_cantidad_p=count($cantidad_p);

        $articulo_p = $request->input('articulo');
        $articulo_p=count($articulo_p);

        for($i=0 ; $i<$count_cantidad_p;$i++){
            $articulos[$i]= $request->input('articulo')[$i];
            $producto_id[$i]=strstr($articulos[$i], ' ', true);
        }

        // Validacion para ver si la cantidad es suficiente con lo requerido

        //Primer verificacion de articulos en validacion del if
        $articulo1 = $request->input('articulo');
        $count_articulo1=count($articulo1);

        $cantidad1 = $request->input('cantidad');
        $count_cantidad1=count($cantidad1);

        //validacion para la no incersion de dobles articulos (LOADING)
        for ($e=0; $e < $count_articulo1; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_articulo1 ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial==$articulo_comparacion) {
                        return "dobles articulos error";
                    }
                }
            }
        }

        //Validacion para cantidad
        for ($i=0; $i < $count_articulo1; $i++){
            $articulo_c=$producto_id[$i];
            $cantidad_c=$request->get('cantidad')[$i];
            $almacen_emisor_validacion=$almacen_emisor_json->id;

            $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_emisor_json->id)->get();
            $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_emisor_json->id)->count();

            foreach($kardex_entrada as $kardex_entradas){
                $kardex_entrada_id[]=$kardex_entradas->id;
            }

            $consulta_cantidad=kardex_entrada_registro::where('producto_id',$articulo_c)->where('estado','1')->whereIn('kardex_entrada_id',$kardex_entrada_id)->sum('cantidad');

            if ($cantidad_c > $consulta_cantidad) {
                // return "redirect()->route('kardex-salida.create')->with('cantidad', 'no hay cantidad deseada para el articulos');"
                return "LA CANTIDAD REQUERIDA EXCEDE AL STOCK";
            }
        }

        //buscador al cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }


        $articulo = $request->input('articulo');
        $count_articulo=count($articulo);

        $cantidad= $request->input('cantidad');
        $count_cantidad=count($cantidad);

        //creacion del codigo guia codigo GTA que es para TRASLADO
        $ultima_entrada = Kardex_entrada::where('tipo_registro_id','=','2')->orderby('created_aT','DESC')->first();

        if(isset($ultima_entrada)){
          $numero = substr(strstr($ultima_entrada->codigo_guia, '-'), 1);
          $numero++;
          $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
          $codigo_guia='GTA'.'-'.$cantidad_registro;
        }else{
          $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
          $codigo_guia='GTA'.'-'.$cantidad_registro;
        }

        if($count_articulo = $count_cantidad){
            $cantidad = $request->input('cantidad');
            $count_cantidad=count($cantidad);

            $kardex_entrada=new Kardex_entrada();
            $kardex_entrada->motivo_id=1;
            $kardex_entrada->codigo_guia=$codigo_guia;
            $kardex_entrada->provedor_id=1;
            $kardex_entrada->guia_remision="NN";
            $kardex_entrada->categoria_id='1';
            $kardex_entrada->factura="0";
            $kardex_entrada->almacen_id=$almacen_json->id;
            $kardex_entrada->almacen_emisor_id=$almacen_emisor_json->id;
            $kardex_entrada->almacen_receptor_id=$almacen_json->id;
            $kardex_entrada->moneda_id=1;
            $kardex_entrada->tipo_registro_id=2;
            $kardex_entrada->estado=1;
            $kardex_entrada->user_id=auth()->user()->id;
            $kardex_entrada->informacion="0";
            $kardex_entrada->save();


        }

        if($kardex_entrada->almacen_id==1){

            //envio para el almacen principal
            //estado devvolucion=1
            // envio para otro almacen secundario
            if($count_articulo == $count_cantidad ){

                for($i=0;$i<$count_articulo;$i++){

                    //Creacion del nuevo registro de kardex entrada
                    $kardex_entrada_registro=new kardex_entrada_registro();
                    $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                    $kardex_entrada_registro->producto_id=$producto_id[$i];
                    $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                    $kardex_entrada_registro->precio_nacional=0;
                    $kardex_entrada_registro->precio_extranjero=0;
                    $kardex_entrada_registro->cambio=$cambio->compra;
                    $kardex_entrada_registro->cantidad=0;
                    $kardex_entrada_registro->estado_devolucion=1;
                    $kardex_entrada_registro->estado=0;
                    $kardex_entrada_registro->tipo_registro_id=2;
                    $kardex_entrada_registro->save();

                    $comparacion=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->get();
                    $cantidad=kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->sum('cantidad');

                    $almacen=$almacen_json->id;
                    $kardex_entrada_get=Kardex_entrada::where('almacen_id',$almacen)->get();
                    $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen)->count();

                    foreach($kardex_entrada_get as $kardex_entradas){
                        $kadex_entrada_id[]=$kardex_entradas->id;
                    }

                    for($x=0;$x<$kardex_entrada_count;$x++){
                        if(Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->where('tipo_registro_id',1)->first()){
                            $nueva[]=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->where('tipo_registro_id',1)->first();
                        }
                    }

                    $comparacion=array_reverse($nueva);

                    // return $comparacion;
                    //buble para la cantidad
                    $cantidad_requerida=0;
                        foreach($comparacion as $comparaciones){
                            $cantidad_requerida=$comparaciones->cantidad+$cantidad_requerida;
                        }

                    $cantidad=$request->get('cantidad')[$i];
                    $logica=$request->get('cantidad')[$i];
                    if(isset($comparacion)){
                        $var_cantidad_entrada=$request->get('cantidad')[$i];
                        $contador=0;
                        foreach ($comparacion as $p) {
                            if($p->cantidad+$cantidad<=$p->cantidad_inicial){
                                $p->cantidad=$logica;
                                $p->estado=1;
                                $p->save();
                                break;
                            }else{
                                $logica=$logica-$p->cantidad_inicial+$p->cantidad;
                                $p->cantidad=$p->cantidad_inicial;
                                $p->estado=1;
                                $p->save();
                                continue;
                            }
                        }
                    }

                    $kardex_entrada_j=Kardex_entrada::where('almacen_id',$almacen_emisor_json->id)->get();
                    $kardex_entrada_j_count=Kardex_entrada::where('almacen_id',$almacen_emisor_json->id)->count();

                    foreach($kardex_entrada_j as $kardex_entradas_j){
                        $kardex_entrada_j_id[]=$kardex_entradas_j->id;
                    }

                    for($x=0;$x<$kardex_entrada_j_count;$x++){
                        if(Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kardex_entrada_j_id[$x])->first()){
                            $nueva2[]=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kardex_entrada_j_id[$x])->first();
                        }
                    }

                    $comparacion2=$nueva2;

                    $cantidad2=0;
                    foreach($comparacion2 as $comparaciones2){
                        $cantidad2=$comparaciones2->cantidad+$cantidad2;
                    }

                    if(isset($comparacion2)){
                        $var_cantidad_entrada2=$request->get('cantidad')[$i];
                        $contador=0;
                        foreach ($comparacion2 as $e) {
                            if($e->cantidad>$var_cantidad_entrada2){
                                $cantidad_mayor2=$e->cantidad;
                                $cantidad_final2=$cantidad_mayor2-$var_cantidad_entrada2;
                                $e->cantidad=$cantidad_final2;
                                if($cantidad_final2==0){
                                    $e->estado=0;
                                    $e->save();
                                    break;
                                }else{
                                    $e->save();
                                    break;
                                }
                            }elseif($e->cantidad==$var_cantidad_entrada2){
                                $e->cantidad=0;
                                $e->estado=0;
                                $e->save();
                                break;
                            }
                            else{
                                $var_cantidad_entrada2=$var_cantidad_entrada2-$e->cantidad;
                                $e->cantidad=0;
                                $e->estado=0;
                                $e->save();
                            }

                        }
                    }
                    $cant = $request->get('cantidad')[$i];
                    Stock_almacen::ingreso(1,$producto_id[$i],$cant);
                    Stock_almacen::egreso($almacen_emisor_json->id,$producto_id[$i],$cant);
                }
                kardex_entrada_registro::stock_producto_precio();
            }else{
                return "Error fatal: por favor comunicarse con soporte inmediatamente";
            }
        }else{
            // envio para otro almacen secundario
            if($count_articulo = $count_cantidad ){
                for($i=0;$i<$count_articulo;$i++){
                    //Creacion del nuevo registro de kardex entrada
                    $kardex_entrada_registro=new kardex_entrada_registro();
                    $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                    $kardex_entrada_registro->producto_id=$producto_id[$i];
                    $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                    $kardex_entrada_registro->precio_nacional=0;
                    $kardex_entrada_registro->precio_extranjero=0;
                    $kardex_entrada_registro->cambio=$cambio->compra;
                    $kardex_entrada_registro->cantidad=$request->get('cantidad')[$i];
                    $kardex_entrada_registro->estado_devolucion=0;
                    $kardex_entrada_registro->estado=1;
                    $kardex_entrada_registro->save();

                    $comparacion=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->get();
                    $cantidad=kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->sum('cantidad');

                    $almacen=$almacen_json->id;

                    $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_emisor_json->id)->get();
                    $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_emisor_json->id)->count();

                    foreach($kardex_entrada as $kardex_entradas){
                        $kadex_entrada_id[]=$kardex_entradas->id;
                    }
                    // return $kardex_entrada;
                    for($x=0;$x<$kardex_entrada_count;$x++){
                        if(Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->first()){
                            $nueva[]=Kardex_entrada_registro::where('producto_id',$kardex_entrada_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->first();
                        }
                    }

                    $comparacion=$nueva;
                    //buble para la cantidad
                    $cantidad=0;

                    // return $comparacion;
                    foreach($comparacion as $comparaciones){
                        $cantidad=$comparaciones->cantidad+$cantidad;
                    }

                    if(isset($comparacion)){
                        $var_cantidad_entrada=$kardex_entrada_registro->cantidad;
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
                    $cant = $request->get('cantidad')[$i];
                    Stock_almacen::ingreso($almacen_json->id,$producto_id[$i],$cant);
                    Stock_almacen::egreso($almacen_emisor_json->id,$producto_id[$i],$cant);
                }
            kardex_entrada_registro::stock_producto_precio();
              }else{
                  return "Error fatal: por favor comunicarse con soporte inmediatamente";
              }
        }
        // modificacion para la nueva store para los 2 apartados de traslado de almacen
        return redirect()->route('kardex-entrada-Traslado-almacen.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$mi_empresa=Empresa::first();
    	$moneda_nacional=Moneda::where('id','1')->first();
    	$moneda_extranjera=Moneda::where('id','2')->first();
    	$kardex_entradas=Kardex_entrada::find($id);
    	$kardex_entradas_registros=kardex_entrada_registro::where('kardex_entrada_id',$id)->get();
    	return view('inventario.kardex.entrada.traslado_almacen.show',compact('kardex_entradas','kardex_entradas_registros','mi_empresa','moneda_nacional','moneda_extranjera'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
    public function destroy(Request $request, $id)
    {


    }

}
