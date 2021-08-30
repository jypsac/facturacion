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
use App\User;
use App\Producto;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Redirect;
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
      // 0=Anulado
      // 1=Activo
      // 2=Fuera Funcion
      $marcas=Marca::where('estado',0)->get();
      $garantias_guias_ingresos=GarantiaGuiaIngreso::all();
      $garantias_guias=GarantiaGuiaIngreso::where('estado',1)->get();
      foreach ($garantias_guias as $ingreso ) {
        $date = $ingreso->created_at."+ 2 days";
        $datework = Carbon::createFromDate($date);
        $now = Carbon::now();
        if ($datework<$now){
         $garantia_guia_ingreso=GarantiaGuiaIngreso::find($ingreso->id);
         $garantia_guia_ingreso->estado=2;
         $garantia_guia_ingreso->save();
       }
     }
     return view('transaccion.garantias.guia_ingreso.index',compact('marcas','garantias_guias_ingresos'));
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $clientes=Cliente::all();
      $empresa = Empresa::first();
      $tiempo_actual = Carbon::now();
      $tiempo_actual = $tiempo_actual->format('Y-m-d');

      // Cod-Guia
      $marca_id = $request->input('marca');
      $marca_cantidad= GarantiaGuiaIngreso::where("marca_id","=",$marca_id)->count();

      $marca_t = Marca::where("id",$marca_id)->first();
      $marca_cantidad++;
      $contador=1000000;
      $marca_cantidad=$contador+$marca_cantidad;
      $marca_cantidad=(string)$marca_cantidad;
      $marca_cantidad=substr($marca_cantidad,1);
      $orden_servicio=$marca_t->abreviatura.'-'.$marca_cantidad;
      // Cod-Guia

      $productos = Producto::where('estado_anular',1)->where('marca_id',$marca_t->id)->get();

      if(count($productos) == 0){
        return redirect()->route('garantia_guia_ingreso.index')->with('repite', 'La marca escogida no cuenta con productos relacionados');
      }
      return view('transaccion.garantias.guia_ingreso.create',compact('marca_id','orden_servicio','tiempo_actual','clientes','productos','empresa','marca_t'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contacto_cliente(Request $request){
      $output=NULL;
      if($request->ajax()){
        $cliente=$request->get('cliente_id');
        $contacto=Contacto::where('clientes_id',$cliente)->get();

        if($contacto){
          foreach ($contacto as $key => $contactos) {
            $output.='<option value="'.$contactos->id.'">'.$contactos->nombre.'</option>';
          }
          return Response($output);
        }
      }
    }

    public function store(Request $request){
       // Cod-Guia
      $marca_id = $request->input('marca_id');
      $marca_cantidad= GarantiaGuiaIngreso::where("marca_id","=",$marca_id)->count();

      $marca_t = Marca::where("id",$marca_id)->first();
      $marca_cantidad++;
      $contador=1000000;
      $marca_cantidad=$contador+$marca_cantidad;
      $marca_cantidad=(string)$marca_cantidad;
      $marca_cantidad=substr($marca_cantidad,1);
      $orden_servicio=$marca_t->abreviatura.'-'.$marca_cantidad;
      // Cod-Guia

      $cliente=$request->get('cliente_id');
      $buscador_cli=Cliente::where('id',$cliente)->first();
      /*Validando Existencia del Cliente*/
      if (empty($buscador_cli)) {
        return redirect()->route('garantia_guia_ingreso.index')->withErrors(['Cliente no encontrado en los Registros.']);
      }

      $contacto=$request->get('contacto_cliente');
      if(empty($contacto) ){$contacto = null;}
      else{
        $buscador_contact=Contacto::where('id',$contacto)->where('clientes_id',$cliente)->first();
        if (empty($buscador_contact)) {$contacto = null;}//Validar si Existe y si es su cliente REspectivo
      }

        //TRAANSFORMNADO CON VALUE DE MARCA A UN ID
      $garantia_guia_ingreso=new GarantiaGuiaIngreso;
      $garantia_guia_ingreso->motivo=$request->get('motivo');
      $garantia_guia_ingreso->fecha=date('Y-m-d');
      $garantia_guia_ingreso->orden_servicio=$orden_servicio;
      $garantia_guia_ingreso->estado=1;
      $garantia_guia_ingreso->egresado=0;
      $garantia_guia_ingreso->asunto=$request->get('asunto');
      $garantia_guia_ingreso->nombre_equipo=$request->get('nombre_equipos');
      $garantia_guia_ingreso->numero_serie=$request->get('numero_serie');
      $garantia_guia_ingreso->codigo_interno=$request->get('codigo_interno');
      $garantia_guia_ingreso->fecha_compra=$request->get('fecha_compra');
      $garantia_guia_ingreso->descripcion_problema=$request->get('descripcion_problema');
      $garantia_guia_ingreso->revision_diagnostico=$request->get('revision_diagnostico');
      $garantia_guia_ingreso->estetica=$request->get('estetica');
      $garantia_guia_ingreso->marca_id=$marca_id;
      $garantia_guia_ingreso->cliente_id=$cliente;
      $garantia_guia_ingreso->personal_lab_id=Auth::user()->personal->id;
      $garantia_guia_ingreso->contacto_cliente_id=$contacto;
      $garantia_guia_ingreso->save();

      return redirect()->route('garantia_guia_ingreso.show',$garantia_guia_ingreso->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $contacto = Contacto::all();
      $empresa=Empresa::first();
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      $marcas=Marca::all();
      $usuario = User::where('personal_id',$garantia_guia_ingreso->personal_lab_id)->first();
      return view('transaccion.garantias.guia_ingreso.show',compact('garantia_guia_ingreso','empresa','contacto','marcas','usuario'));
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

      //Validacion
      if(empty($garantia_guia_ingreso)) {
        return redirect()->route('garantia_guia_ingreso.index');
      }
      if ($garantia_guia_ingreso->estado==2 or $garantia_guia_ingreso->estado==0 or $garantia_guia_ingreso->egresado==1 ) {
        return redirect()->route('garantia_guia_ingreso.index');
      }
      //Validacion

      $empresa =Empresa::first();
      $contacto =Contacto::all();
      $contactos_cli=Contacto::where('clientes_id',$garantia_guia_ingreso->cliente_id)->get();
      $clientes=Cliente::all();
      $personales=DB::table('personal_datos_laborales')->join("personal","personal.id","=","personal_datos_laborales.personal_id")->get();
      return view('transaccion.garantias.guia_ingreso.edit',compact('garantia_guia_ingreso','clientes','personales','contacto','empresa','contactos_cli'));
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
        // ACTUALIZACION DE ESTADO - ANULADO
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      $garantia_guia_ingreso->estado=0;
      $garantia_guia_ingreso->save();
      return redirect()->route('garantia_guia_ingreso.index');
    }
    public function contacto_cliente_actualizar(Request $request){
      // $output="";
      // if($request->ajax()){

      //   $cliente=$request->get('cliente_id');
      //   // $nombre = strstr($cliente, '-',true);
      //   $cliente_id_nombre = Cliente::where("nombre","=",$cliente)->pluck('id');
      //   $contacto = Contacto::where('clientes_id','=',$cliente_id_nombre)->get();

      //   if($contacto){
      //     foreach ($contacto as $key => $contactos) {
      //       $output.='<option>'.$contactos->nombre.'</option>';
      //     }
      //     return Response($output);
      //   }
      // }
    }
    public function actualizar(Request $request, $id)
    {
      $ga_ingreso=GarantiaGuiaIngreso::where('id',$id)->first();
      $contacto=$request->get('contacto');
      if(empty($contacto)) {$contacto=NULL;}

      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      $garantia_guia_ingreso->numero_serie=$request->get('numero_serie');
      $garantia_guia_ingreso->codigo_interno=$request->get('codigo_interno');
      $garantia_guia_ingreso->descripcion_problema=$request->get('descripcion_problema');
      $garantia_guia_ingreso->revision_diagnostico=$request->get('revision_diagnostico');
      $garantia_guia_ingreso->estetica=$request->get('estetica');
      if (empty($ga_ingreso->contacto_cliente_id)){ $garantia_guia_ingreso->contacto_cliente_id=$contacto; }

      //si no esta egresado y si no esta anulado
      if ($ga_ingreso->egresado==0 and $ga_ingreso->estado==1 ) {
        $garantia_guia_ingreso->save();
        return redirect()->route('garantia_guia_ingreso.show',$garantia_guia_ingreso->id);
      }
      //si esta egresado
      elseif($ga_ingreso->egresado==1 or $ga_ingreso->estado!=1 ) {
        return redirect()->route('garantia_guia_ingreso.show',$ga_ingreso->id)->withErrors(['Esta guia no puede ser Modificada.']);
      }

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
      $contacto = Contacto::all();
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
      $usuario = User::where('personal_id',$garantia_guia_ingreso->personal_lab_id)->first();
      $empresa=Empresa::first();
      return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa','contacto','usuario','empresa'));
    }

    public function pdf(Request $request,$id){
      $contacto = Contacto::all();
      $mi_empresa=Empresa::first();
      $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;
      $archivo=$request->get('archivo');
      $usuario = User::where('personal_id',$garantia_guia_ingreso->personal_lab_id)->first();
      $empresa=Empresa::first();
      $pdf=PDF::loadView('transaccion.garantias.guia_ingreso.show_pdf',compact('garantia_guia_ingreso','mi_empresa','contacto','usuario','empresa'));
            // return $pdf->download();
      return $pdf->download('Guia Ingreso - '.$archivo.' .pdf');

      // return view('transaccion.garantias.guia_ingreso.show_pdf',compact('garantia_guia_ingreso','mi_empresa'));

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
