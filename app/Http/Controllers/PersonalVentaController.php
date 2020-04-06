<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal_venta;
use App\Personal;

class PersonalVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendedores=Personal_venta::all();
        return view('planilla.vendedores.index', compact('vendedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        $personal_contador= Personal_venta::all()->count();
        $suma=$personal_contador+1;
        $personal=Personal::all();
        return view('planilla.vendedores.create', compact('personal','suma'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // Personal::create(request()->all());
        $personal_venta=new Personal_venta;
        $personal_venta->cod_vendedor=$request->get('cod_vendedor');
        $personal_venta->id_personal=$request->get('id_personal');
        $personal_venta->tipo_comision=$request->get('tipo_comision');
        $personal_venta->comision=$request->get('comision');
        $personal_venta->estado=0;
        

        $personal_venta->save();
        return redirect()->route('vendedores.show', $personal_venta->id); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $personal=Personal_venta::find($id);
        return view('planilla.vendedores.show',compact('personal'));
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
