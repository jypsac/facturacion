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
        $id=explode(" ",$articulo);
        $producto=kardex_entrada_registro::where('producto_id',$id[0])->where('estado',1)->sum('cantidad');
        return $producto;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $almacen_p=$request->get('almacen');
        $almacen_buscar=Almacen::find($almacen_p)->first();
        $almacen_nombre=$almacen_buscar->nombre;
        // return $almacen_nombre;
        $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
        $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

        //return $kardex_entrada;
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
        // foreach ($productos as  $producto) {
        //     $array_cantidad[]=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        // }

        $motivos=Motivo::all();
        $almacenes=Almacen::all();

        // $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
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

        //validando si los almacenes no son los mismos y el motivo
        $motivo=$request->get('motivo');

        if($motivo==6){
            $almacen_traslado=$request->input('almacen_trasladar');
            $almacen_nombre=$request->input('almacen');
            $almacen=Almacen::where('nombre',$almacen_nombre)->first();
            if ($almacen_traslado==$almacen->nombre){
                return $almacen_traslado;
            }
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

                    $comparacion=Kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->get();
                    $cantidad=kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->sum('cantidad');

                    
                    //Descontando en la tabla stock productos
                    $producto_stock=Stock_producto::where('producto_id',$producto_id[$i])->first();
                    
                    //verificando si el motivo no es un traslado y decidiendo el tipo de registro
                    $motivo=$kardex_salida->motivo_id;
                    if($almacen->id !=1 && $almacen_traslado = 1){
                        $tipo_registro=2;
                        $devolucion=1;
                        $tipo_de_registro=1;
                    }else if($almacen_traslado!=1 && $almacen->id=1){
                        $tipo_registro=3;
                        $devolucion=0;
                        $tipo_de_registro=2;
                    } else if($almacen->id !=1 && $almacen_traslado != 1){
                        $tipo_registro=2;
                        $devolucion=0;
                        $tipo_de_registro=3;
                    }

                    if($motivo==6){
                        //Kardex Entrada Guardado
                        // $kardex_entrada=new Kardex_entrada();
                        // $kardex_entrada->motivo_id=$kardex_salida->motivo_id;
                        // $kardex_entrada->codigo_guia="TRASLADO";
                        // //CREAR UN PROVEDOR ESCLUSIVO PARA LOS TRASLADOS
                        // $kardex_entrada->provedor_id="1";
                        // $kardex_entrada->guia_remision="00000";
                        // $kardex_entrada->categoria_id='1';
                        // $kardex_entrada->factura="T00-00000";
                        // $kardex_entrada->almacen_id=$almacen_traslado;
                        // $kardex_entrada->moneda_id=1;
                        // $kardex_entrada->estado=1;
                        // $kardex_entrada->user_id=auth()->user()->id;
                        // $kardex_entrada->informacion=$request->get('informacion');
                        // $kardex_entrada->save();

                        // $buscador=Kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->where('estado',1)->reverse()->values();
                        
                        $almacen_p=$almacen->id;
                        $almacen_buscar=Almacen::find($almacen_p)->first();

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
                        return $prod;
                        
                        switch ($tipo_de_registro) {
                            case 1:
                                
                                break;
                            case 2:
                                
                                break;
                            case 3:
                                
                                break;
                        }

                        // $almacen_nombre=$almacen_buscar->nombre;
                        

                        

                        return $kadex_entrada_id;

                        $buscadores=Kardex_entrada_registro::where('producto_id',$kardex_salida_registro->producto_id)->where('estado',1)->latest()->get();
                        

                        foreach($buscadores as $buscador){
                            $cantidad=$request->get('cantidad')[$i];

                                $almacen_p=$request->get('almacen');
                                $almacen_buscar=Almacen::find($almacen_p)->first();
                                $almacen_nombre=$almacen_buscar->nombre;
                                // return $almacen_nombre;
                                $kardex_entrada=Kardex_entrada::where('almacen_id',$almacen_p)->get();
                                $kardex_entrada_count=Kardex_entrada::where('almacen_id',$almacen_p)->count();

                                //return $kardex_entrada;
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

                        }
                        $kardex_entrada_registro=new kardex_entrada_registro();
                        $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                        $kardex_entrada_registro->producto_id=$producto_id[$i];
                        $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                        $kardex_entrada_registro->precio_nacional=0;
                        $kardex_entrada_registro->precio_extranjero=0;
                        $kardex_entrada_registro->cantidad=0;
                        $kardex_entrada_registro->cambio=$cambio->venta;
                        $kardex_entrada_registro->estado=1;
                        $kardex_entrada_registro->estado_devolucion=$devolucion;
                        $kardex_entrada_registro->tipo_registro_id=$tipo_registro;
                        $kardex_entrada_registro->save();
                          
                    }else{
                        if(isset($comparacion)){
                            $var_cantidad_entrada=$kardex_salida_registro->cantidad;
                            $contador=0;
                            foreach ($comparacion as $p) {
                                if($p->cantidad>=$var_cantidad_entrada){
                                    $cantidad_mayor=$p->cantidad;
                                    $cantidad_final=$cantidad_mayor-$var_cantidad_entrada;
                                    $p->cantidad=$cantidad_final;
                                    if($cantidad_final<=0){
                                        $p->estado=0;
                                        $p->save();
                                    }else{
                                        $p->save();
                                    }
                                }else{
                                    $var_cantidad_entrada=$var_cantidad_entrada-$p->cantidad;
                                    $p->cantidad=0;
                                    $p->estado=0;
                                    $p->save();
                                }
                            }
                        }
                        //resta de cantidades de productos para la tabla stock productos
                        $stock_productos=Stock_producto::find($producto_stock->id);
                        $stock_productos->stock=$stock_productos->stock-$kardex_salida_registro->cantidad;
                        $stock_productos->save();
                    }
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
