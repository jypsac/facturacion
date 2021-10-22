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

        $nombre="910675119";
        $nombre= (string)$nombre;
    //1- Crear directorio de Laravel
        //A-Crear archivo Bat para clonar
        $copy_page = fopen("C:\laragon\www/puntos_bat/".$nombre.".bat", 'a');
        $texto='robocopy C:\laragon\www\facturacion  C:\laragon\www/'.$nombre.' /e';
        fwrite($copy_page,$texto);
        // fclose($copy_page);

        //B-Correr el Archivo Bat
        $c='start /b  C:\laragon\www/puntos_bat/'.$nombre.'.bat';
        $r=pclose(popen($c, 'r'));

    //2- Crear Base de Datos
        //A-Crear archivo Bat para crear BD
        $bdatos = fopen('C:\laragon\www/puntos_bat/bd_'.$nombre.'.bat', 'a');
        $texto2='cd/
        cd laragon\bin\mysql\mysql-5.7.24-winx64\bin
        mysql -u root -e " create DATABASE facturacion_'.$nombre.' ;"';
        fwrite($bdatos,$texto2);
        //B-Correr el Archivo Bat
        $w='start /b  C:\laragon\www/puntos_bat/bd_'.$nombre.'.bat';
        $r=pclose(popen($w, 'r'));
        sleep(5);

    //3- Borrar .env y Crear .ENV con nueva base de datos
        //A-Borrar ENV
        unlink('C:\laragon\www/'.$nombre.'/.env');
        //B-Crear archivo Bat para crear BD
        $env = fopen('C:\laragon\www/'.$nombre.'/.env', 'a');
        $texto_env='APP_NAME=facturacion
        APP_ENV=local
        APP_KEY=base64:mJRlTzPKaapP9OqKdqsj7sTQxSa/HwXoGI2q7L6OwKo=
        APP_DEBUG=true
        APP_URL=http://localhost

        LOG_CHANNEL=stack

        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE= facturacion_'.$nombre.'
        DB_USERNAME=root
        DB_PASSWORD=

        BROADCAST_DRIVER=log
        CACHE_DRIVER=file
        QUEUE_CONNECTION=sync
        SESSION_DRIVER=file
        SESSION_LIFETIME=120

        REDIS_HOST=127.0.0.1
        REDIS_PASSWORD=null
        REDIS_PORT=6379

        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.mailtrap.io
        MAIL_PORT=2525
        MAIL_USERNAME=5c6698a7299f48
        MAIL_PASSWORD=be72971a1aa9f9
        MAIL_ENCRYPTION=null

        AWS_ACCESS_KEY_ID=
        AWS_SECRET_ACCESS_KEY=
        AWS_DEFAULT_REGION=us-east-1
        AWS_BUCKET=

        PUSHER_APP_ID=
        PUSHER_APP_KEY=
        PUSHER_APP_SECRET=
        PUSHER_APP_CLUSTER=mt1

        MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
        MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
        ';
        fwrite($env,$texto_env);

    //4- Refresh seedr
        //A-Crear archivo Bat para crear las migraciones
        $migrate = fopen('C:\laragon\www/puntos_bat/php_fresh_'.$nombre.'.bat', 'a');
        $texto_migrate='cd/
        cd laragon\www/'.$nombre.'
        php artisan migrate:fresh
        php artisan migrate:fresh --seed';
        fwrite($migrate,$texto_migrate);

        //B-Correr el Archivo Bat
        $bat_migra='start /b  C:\laragon\www/puntos_bat/php_fresh_'.$nombre.'.bat';
        $btmi=pclose(popen($bat_migra, 'r'));


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