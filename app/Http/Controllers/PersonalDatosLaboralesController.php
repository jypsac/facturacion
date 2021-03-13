<?php

namespace App\Http\Controllers;

use App\Personal;
use App\Personal_datos_laborales;
use Illuminate\Http\Request;

class PersonalDatosLaboralesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personales=Personal_datos_laborales::all();
        return view('planilla.datos_laborales.index',compact('personales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personales=Personal::all();
        return view('planilla.datos_laborales.create',compact('personales'));

    }

    public function idpersonal($recibes){

        $personales=Personal::where('id', '=', $recibes)->first();
        return view('planilla.datos_laborales.create',compact('personales'));

        // return $personales;


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $personal_id=$request->get('personal_id');

        $personal_estado=Personal::where('id',$personal_id)->first();
        $personal_estado->estado=1;
        $personal_estado->save();

        $personal=new Personal_datos_laborales;
        $personal->personal_id=$request->get('personal_id');
        $personal->fecha_vinculacion=$request->get('fecha_vinculacion');
        $personal->fecha_retiro=$request->get('fecha_retiro');
        $personal->forma_pago=$request->get('forma_pago');
        $personal->salario=$request->get('salario');
        $personal->categoria_ocupacional=$request->get('categoria_ocupacional');
        $personal->estado_trabajador='Activo';
        $personal->sede=$request->get('sede');
        $personal->turno=$request->get('turno');
        $personal->departamento_area=$request->get('departamento_area');
        $personal->cargo=$request->get('cargo');
        $personal->tipo_trabajador=$request->get('tipo_trabajador');
        $personal->tipo_contrato=$request->get('tipo_contrato');
        $personal->regimen_pensionario=$request->get('regimen_pensionario');
        $personal->afiliacion_salud=$request->get('afiliacion_salud');
        $personal->banco_renumeracion=$request->get('banco_renumeracion');
        $personal->numero_cuenta=$request->get('numero_cuenta');
        $personal->notas=$request->get('notas');
        $personal->save();
        // return redirect()->route('personal-datos-laborales.index');
        return redirect()->route('personal-datos-laborales.show', $personal->personal_id);

        // return $personal_id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $personales=Personal::where('id',$id)->first();
        $persona=Personal_datos_laborales::where('personal_id',$id)->first();
        //   $personales=Personal_datos_laborales::find($id);
        return view('planilla.datos_laborales.show',compact('persona','personales'));
        // return  $personal_datos_laborales;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $personales=Personal_datos_laborales::find($id);
        $persona=Personal::where('id',$personales->personal_id)->first();
        return view('planilla.datos_laborales.edit',compact('personales','persona'));
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
         // //Personal Estado
        $id_personal_estado=$request->get('id_personal');

        $personal_estado=Personal::find($id_personal_estado);
        $personal_estado->estado_trabajador_laboral=$request->get('estado_trabajador');
        $personal_estado->save();

        $personal=Personal_datos_laborales::find($id);
        $id_personal=$request->get('id_personal');
        $personal->fecha_vinculacion=$request->get('fecha_vinculacion');
        $personal->fecha_retiro=$request->get('fecha_retiro');
        $personal->forma_pago=$request->get('forma_pago');
        $personal->salario=$request->get('salario');
        $personal->categoria_ocupacional=$request->get('categoria_ocupacional');
        $personal->estado_trabajador=$request->get('estado_trabajador');
        $personal->sede=$request->get('sede');
        $personal->turno=$request->get('turno');
        $personal->departamento_area=$request->get('departamento_area');
        $personal->cargo=$request->get('cargo');
        $personal->tipo_trabajador=$request->get('tipo_trabajador');
        $personal->tipo_contrato=$request->get('tipo_contrato');
        $personal->regimen_pensionario=$request->get('regimen_pensionario');
        $personal->afiliacion_salud=$request->get('afiliacion_salud');
        $personal->banco_renumeracion=$request->get('banco_renumeracion');
        $personal->numero_cuenta=$request->get('numero_cuenta');
        $personal->notas=$request->get('notas');
        $personal->save();

        // return redirect()->route('personal-datos-laborales.index');
        return redirect()->route('personal-datos-laborales.show', $id_personal);
        // return $id_personal;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personal=Personal_datos_laborales::findOrFail($id);
        $personal->delete();

        return redirect()->route('personal-datos-laborales.index');
    }
}
