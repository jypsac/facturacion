<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Empresa;
use App\Kardex_entrada;
use App\Motivo;
use App\Producto;
use App\kardex_entrada_registro;
use App\kardex_salida;
use App\kardex_salida_registro;
use App\Stock_producto;
use App\TipoCambio;
use App\Tipo_Registro;
use Carbon\Carbon;
use App\Stock_almacen;
use Illuminate\Http\Request;

class KardexSalidaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kardex_salidas=kardex_salida::all();
        $user_login =auth()->user();
        $conteo_almacen=Almacen::where('estado',0)->count();
        $almacen=Almacen::where('estado',0)->get();
        $almacen_primero=Almacen::where('estado',0)->first();
        // return view('inventario.kardex.salida.index');
        // return $conteo_almacen;
        return view('inventario.kardex.salida.index' ,compact('kardex_salidas','user_login','conteo_almacen','almacen','almacen_primero'));
    }

    public function stock_ajax(Request $request){
        $articulo=$request->get('articulo');
        $almacen=$request->get('almacen');
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
        
        $motivos=Motivo::all();
        $almacenes=Almacen::all();

        return view('inventario.kardex.salida.create',compact('motivos','productos','almacen_nombre','almacenes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $almacen_imput=$request->input('almacen');
        $id=explode(" ",$almacen_imput);
        $almacen_json=Almacen::where('id',$id[1])->first();
        // return $id[];

        // return $request;
        //codigo para convertir nombre a producto
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

        if($count_articulo = $count_cantidad){
            $cantidad = $request->input('cantidad');
            $count_cantidad=count($cantidad);

            $kardex_salida=new Kardex_salida();
            $kardex_salida->motivo_id=$request->get('motivo');
            $kardex_salida->informacion=$request->get('informacion');
            $kardex_salida->estado=1;
            $kardex_salida->save();

            //contador de valores de articulos (re verificacion)
            $articulo = $request->input('articulo');
            $count_articulo=count($articulo);

            $cantidad = $request->input('cantidad');
            $count_cantidad=count($cantidad);

            if($count_articulo = $count_cantidad ){
                for($i=0;$i<$count_articulo;$i++){
                    
                    $kardex_salida_registro=new kardex_salida_registro();
                    $kardex_salida_registro->kardex_salida_id=$kardex_salida->id;
                    $kardex_salida_registro->producto_id=$producto_id[$i];
                    $kardex_salida_registro->cantidad=$request->get('cantidad')[$i];
                    $kardex_salida_registro->save();

                    $comparacion=Kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->where('estado','1')->get();
                    $cantidad=kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->where('estado','1')->sum('cantidad');
                    
                    $almacen=$almacen_json->id;
                    $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen)->get();
                    $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen)->count();

                    //return $kardex_entrada;
                    foreach($kardex_entrada as $kardex_entradas){
                        $kadex_entrada_id[]=$kardex_entradas->id;
                    }
                    // return $kardex_entrada;
                    for($x=0;$x<$kardex_entrada_count;$x++){
                        if(Kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado','1')->first()){
                            $nueva[]=Kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->where('kardex_entrada_id',$kadex_entrada_id[$x])->where('estado','1')->first();
                        }
                    }
                    $comparacion=$nueva;
                    //buble para la cantidad
                    $cantidad=0;
                    foreach($comparacion as $comparaciones){
                        $cantidad=$comparaciones->cantidad+$cantidad;
                    }
                    
                    if(isset($comparacion)){
                        $var_cantidad_entrada=$kardex_salida_registro->cantidad;
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
                    //resta de cantidades de productos para la tabla stock productos
                    $stock_productos=Stock_producto::find($producto_id[$i]);
                    $stock_productos->stock=$stock_productos->stock-$kardex_salida_registro->cantidad;
                    $stock_productos->save();
                    // return $kardex_salida_registro->cantidad;
                    //Resta de stock a productos en Stock Almacen
                    Stock_almacen::egreso($almacen,$producto_id[$i],$kardex_salida_registro->cantidad);
                    
                }   
            }else{
                return "Error fatal: por favor comunicarse con soporte inmediatamente";
            }
        }else{
            return redirect()->route('kardex-salida.create')->with('campo', 'Falto introducir un campo de la tabla productos');
        }
        return redirect()->route('kardex-salida.index');
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
        $kardex_salidas=Kardex_salida::find($id);
        $kardex_salidas_registros=kardex_salida_registro::where('kardex_salida_id',$id)->get();
        return view('inventario.kardex.salida.show',compact('kardex_salidas','kardex_salidas_registros','mi_empresa'));
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
}
