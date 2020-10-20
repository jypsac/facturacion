<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\Marca;
use App\Cliente;
use App\Contacto;
use App\Empresa;
use App\Personal_datos_laborales;
use App\Personal;
use App\CreateMail;
use App\Mailbox;
use App\Pais;
use App\Producto;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Attachment;
use Auth;


class GarantiaGuiaIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $marcas=Marca::all();
      $garantias_guias_ingresos=GarantiaGuiaIngreso::all();
      return view('transaccion.garantias.guia_ingreso.index',compact('marcas','garantias_guias_ingresos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $tiempo_actual = Carbon::now();
      $tiempo_actual = $tiempo_actual->format('Y-m-d');

      $name = $request->input('familia');
      $marca = Marca::where("id","=",$name)->first();
      $marca_nombre=(string)$marca->nombre;
      $marca=(string)$marca->abreviatura;
      $guion='-';
      $marca_cantidad= GarantiaGuiaIngreso::where("marca_id","=",$name)->count();
      $marca_cantidad++;
      $contador=1000000;
      $marca_cantidad=$contador+$marca_cantidad;
      $marca_cantidad=(string)$marca_cantidad;
      $marca_cantidad=substr($marca_cantidad,1);
      $orden_servicio=$marca.$guion.$marca_cantidad;
      $paises = Pais::all();

      $productos = Producto::all();

      $clientes=Cliente::all();
        // $personales=Personal_datos_laborales::where("cargo","=","ingeniero")->get();
      $personales=Personal_datos_laborales::all();
        // $personales=Personal::join("personal_datos_laborales","id","=","personal_datos_laborales.personal_id")->get();
        // $personales=DB::table('personal_datos_laborales')->join("personal","personal.id","=","personal_datos_laborales.personal_id")->get();

        //llamar la abreviartura deacuerdo con el nombre del name separarlo por coma en el imput
      return view('transaccion.garantias.guia_ingreso.create',compact('name','marca','orden_servicio','tiempo_actual','clientes','marca_nombre','personales','paises','productos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contacto_cliente(Request $request){
      $output="";
      if($request->ajax()){

        $cliente=$request->get('cliente_id');
        $nombre = strstr($cliente, '-',true);
        $cliente_id_nombre = Cliente::where("numero_documento","=",$nombre)->pluck('id');
        $contacto = Contacto::where('clientes_id','=',$cliente_id_nombre)->get();

        if($contacto){
          foreach ($contacto as $key => $contactos) {
            $output.='<option>'.$contactos->nombre.'</option>';
          }
        return Response($output);
           }
      }
    }

    public function store(Request $request){
         // Obtner ID
      $cliente=$request->get('cliente_id');
      $nombre = strstr($cliente, '-',true);
      $cliente_id_nombre=Cliente::where("numero_documento","=",$nombre)->first();
      //Contacto
      $contacto = $request->get('contacto_cliente');
      $contacto_nombre = Contacto::where('nombre','=',$contacto)->first();
      $contacto_id = $contacto_nombre->id;
        // $cliente=$request->get('cliente_id');
        // $cliente_id_nombre=Cliente::where("nombre","=",$cliente)->first();
      $cliente_id=$cliente_id_nombre->id;

      $ingeniero=$request->get('personal_lab_id');
      $ingeniero_nombre_id=Personal::where("nombres","=",$ingeniero)->first();
      $personal_lab_id=$ingeniero_nombre_id->id;

        // $nombre_cliente=$request->get('nombre_cliente');
        // $cliente= Cliente::where("nombre","=",$nombre_cliente)->first();
        // $numero_doc=$cliente->numero_documento;
      $equipo = $request->get('nombre_equipos');
      $nombre_equipo = substr(strstr($equipo, '-'),1);

        //TRAANSFORMNADO CON VALUE DE MARCA A UN ID
      $marca_nombre=$request->get('marca_id');
      $marca= Marca::where("nombre","=",$marca_nombre)->first();
      $marca_id_var=$marca->id;

      $garantia_guia_ingreso=new GarantiaGuiaIngreso;
      $garantia_guia_ingreso->motivo=$request->get('motivo');
      $garantia_guia_ingreso->fecha=$request->get('fecha');
      $garantia_guia_ingreso->orden_servicio=$request->get('orden_servicio');
      $garantia_guia_ingreso->estado=1;
      $garantia_guia_ingreso->egresado=0;
      $garantia_guia_ingreso->asunto=$request->get('asunto');

      $garantia_guia_ingreso->nombre_equipo=$nombre_equipo;

      $garantia_guia_ingreso->numero_serie=$request->get('numero_serie');
      $garantia_guia_ingreso->codigo_interno=$request->get('codigo_interno');
      $garantia_guia_ingreso->fecha_compra=$request->get('fecha_compra');
      $garantia_guia_ingreso->descripcion_problema=$request->get('descripcion_problema');
      $garantia_guia_ingreso->revision_diagnostico=$request->get('revision_diagnostico');
      $garantia_guia_ingreso->estetica=$request->get('estetica');

      $garantia_guia_ingreso->marca_id=$marca_id_var;

        // $garantia_guia_ingreso->personal_lab_id=$request->get('personal_lab_id');
      $garantia_guia_ingreso->cliente_id=$cliente_id;
      $garantia_guia_ingreso->personal_lab_id=$personal_lab_id;
        // $garantia_guia_ingreso->contacto_id=$request->get('cliente_id');
      $garantia_guia_ingreso->contacto_cliente_id = $contacto_id;

      $garantia_guia_ingreso->save();
        // $contar=GarantiaGuiaIngreso::all()->count();
      $contar=$garantia_guia_ingreso->id;

      return redirect()->route('garantia_guia_ingreso.show',$contar);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $empresa=Empresa::first();
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      return view('transaccion.garantias.guia_ingreso.show',compact('garantia_guia_ingreso','empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      $clientes=Cliente::all();
      $personales=DB::table('personal_datos_laborales')->join("personal","personal.id","=","personal_datos_laborales.personal_id")->get();
      return view('transaccion.garantias.guia_ingreso.edit',compact('garantia_guia_ingreso','clientes','personales'));
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
        // ACTUALIZACION DE ESTADO
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      $garantia_guia_ingreso->estado=0;
      $garantia_guia_ingreso->save();

      return redirect()->route('garantia_guia_ingreso.index');
    }
    public function contacto_cliente_actualizar(Request $request){
      $output="";
      if($request->ajax()){

        $cliente=$request->get('cliente_id');
        // $nombre = strstr($cliente, '-',true);
        $cliente_id_nombre = Cliente::where("nombre","=",$cliente)->pluck('id');
        $contacto = Contacto::where('clientes_id','=',$cliente_id_nombre)->get();

        if($contacto){
          foreach ($contacto as $key => $contactos) {
            $output.='<option>'.$contactos->nombre.'</option>';
          }
        return Response($output);
           }
      }
    }
    public function actualizar(Request $request, $id)
    {
      $cliente=$request->get('cliente_id');
      $cliente_nombre=Cliente::where("nombre","=",$cliente)->first();
      $cliente_id = $cliente_nombre->id;
      //Contacto
      $contacto = $request->get('contacto_cliente');
      $contacto_nombre = Contacto::where('nombre','=',$contacto)->first();
      $contacto_id = $contacto_nombre->id;

        // ACTUALIZACION DE GUIA DE INGRESO
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);

      $garantia_guia_ingreso->motivo=$request->get('motivo');

      $garantia_guia_ingreso->asunto=$request->get('asunto');
      $garantia_guia_ingreso->nombre_equipo=$request->get('nombre_equipo');
      $garantia_guia_ingreso->numero_serie=$request->get('numero_serie');
      $garantia_guia_ingreso->codigo_interno=$request->get('codigo_interno');
      $garantia_guia_ingreso->fecha_compra=$request->get('fecha_compra');
      $garantia_guia_ingreso->descripcion_problema=$request->get('descripcion_problema');
      $garantia_guia_ingreso->revision_diagnostico=$request->get('revision_diagnostico');
      $garantia_guia_ingreso->estetica=$request->get('estetica');

      $garantia_guia_ingreso->personal_lab_id=$request->get('personal_lab_id');
      $garantia_guia_ingreso->cliente_id=$cliente_id;
      $garantia_guia_ingreso->contacto_cliente_id = $contacto_id;

      $garantia_guia_ingreso->save();

      return redirect()->route('garantia_guia_ingreso.index');
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

    public function print($id){
      $mi_empresa=Empresa::first();
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
    }

    public function pdf(Request $request,$id){
      $mi_empresa=Empresa::first();
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;
      $archivo=$request->get('archivo');
      $pdf=PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf',compact('garantia_guia_ingreso','mi_empresa'));
        //     return $pdf->download();
      return $pdf->download('Guia Ingreso - '.$archivo.' .pdf');

    }

    function email($id){
      $mi_empresa=Empresa::first();
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;
      $archivo=$id.".pdf";
      $pdf=PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf',compact('garantia_guia_ingreso','mi_empresa'));
      $content=$pdf->download();
      Storage::disk('garantia_guia_ingreso')->put($archivo,$content);

      return view('transaccion.garantias.guia_ingreso.correo',compact('id'));
    }

    public function enviar(Request $request){
      $id_usuario=auth()->user()->id;
      $correo_busqueda=CreateMail::where('id_usuario',$id_usuario)->first();
      $correo=$correo_busqueda->email;

    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('sendto')  ;
        $titulo = $request->get('titulo');
        $mensaje = $request->get('mensaje');
        $bakcup=    $correo_busqueda->email_backup ;

        $file = $request->id;
        $pdfile = storage_path().'/app/public/guia_ingreso/'.$file.'.pdf';

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $newfile = $request->file('archivo');
        if($request->hasfile('archivo')){
          foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            \Storage::disk('mailbox')->put($nombre,  \File::get($file));

            $news[] = storage_path().'/app/public/'.$nombre;
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
            $message->attach(\Swift_Attachment::fromPath($pdfile));
            foreach ($news as $attachment) {
              $message->attach(\Swift_Attachment::fromPath($attachment));
            }
          }
        }else{
          $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');
          $message->attach(\Swift_Attachment::fromPath($pdfile));

        }
        if($mailer->send($message)){
          $mail = new Mailbox;
          $mail->id_usuario =auth()->user()->id;
          $mail->destinatario =$correo;
          $mail->remitente =$request->get('sendto') ;
          $mail->asunto =$request->get('titulo') ;
          $mail->mensaje =$request->get('mensaje') ;
          $mail->mensaje_sin_html =$request->get('mensaje_sin_html') ;
          $mail->archivo =$request->get('archivo') ;
          $mail->pdf = $pdfile ;
          $mail->fecha_hora =$request->get('fecha_hora') ;
          $mail-> save();

          return redirect()->route('garantia_guia_ingreso.index');
        }
        return "Something went wrong :(";



      }

    }
