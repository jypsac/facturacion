<?php

namespace App\Http\Controllers;

use App\Permiso;
use App\Personal;
use App\User;
use App\Config;
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
        $personales=Personal::where('usuario_registrado',0)->get();
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
        $this->validate($request,[
            'correo' => ['required','email','unique:users,email'],
        ],[
            'email.unique' => 'El correo ya existe',
        ]);

        $data = $request->all();
        // recibiendo Datos
        $usuarios=User::all();
        $name=$request->get('name');
        $email=$request->get('correo');
        $password=$request->get('password');
        $password_2=$request->get('password_2');

        if ($password_2==$password) {
            $apariencia=new Config();
            $apariencia->fondo_perfil='paisaje_noche.jpg';
            $apariencia->borde_foto="3px" ;
            $apariencia->color_borde_foto='#ffffff';
            $apariencia->foto_icono="defecto.png" ;
            $apariencia->foto_perfil= "0" ;
            $apariencia->letra="none" ;
            $apariencia->tamano_letra=" " ;
            $apariencia->color_sombra_nombre="#000000 " ;
            $apariencia->color_nombre= "#ffffff " ;
            $apariencia->tamano_letra_perfil= "12px " ;
            $apariencia->save();

            $user=new User();
            $user->personal_id=$id;
            $user->confi_id=$apariencia->id;
            $user->name=$name;
            $user->email=$email;
            $user->password=bcrypt($password);
            $user->estado=1;
            $user->email_creado=0;
            $user->save();

            $user=Personal::find($id);
            $user->usuario_registrado=1;
            $user->save();

            $mensaje_creacion='Usuario "'.$email.'" Agregado Correctamente ';
            return view('maestro.usuario.index',compact('usuarios','mensaje_creacion'));
            return redirect()->route('usuario.index',compact('mensaje_creacion'));
        }
        else{
            $errores='Las Contraseñas No Coinciden, Intentelo nuevamente';
            $personales=Personal::where('usuario_registrado',0)->get();
            return view('maestro.usuario.lista',compact('personales','errores'));
            return redirect()->route('usuario.lista',compact('errores'));
        }

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
            return view('maestro.usuario.index',compact('usuarios','error'));
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
