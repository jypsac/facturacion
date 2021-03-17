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
use App\Stock_producto;
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
        //ALMACEN
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

        //validacion para la no incersion de dobles articulos
        for ($e=0; $e < $count_articulo1; $e++){
            $articulo_comparacion_inicial=$request->get('articulo')[$e];
            for ($a=0; $a< $count_articulo1 ; $a++) {
                if ($a==$e) {
                    $a++;
                }else {
                    $articulo_comparacion=$request->get('articulo')[$a];
                    if ($articulo_comparacion_inicial=$articulo_comparacion) {
                        return redirect()->route('kardex-salida.create')->with('repite', 'Datos repetidos - No permitidos!');
                    }
                }
            }
        }

        //Validacion para cantidad
        for ($i=0; $i < $count_articulo1; $i++){
            $articulo_c=$producto_id[$i];
            $cantidad_c=$request->get('cantidad')[$i];
            $consulta_cantidad=kardex_entrada_registro::where('producto_id',$articulo_c)->where('estado','1')->sum('cantidad');
            if ($cantidad_c > $consulta_cantidad) {
                return redirect()->route('kardex-salida.create')->with('cantidad', 'no hay cantidad deseada para el articulos');
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

        //creacion del codigo guia
        
        // modificacion para la nueva store para los 2 apartados de traslado de almacen
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
