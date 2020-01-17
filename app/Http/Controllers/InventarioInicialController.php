<?php

namespace App\Http\Controllers;
use App\InventarioInicial;
use App\Producto;
use App\Categoria;
use App\Almacen;
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
        return view('inventario.inventario-inicial.index',compact('inventario_iniciales','clasificaciones','almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function create(Request $request)
    {
        $almacen = $request->input('almacen');
        $clasificaciones = $request->input('clasificacion');
        $productos=Producto::all();
        $inventario_iniciales=InventarioInicial::where('almacen','=',$almacen)->where('categorias','=',$clasificaciones)->get();
        //enviar guia de ingreso para saldo
        //enviar guia de ingreso para costo

        //consulta para total de costo
        return view('inventario.inventario-inicial.create',compact('productos','almacen','clasificaciones','inventario_iniciales'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $id_producto=$request->input('articulo');
        // $producto = Producto::where("id","=",$id_producto)->first();
        // $producto=(string)$producto->unidad_medida_id;

        $inventario_inicial=new InventarioInicial();
        $inventario_inicial->almacen=$request->input('almacen');
        $inventario_inicial->categorias=$request->input('categorias');
        $inventario_inicial->articulo=$request->input('articulo');
        // $inventario_inicial->unidad_medida=$producto;
        $inventario_inicial->codigo=$request->input('codigo');
        $inventario_inicial->saldo=$request->input('saldo');
        $inventario_inicial->save();

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