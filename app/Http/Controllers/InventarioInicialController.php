<?php

namespace App\Http\Controllers;
use App\Almacen;
use App\Categoria;
use App\InventarioInicial;
use App\Kardex_entrada;
use App\Moneda;
use App\Producto;
use App\Provedor;
use App\TipoCambio;
use App\kardex_entrada_registro;
use Carbon\Carbon;
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
        // $inventario_iniciales=InventarioInicial::all();
        $kardex_entradas=Kardex_entrada::where('motivo_id','4')->get();
        return view('inventario.inventario-inicial.index',compact('inventario_iniciales','clasificaciones','almacenes','kardex_entradas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        $almacenes=Almacen::all();
        $productos=Producto::where('estado_anular',1)->where('estado_id','!=',2)->get();
        $provedores=Provedor::all();
        $monedas=Moneda::all();
        return view('inventario.inventario-inicial.create',compact('productos','provedores','almacenes','monedas'));

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
        //validaciond e tipo de cambio
        $cambio=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        if(!$cambio){
            return "error por no hacer el cambio diario";
        }

        //Guardado de almacen para inventario-inicial
        $almacen=$request->get('almacen');
        $moneda=$request->get('moneda');

        //Kardex Entrada Guardado
        $kardex_entrada=new Kardex_entrada();
        $kardex_entrada->motivo_id=4;
        $kardex_entrada->provedor_id=$request->get('provedor');

        $kardex_entrada->categoria_id=2;
        $kardex_entrada->guia_remision="No Registrado";
        $kardex_entrada->factura="No Registrado";
        $kardex_entrada->almacen_id=$request->get('almacen');
        $kardex_entrada->moneda_id=$moneda;
        $kardex_entrada->informacion=$request->get('informacion');
        $kardex_entrada->save();

        //contador de valores de cantidad
        $cantidad = $request->input('cantidad');
        $count_cantidad=count($cantidad);
        //contador de valores de precio
        $precio = $request->input('precio');
        $count_precio=count($precio);


        //convertido a moneda principal
        $moneda_principal=Moneda::where('principal',1)->first();
        $moneda_principal_id=$moneda_principal->id;

        $kardex_entrada_moneda_id=$kardex_entrada->moneda_id;

        if($count_articulo = $count_cantidad = $count_precio){
            for($i=0;$i<$count_articulo;$i++){
                $kardex_entrada_registro=new kardex_entrada_registro();
                $kardex_entrada_registro->kardex_entrada_id=$kardex_entrada->id;
                $kardex_entrada_registro->producto_id=$request->get('articulo')[$i];
                $kardex_entrada_registro->cantidad_inicial=$request->get('cantidad')[$i];
                if($moneda_principal_id==$kardex_entrada_moneda_id){
                    $kardex_entrada_registro->precio_nacional=$request->get('precio')[$i];
                    $precio_nacional=$request->get('precio')[$i];
                    $kardex_entrada_registro->precio_extranjero=$precio_nacional*$cambio->compra;
                    $kardex_entrada_registro->cambio=$cambio->compra;
                }else{
                    $kardex_entrada_registro->precio_extranjero=$request->get('precio')[$i];
                    $precio_extranjero=$request->get('precio')[$i];
                    $kardex_entrada_registro->precio_nacional=$precio_extranjero*$cambio->venta;
                    $kardex_entrada_registro->cambio=$cambio->venta;
                }
                $kardex_entrada_registro->cantidad=$request->get('cantidad')[$i];
                $kardex_entrada_registro->estado=1;
                $kardex_entrada_registro->save();
            }
        }else{
            return "Falto introducir un campo";
        }
        return redirect()->route('kardex-entrada.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return view('inventario.inventario-inicial.show',compact(''));
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
