<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Unidad_medida;
use App\Categoria;
use App\Marca;
use App\Estado;
use App\Familia;
use App\Moneda;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $marcas=Marca::all();
        $productos=Producto::all();
        return view('maestro.catalogo.productos.index',compact('productos','marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $monedas=Moneda::all();
        $familias=Familia::all();
        $marcas=Marca::all();
        $estados=Estado::all();
        $categorias=Categoria::all();
        $unidad_medidas=Unidad_medida::all();
        return view('maestro.catalogo.productos.create',compact('unidad_medidas','categorias','marcas','estados','familias','monedas','orden_servicio'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        // categoria Abreviatura
        $categoria=$request->get('categoria_id');
        $id_igual=Categoria::where('id','=',$categoria)->first();
        $nombre_cate=$id_igual->descripcion;
        $cate = substr($nombre_cate, 0, 3);
        // marca abrebia
        $marca=$request->get('marca_id');
        $id_igual_marca=Marca::where('id','=',$marca)->first();
        $nombre_marca=$id_igual_marca->abreviatura;

        $guion='-';
        $ceros='0000';
        $codigo_producto=$cate.$guion.$nombre_marca.$guion.$ceros;

        

        
        // $image =$request->file('foto');
        
        // $name = $codigo."-".$image->getClientOriginalName();
        // $image->move(public_path().'/archivos/imagenes/productos',$name);

        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name1 =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/productos/');
            $image1->move($destinationPath,$name1);            
        }else{
            $name="sin_foto";
        }

        $producto=new Producto;
        $producto->codigo_producto=$codigo_producto;
        $producto->codigo_original=$request->get('codigo_original');
        $producto->categoria_id=$request->get('categoria_id');
        $producto->familia_id=$request->get('familia_id');
        $producto->marca_id=$request->get('marca_id');
        $producto->nombre=$request->get('nombre');
        $producto->descripcion=$request->get('descripcion');
        $producto->estado_id=$request->get('estado_id');
        $producto->origen=$request->get('origen');
        $producto->descuento1=$request->get('descuento1');
        $producto->descuento2=$request->get('descuento2');
        $producto->descuento_maximo=$request->get('descuento_maximo');
        $producto->utilidad=$request->get('utilidad');
        $producto->unidad_medida_id=$request->get('unidad_medida_id');
        $producto->monedas_id=$request->get('monedas_id');
        $producto->precio=$request->get('precio');
        $producto->stock_minimo=$request->get('stock_minimo');
        $producto->stock_maximo=$request->get('stock_maximo');
        $producto->foto=$name;
        $producto->save();
        return redirect()->route('productos.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto=Producto::find($id);
        return view('maestro.catalogo.productos.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $producto=Producto::find($id);
        $monedas=Moneda::all();
        $familias=Familia::all();
        $marcas=Marca::all();
        $estados=Estado::all();
        $categorias=Categoria::all();
        $unidad_medidas=Unidad_medida::all();
        return view('maestro.catalogo.productos.edit',compact('unidad_medidas','categorias','marcas','estados','familias','monedas','producto'));
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
        $image =$request->file('foto');
        $codigo= $request->get('codigo_barras');
        $name = $codigo."-".$image->getClientOriginalName();
        $image->move(public_path().'/archivos/imagenes/productos',$name);

        $producto=Producto::find($id);
        $producto->codigo_producto=$request->get('codigo_producto');
        $producto->codigo_original=$request->get('codigo_original');
        $producto->categoria_id=$request->get('categoria_id');
        $producto->familia_id=$request->get('familia_id');
        $producto->marca_id=$request->get('marca_id');
        $producto->nombre=$request->get('nombre');
        $producto->descripcion=$request->get('descripcion');
        $producto->estado_id=$request->get('estado_id');
        $producto->origen=$request->get('origen');
        $producto->descuento1=$request->get('descuento1');
        $producto->descuento2=$request->get('descuento2');
        $producto->descuento_maximo=$request->get('descuento_maximo');
        $producto->utilidad=$request->get('utilidad');
        $producto->unidad_medida_id=$request->get('unidad_medida_id');
        $producto->monedas_id=$request->get('monedas_id');
        $producto->precio=$request->get('precio');
        $producto->stock_minimo=$request->get('stock_minimo');
        $producto->stock_maximo=$request->get('stock_maximo');
        $producto->foto=$name;
        // $producto->foto=$name;
        $producto->save();
        return redirect()->route('productos.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto=Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index');
    }
}
