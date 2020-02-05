<?php

namespace App\Http\Controllers;
use App\InventarioInicial;
use App\Producto;
use App\Categoria;
use App\Almacen;
use App\Provedor;
use App\Kardex_entrada;
use App\kardex_entrada_registro;
use Illuminate\Http\Request;

class InventarioInicialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes=Almacen::all();
        $clasificaciones=Categoria::all();
        $inventario_iniciales=InventarioInicial::all();
        $kardex_entradas=Kardex_entrada::where('motivo_id','4')->get();
        return view('inventario.inventario-inicial.index',compact('inventario_iniciales','clasificaciones','almacenes','kardex_entradas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create(Request $request)
    {
        $almacen=$request->get('almacen');
        $clasificacion=$request->get('clasificacion');
        $productos=Producto::all();
        $provedores=Provedor::all();
        return view('inventario.inventario-inicial.create',compact('productos','almacen','clasificacion','provedores'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
                         return "datos repetidos - NO PERMITIDOS" ;
                     }
                 }
 
             }
         }
 
         //Guardado de almacen para inventario-inicial
         $almacen=$request->get('almacen');
 
         //Kardex Entrada Guardado
         $kardex_entrada=new Kardex_entrada();
         $kardex_entrada->motivo_id=$request->get('motivo');
         $kardex_entrada->provedor_id=$request->get('provedor');
         
         $kardex_entrada->categoria_id=$request->get('clasificacion');
         $kardex_entrada->guia_remision=0;
         $kardex_entrada->factura=0;
         $kardex_entrada->almacen_id=$request->get('almacen');
         $kardex_entrada->informacion=$request->get('informacion');
         $kardex_entrada->save();
 
         //contador de valores de cantidad
         $cantidad = $request->input('cantidad');
         $count_cantidad=count($cantidad);
         //contador de valores de precio
         $precio = $request->input('precio');
         $count_precio=count($precio);
 
         if($count_articulo = $count_cantidad = $count_precio){
             for($i=0;$i<$count_articulo;$i++){
                 $kardex_entrada_registro=new kardex_entrada_registro();
                 $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                 $kardex_entrada_registro->producto_id=$request->get('articulo')[$i];
                 $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                 $kardex_entrada_registro->precio=$request->get('precio')[$i];
                 $kardex_entrada_registro->cantidad=$request->get('cantidad')[$i];
                 $kardex_entrada_registro->estado=1;
                 $kardex_entrada_registro->save();
             }
         }else {
             return "Falto introducir un campo";
         }
         return redirect()->route('inventario-inicial.index');
     
        
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
}
