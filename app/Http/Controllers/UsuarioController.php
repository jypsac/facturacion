<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Personal;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios=User::all();
        return view('maestro.usuario.index',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lista()
    {
        $personales=Personal::all();
        return view('maestro.usuario.lista',compact('personales'));
    }


    // public function create()
    // {

    // }

    public function crear($id)
    {
        $personal=Personal::find($id);
        return view('maestro.usuario.create',compact('personal'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //Al no poder recibir 2 parametros,obliga a la creacion de otro controlador
    }

    public function creacion(Request $request,$id)
    {
        $user=new User();
        $user->personal_id=$id;
        $user->name=$request->get('name');
        $user->email=$request->get('correo');
        $user->password=bcrypt($request->get('password'));
        $user->save();

        return redirect()->route('usuario.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //no xD
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario=User::find($id);
        return view('maestro.usuario.edit',compact('usuario'));
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
        $user=User::find($id);
        $user->name=$request->get('name');
        $user->email=$request->get('correo');
        $user->password=bcrypt($request->get('password'));
        $user->save();

        return redirect()->route('usuario.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //la eliminacion del usuario sera por medio de un estado (desactivado)
    }
}
