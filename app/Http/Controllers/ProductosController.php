<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Unidad_medida;
use App\Categoria;
use App\Marca;
use App\Estado;
use App\Familia;
use App\kardex_entrada_registro;
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
        // $stok=kardex_entrada_registro::where('producto_id',$producto->id)->where('estado',1)->sum('cantidad');
        $marcas=Marca::all();
        $productos=Producto::all();
        return view('producto_servicios.productos.index',compact('productos','marcas'));
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
        $categorias=Categoria::where('descripcion','PRODUCTOS')->first();
        $unidad_medidas=Unidad_medida::all();
        return view('producto_servicios.productos.create',compact('unidad_medidas','categorias','marcas','estados','familias','monedas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request )
    {
        $this->validate($request,[
            'codigo_original' => ['required','unique:productos,codigo_original'],
        ],[
            'codigo_original.unique' => 'El codigo alternativo ya existe',
        ]);

        $id_producto=$request->get('marca_id');
        $marca= Marca::where("id","=",$id_producto)->first();
        $abreviatura=$marca->abreviatura;
        $marca_cantidad= Producto::where("marca_id","=",$id_producto)->count();
        $marca_cantidad++;
        $contador=1000000;
        $marca_cantidad=$contador+$marca_cantidad;
        $marca_cantidad=(string)$marca_cantidad;
        $marca_cantidad=substr($marca_cantidad,1);
        $codigo=$abreviatura.'-'.$marca_cantidad;

        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/productos/');
            $image1->move($destinationPath,$name);
        }else{
            $name=$request->get('foto');
        }

        $peso=$request->get('peso');
        $simbolo=$request->get('simbolo');

        $codigo_original=$request->get('codigo_original');
        if (isset($codigo_original)) {
         $codigo_original=$request->get('codigo_original');
     }else{
        $codigo_original=$codigo;
    }
    $categorias=Categoria::where('descripcion','PRODUCTOS')->first();
    $producto=new Producto;
    $producto->codigo_producto=$codigo;
    $producto->codigo_original=$codigo_original;
    $producto->categoria_id=$categorias->id;
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
    $producto->garantia=$request->get('garantia');
    $producto->peso=$peso.' '.$simbolo;
    $producto->stock_minimo=$request->get('stock_minimo');
    $producto->stock_maximo=$request->get('stock_maximo');
    $producto->foto=$name;
    $producto->estado_anular='1';
    $producto->save();
    return redirect()->route('productos.show',$producto->id);


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
        return view('producto_servicios.productos.show',compact('producto'));
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
        $pro_peso=$producto->peso;

        $simbolo = strstr($pro_peso, ' ',false);
        $peso = strstr($pro_peso, ' ',true);

        $monedas=Moneda::all();
        $familias=Familia::all();
        $marcas=Marca::all();
        $estados=Estado::all();
        $categorias=Categoria::all();
        $unidad_medidas=Unidad_medida::all();
        return view('producto_servicios.productos.edit',compact('unidad_medidas','categorias','marcas','estados','familias','monedas','producto','peso','simbolo'));
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
        $this->validate($request,[
            'codigo_original' => ['required','unique:productos,codigo_original,'.$id],
        ],[
            'codigo_original.unique' => 'El codigo alternativo ya existe',
        ]);

     if($request->hasfile('foto')){
        $image1 =$request->file('foto');
        $name =time().$image1->getClientOriginalName();
        $destinationPath = public_path('/archivos/imagenes/productos/');
        $image1->move($destinationPath,$name);
    }else{
        $name=$request->get('foto_original');
    }

    $peso=$request->get('peso');
    $simbolo=$request->get('simbolo');

    $codigo_original=$request->get('codigo_original');
    if (isset($codigo_original)) {
         $codigo_original=$request->get('codigo_original');
     }else{
        $codigo_original=$request->get('codigo');
    }

    $producto=Producto::find($id);
    $producto->nombre=$request->get('nombre');
    $producto->codigo_original=$codigo_original;
    $producto->descripcion=$request->get('descripcion');
    $producto->estado_id=$request->get('estado_id');
    $producto->origen=$request->get('origen');
    $producto->descuento1=$request->get('descuento1');
    $producto->descuento2=$request->get('descuento2');
    $producto->descuento_maximo=$request->get('descuento_maximo');
    $producto->utilidad=$request->get('utilidad');
    $producto->unidad_medida_id=$request->get('unidad_medida_id');
    $producto->garantia=$request->get('garantia');
    $producto->peso=$peso.' '.$simbolo;
    $producto->stock_minimo=$request->get('stock_minimo');
    $producto->stock_maximo=$request->get('stock_maximo');
    $producto->foto=$name;
    $producto->save();
    return redirect()->route('productos.show',$id);
}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        // Validación para la anulacion Kardex Entrada
        $kardex_entrada=kardex_entrada_registro::where('producto_id',$id)->where('estado',1)->get()->first();
        // return $kardex_entrada;


        // Si el producto existe en cardex entrada
        if(isset($kardex_entrada->producto_id)){
            // NO ANULA EL PRODUCTO
            // $errors = "Para anular un producto, haga la salida de todo el stock en kardex";
            // return route('productos.index',compact('errors'));
            return redirect()->route('productos.index')->with('anulacion', 'Para anular un producto, haga la salida de todo el stock en kardex');
            // return "Error por tener producto en kardex, no se puede eliminar";
            // return $kardex_entrada;
        }else{
            $producto=Producto::find($id);
            $producto->codigo_original='Codigo Anulado N°'.$id;
            $producto->estado_anular='0';
            $producto->save();
            return redirect()->route('productos.index');
            // return '0';
        }

    }
}
