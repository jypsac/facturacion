<?php

namespace App\Http\Controllers;

use App\Pais;
use App\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personales=Personal::all();
        return view('planilla.datos_generales.index',compact('personales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises=Pais::all();
        return view('planilla.datos_generales.create',compact('paises'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if($request->hasfile('foto')){
            $image =$request->file('foto');
            $nr_documento= $request->get('numero_documento');
            $name = $nr_documento."-".$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);
        }
        else{
            $name="perfil.svg"; 
        }
        // Personal::create(request()->all());
        $personal=new Personal;
        $personal->nombres=$request->get('nombres');
        $personal->apellidos=$request->get('apellidos');
        $personal->fecha_nacimiento=$request->get('fecha_nacimiento');
        $personal->celular=$request->get('celular');
        // $personal->telefono=$request->get('telefono');
        $personal->email=$request->get('email');
        $personal->genero=$request->get('genero');
        $personal->documento_identificacion=$request->get('documento_identificacion');
        $personal->numero_documento=$request->get('numero_documento');
        $personal->nacionalidad=$request->get('nacionalidad');
        $personal->estado_civil=$request->get('estado_civil');
        $personal->nivel_educativo=$request->get('nivel_educativo');
        $personal->profesion=$request->get('profesion');
        $personal->direccion=$request->get('direccion');
        $personal->estado=0;
        $personal->estado_trabajador_laboral='Activo';
        $personal->foto=$name;
        $personal->save();
        return redirect()->route('personal.show', $personal->id); 

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $personales=Personal::find($id);
        return view('planilla.datos_generales.show',compact('personales'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $paises=Pais::all();
        $personales=Personal::find($id);
        return view('planilla.datos_generales.edit',compact('personales','paises'));
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

        $personal=Personal::find($id);
        if($request->hasfile('foto')){
            $image =$request->file('foto');
            $nr_documento= $request->get('numero_documento');
            $name = $nr_documento."-".$image->getClientOriginalName();
            $image->move(public_path().'/profile/images',$name);


            $personal->nombres=$request->get('nombres');
            $personal->apellidos=$request->get('apellidos');
            $personal->fecha_nacimiento=$request->get('fecha_nacimiento');
            $personal->celular=$request->get('celular');
            $personal->telefono=$request->get('telefono');
            $personal->email=$request->get('email');
            $personal->genero=$request->get('genero');
            $personal->documento_identificacion=$request->get('documento_identificacion');
            $personal->numero_documento=$request->get('numero_documento');
            $personal->nacionalidad=$request->get('nacionalidad');
            $personal->estado_civil=$request->get('estado_civil');
            $personal->nivel_educativo=$request->get('nivel_educativo');
            $personal->profesion=$request->get('profesion');
            $personal->direccion=$request->get('direccion');
            $personal->foto=$name;
            $personal->save();
        }else{
            // $file_path=(public_path().'profile/images/'.$personal->image);
            $personal->nombres=$request->get('nombres');
            $personal->apellidos=$request->get('apellidos');
            $personal->fecha_nacimiento=$request->get('fecha_nacimiento');
            $personal->celular=$request->get('celular');
            $personal->telefono=$request->get('telefono');
            $personal->email=$request->get('email');
            $personal->genero=$request->get('genero');
            $personal->documento_identificacion=$request->get('documento_identificacion');
            $personal->numero_documento=$request->get('numero_documento');
            $personal->nacionalidad=$request->get('nacionalidad');
            $personal->estado_civil=$request->get('estado_civil');
            $personal->nivel_educativo=$request->get('nivel_educativo');
            $personal->profesion=$request->get('profesion');
            $personal->direccion=$request->get('direccion');
            // $personal->foto=$file_path;
            $personal->save();
        }
        // return redirect()->route('personal.index');
        return redirect()->route('personal.show', $personal->id); 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personal=Personal::findOrFail($id);
        $personal->delete();

        return redirect()->route('personal.index');
    }
}
