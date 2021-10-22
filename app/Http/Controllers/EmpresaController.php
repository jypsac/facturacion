<?php

namespace App\Http\Controllers;

use App\Empresa;
use App\Banco;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mi_empresa=Empresa::first();
        $banco=Banco::all();
        return view('configuracion_general.empresa.index',compact('mi_empresa','banco'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $nombre="12121";
    //1- Crear directorio de Laravel
        //A-Crear archivo Bat para clonar
        $copy_page = fopen("C:\laragon\www/".$nombre.".bat", 'a');
        $texto='robocopy C:\laragon\www\facturacion  C:\laragon\www/'.$nombre.' /e';
        fwrite($copy_page,$texto);
        // fclose($copy_page);

        //B-Correr el Archivo Bat
        $c='start /b  C:\laragon\www/'.$nombre.'.bat';
        $r=pclose(popen($c, 'r'));

    //2- Crear Base de Datos
        //A-Crear archivo Bat para crear BD
        $bdatos = fopen('C:\laragon\www/bd_'.$nombre.'.bat', 'a');
        $texto2='cd/
        cd laragon\bin\mysql\mysql-5.7.24-winx64\bin
        mysql -u root -e " create DATABASE '.$nombre.';"';
        fwrite($bdatos,$texto2);
        //B-Correr el Archivo Bat
        $w='start /b  C:\laragon\www/bd_'.$nombre.'.bat';
        $r=pclose(popen($w, 'r'));

        // $c='start /b  C:\laragon\www/'.$nombre.'.bat';

        // sleep(90);
        // unlink('C:\laragon\www/'.$nombre.'.bat');
        // return json_encode(array('result'=>$r)).json_encode(array('result'=>$a));

    //2- Cambiar Nombre del ".env"

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if($request->hasfile('fotos')){
            $image1 =$request->file('fotos');
            $name =$image1->getClientOriginalName();
            $destinationPath = public_path('/img/logos/');
            $image1->move($destinationPath,$name);
        }else{
            $name=$request->get('ori_foto') ;
        }
        $empresa=Empresa::find($id);
        $empresa->telefono=$request->get('telefono');
        $empresa->movil=$request->get('movil');
        $empresa->correo=$request->get('correo');
        $empresa->pais=$request->get('pais');
        $empresa->region_provincia=$request->get('region_provincia');
        $empresa->ciudad=$request->get('ciudad');
        $empresa->calle=$request->get('calle');
        $empresa->codigo_postal=$request->get('codigo_postal');
        $empresa->rubro=$request->get('rubro');
        $empresa->descripcion=$request->get('descripcion');
        $empresa->pagina_web=$request->get('pagina_web');
        $empresa->foto=$name;
        $empresa->background=$request->get('background');
        $empresa->save();
        return back();
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