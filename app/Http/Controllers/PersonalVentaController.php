<?php

namespace App\Http\Controllers;

use App\Moneda;
use App\Personal;
use App\Personal_datos_laborales;
use App\Personal_venta;
use App\Ventas_registro;
use Illuminate\Http\Request;

class PersonalVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $personal=Personal_venta::find($id);
      $moneda_nacional=Moneda::where('id',1)->first();
      $moneda_extranjera=Moneda::where('id',2)->first();
      $lista=Ventas_registro::all();

      $personal_contador= Personal_venta::all()->count();
      $suma=$personal_contador+1;

      $personal=Personal_datos_laborales::where('estado_trabajador','Activo')->get();
      $vendedores=Personal_venta::all();
      return view('planilla.vendedores.index', compact('vendedores','lista','moneda_nacional','moneda_extranjera','suma','personal'));
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
        $personal=Personal_datos_laborales::where('estado_trabajador','Activo')->get();
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
        $this->validate($request,[
            'id_personal' => ['required','unique:personal_ventas,id_personal'],
        ],[
            'id_personal.unique' => 'El vendedor ya ha sido registrado',

        ]);

      // Personal::create(request()->all());
        $personal_venta=new Personal_venta;
        $personal_venta->cod_vendedor=$request->get('cod_vendedor');
        $personal_venta->id_personal=$request->get('id_personal');
        $personal_venta->comision=$request->get('comision');
        $personal_venta->tipo_comision="Porcentaje de Venta";
        $personal_venta->estado=0;
        $personal_venta->save();
        return redirect()->route('vendedores.index');
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
        $lista=Ventas_registro::where('comisionista',$id)->where('estado_fac','0')->get();

        return view('planilla.vendedores.show',compact('personal','lista'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $personal=Personal_venta::find($id);
      return view('planilla.vendedores.edit',compact('personal'));
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
        $personal=Personal_venta::find($id);
        $personal->estado=$request->get('estado');
        $personal->comision=$request->get('comision');
        $personal->save();

        // return redirect()->route('personal-datos-laborales.index');
        return redirect()->route('vendedores.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
    public function aprobar(Request $request, $id)
    {

     $registro=Ventas_registro::find($id);
         // return $registro;
     $registro->estado_aprobado='1';
     $registro->save();

     return redirect()->route('vendedores.show', $registro->comisionista);
        // return redirect()->route('productos.index');


 }
 public function procesado(Request $request, $id)
 {

    $registro=Ventas_registro::find($id);
    $registro->pago_efectuado='1';
    $registro->save();
    return redirect()->route('vendedores.show', $registro->comisionista);

}
public function estado(Request $request, $id)
{

    $personal_venta=Personal_venta::find($id);
    $personal_venta->estado=$request->get('numero');
    $personal_venta->save();
    return redirect()->route('vendedores.index');

}
}
