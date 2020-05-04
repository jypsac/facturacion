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

        $this->validate($request,[
            'codigo_original' => ['required','unique:productos,codigo_original'],
        ]
        );


        // categoria Abreviatura
        $categoria=$request->get('categoria_id');
        $id_igual=Categoria::where('id','=',$categoria)->first();

        $nombre_cate=$id_igual->descripcion;
        $cate = substr($nombre_cate, 0, 1);
        // marca abrebiatura
        $marca=$request->get('marca_id');
        $id_igual_marca=Marca::where('id','=',$marca)->first();
        $nombre_marca=$id_igual_marca->abreviatura;
        $contador=1000000;
        $guion='-';
        $code=Producto::count();
        $code++;
        $num=$contador+$code;
        $string_code=(string)$num;
        $code_final=substr($string_code,1);
        $codigo_producto=$cate.$guion.$nombre_marca.$guion.$code_final;
        
        // return $codigo_producto;

        if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/productos/');
            $image1->move($destinationPath,$name);
        }else{
            $name="sin_foto.jpg";
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
        $producto->garantia=$request->get('garantia');
        $producto->stock_minimo=$request->get('stock_minimo');
        $producto->stock_maximo=$request->get('stock_maximo');
        $producto->foto=$name;
        $producto->estado_anular='1';
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
         if($request->hasfile('foto')){
            $image1 =$request->file('foto');
            $name =time().$image1->getClientOriginalName();
            $destinationPath = public_path('/archivos/imagenes/productos/');
            $image1->move($destinationPath,$name);
        }else{
            $name=$request->get('ori_foto');
        }

        $producto=Producto::find($id);
        $producto->nombre=$request->get('nombre');
        $producto->codigo_original=$request->get('codigo_original');
        $producto->descripcion=$request->get('descripcion');
        $producto->estado_id=$request->get('estado_id');
        $producto->origen=$request->get('origen');
        $producto->descuento1=$request->get('descuento1');
        $producto->descuento2=$request->get('descuento2');
        $producto->descuento_maximo=$request->get('descuento_maximo');
        $producto->utilidad=$request->get('utilidad');
        $producto->unidad_medida_id=$request->get('unidad_medida_id');
        $producto->garantia=$request->get('garantia');
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
    //     $producto=Producto::findOrFail($id);
    //     $producto->delete();
        $producto=Producto::find($id);
        $producto->codigo_original='Codigo Anulado N°'.$id;
        $producto->estado_anular='0';
        $producto->save();
        
        return redirect()->route('productos.index');
    }
}
