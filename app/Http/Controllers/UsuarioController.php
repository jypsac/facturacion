<?php

namespace App\Http\Controllers;

use App\Permiso;
use App\Personal;
use App\User;
use Illuminate\Http\Request;

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
        $user->estado=1;
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
        // recibiendo Datos
        $usuarios=User::all();
        $contrasena_confirmar=$request->get('contrasena_confirmar');
        $correo_new=$request->get('correo');
        $password_new=$request->get('password_new');

        $contra=User::where('id',$id)->first();

        if (password_verify($contrasena_confirmar, $contra->password)){
            if (isset($password_new)) {
                $user=User::find($id);
                $user->email=$correo_new;
                $user->password=bcrypt($password_new);
                $user->save();
                $mensaje='Contraseña Modificada Correctamente';
                return view('maestro.usuario.index',compact('usuarios','mensaje'));
            }
            else{
                $user=User::find($id);
                $user->email=$correo_new;
                $user->save();
                return redirect()->route('usuario.index');
            }
        }
        else {
            $error='Contraseña de Confirmacion Erronea';
            return $error;
        // return '¡La contraseña no es la misma!';
        }
    // $user=User::find($id);
    // $user->email=$request->get('correo');
    // $user->password=bcrypt($request->get('password'));
    // $user->save();

    // return redirect()->route('usuario.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function desactivar($id)
    {
        //la eliminacion del usuario sera por medio de un estado (desactivado)
        $user=User::find($id);
        $user->estado=0;
        $user->save();

        return redirect()->route('usuario.index');
    }

    public function activar($id)
    {
        //la eliminacion del usuario sera por medio de un estado (desactivado)
        $user=User::find($id);
        $user->estado=1;
        $user->save();

        return redirect()->route('usuario.index');
    }

    public function permiso($id){

        $usuario=User::find($id);
        $permisos=Permiso::all();
        return view('maestro.usuario.permisos.lista',compact('usuario','permiso'));
    }

    public function asignar_permiso(){
        //asignamiento de permisos
    }
}
