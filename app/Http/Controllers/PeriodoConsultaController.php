<?php

namespace App\Http\Controllers;
use App\PeriodoConsulta_registro;
use App\PeriodoConsulta;
use App\kardex_entrada;
use App\kardex_entrada_registro;
use App\Almacen;
use App\Categoria;
use Illuminate\Http\Request;

class PeriodoConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periodo_consultas=PeriodoConsulta::all();
        return view('inventario.periodo-consulta.index',compact('periodo_consultas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias=Categoria::all();
        $almacenes=Almacen::all();
        return view('inventario.periodo-consulta.create',compact('almacenes','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $registro=new PeriodoConsulta;
        $registro->nombre=$request->input('nombre');
        // $registro->nombre='consulta';
        $registro->fecha=$request->input('fecha');
        $registro->almacen_id=$request->input('almacen');
        $registro->categoria_id=$request->input('categoria');
        $registro->informacion=$request->input('informacion');
        $registro->save();

        //Ubicacion de alamacen
        $kardex_entrada_almacen=kardex_entrada::where('almacen_id',$registro->almacen_id)->where('categoria_id',$registro->categoria_id)->get();

        foreach($kardex_entrada_almacen as $kardex_entrada_alm){
            $periodo_registro=kardex_entrada_registro::where('estado','1')->where('kardex_entrada_id',$kardex_entrada_alm->id)->get();
                foreach ($periodo_registro as $periodo) {
                $register=new PeriodoConsulta_registro;
                $register->periodo_consulta_id=$registro->id;
                $register->producto_id=$periodo->producto_id;
                $register->cantidad_inicial=$periodo->cantidad_inicial;
                $register->precio_nacional=$periodo->precio_nacional;
                $register->precio_extranjero=$periodo->precio_extranjero;
                $register->cantidad=$periodo->cantidad;
                $register->save();
            }
        }

        return redirect()->route('periodo-consulta.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $periodo_consulta=PeriodoConsulta::find($id);
        $periodo_consulta_registros=PeriodoConsulta_registro::where('periodo_consulta_id',$id)->get();
        // $periodo_consulta_registros_num=PeriodoConsulta_registro::where('periodo_consulta_id',$id)->count();

        // for($i=0;$i< $periodo_consulta_registros_num;$i++){

        //     if($periodo_consulta_registros[$i]->producto_id =){
        //         $array[]= $periodo_consulta_registros[$i]->producto_id , $periodo_consulta_registros[$i]->cantidad;
        //     }
        // }

        return view('inventario.periodo-consulta.show',compact('periodo_consulta','periodo_consulta_registros'));
        // return  var_dump($array);
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
