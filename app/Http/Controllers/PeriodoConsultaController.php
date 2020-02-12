<?php

namespace App\Http\Controllers;
use App\PeriodoConsulta_registro;
use App\PeriodoConsulta;
use App\kardex_entrada_registro;
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
        return view('inventario.periodo-consulta.create');
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
        $registro->informacion=$request->input('informacion');
        $registro->save();

        $periodo_registro=kardex_entrada_registro::where('estado','1')->get();
        foreach ($periodo_registro as $periodo) {
            $register=new PeriodoConsulta_registro;
            $register->periodo_consulta_id=$registro->id;
            $register->producto_id=$periodo->producto_id;
            $register->cantidad_inicial=$periodo->cantidad_inicial;
            $register->precio=$periodo->precio;
            $register->cantidad=$periodo->cantidad;
            $register->save();
        }

        return "listo";
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
        return view('inventario.periodo-consulta.show',compact('periodo_consulta','periodo_consulta_registros'));
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
