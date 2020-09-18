<?php

namespace App\Http\Controllers;

use App;
use App\Cliente;
use App\Cotizacion;
use App\EmailBandejaEnvios;
use App\EmailBandejaEnviosArchivos;
use App\EmailConfiguraciones;
use App\Empresa;
use App\Banco;
use App\Moneda;
use App\Cotizacion_Servicios;
use App\Cotizacion_factura_registro;
use App\Cotizacion_boleta_registro;
use App\Cotizacion_Servicios_factura_registro;
use App\Cotizacion_Servicios_boleta_registro;
use App\kardex_entrada_registro;
use App\Igv;
use App\GarantiaGuiaIngreso;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class EmailBandejaEnviosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $id_usuario=auth()->user()->id;
      $user=User::where('id',$id_usuario)->first();
      $clientes=Cliente::all();
      $mailbox =EmailBandejaEnvios::OrderBy('id','desc')->get();
      $mailbox_file =EmailBandejaEnviosArchivos::all();
      return view('mailbox.index',compact('mailbox','user','clientes','mailbox_file'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     return view('mailbox.create');
   }
  /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
  public function store(Request $request)
  {
    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $firma=$correo_busqueda->firma;
    $mensaje_html = $request->get('mensaje');


    if($firma == null){
      $mensaje_con_firma ='<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
   .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
    table{
      width:100%;
    }
      </style>'.$mensaje_html.'</body>';
    }else{
      $mensaje_con_firma ='<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function(){
          $("table").removeClass("table table-bordered").addClass("css");
      });
      </script>
      <style>
    .css,table,tr,td{
      padding: 15px;
      border: 1px solid black;
      border-collapse: collapse;
        }
    table{
      width:100%;
    }
      </style>'.$mensaje_html.'<br/><footer><img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="550px" height="auto" /></footer>'; 
    }


    // return $mensaje_con_firma;
    $correo=$correo_busqueda->email;

    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('remitente')  ;
        $titulo = $request->get('asunto');
        $mensaje = $mensaje_con_firma;
        $bakcup=    $correo_busqueda->email_backup ;

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $newfile = $request->file('archivos');
        if($request->hasfile('archivos')){
          foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            \Storage::disk('mailbox')->put($nombre,  \File::get($file));

            $news[] = storage_path().'/app/public/'.$nombre;
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup])->setBody($mensaje, 'text/html');
            foreach ($news as $attachment) {
              $message->attach(\Swift_Attachment::fromPath($attachment));
            }
          }
        }else{
          $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto,$bakcup ])->setBody($mensaje, 'text/html');

        }
        if($mailer->send($message)){
          $mensaje =$request->get('mensaje') ;
          $texto= strip_tags($mensaje);
          $mail = new EmailBandejaEnvios;
          $mail->id_usuario =auth()->user()->id;
          $mail->destinatario =$correo;
          $mail->remitente =$request->get('remitente') ;
          $mail->asunto =$request->get('asunto') ;
          $mail->mensaje =$mensaje_con_firma;
          $mail->mensaje_sin_html =$texto ;
          $mail->fecha_hora =Carbon::now() ;
          $mail-> save();

          $newfile2 = $request->file('archivos');
          if($request->hasfile('archivos')){
            foreach ($newfile2 as $file2) {
              $guardar_email_archivo=new EmailBandejaEnviosArchivos;
              $guardar_email_archivo->id_bandeja_envios=$mail->id;
              $guardar_email_archivo->archivo= $file2->getClientOriginalName();
              $guardar_email_archivo->fecha_hora=Carbon::now();
              $guardar_email_archivo->save();
            }
          }
          return redirect()->route('email.index');
        }
        return "Something went wrong :(";

      }

      function save(Request $request){

        $tipo = $request->get('tipo');
        $id =$request->get('id');
        $redic=$request->get('redict');
        $clientes=$request->get('cliente');

        if($tipo == 'App\Cotizacion'){
          $rutapdf = 'transaccion.venta.cotizacion.print';
          $name = 'Cotizacion_Producto_';

          $empresa=Empresa::first();

          $banco=Banco::where('estado','0')->get();
          $moneda=Moneda::where('principal',1)->first();
          $cotizacion_registro=Cotizacion_factura_registro::where('cotizacion_id',$id)->get();
          $cotizacion_registro2=Cotizacion_boleta_registro::where('cotizacion_id',$id)->get();
          foreach ($cotizacion_registro as $cotizacion_registros) {
           $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
         }

        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
         $cotizacion=Cotizacion::find($id);
         $empresa=Empresa::first();
         $sum=0;
         $igv=Igv::first();
         $sub_total=0;

         $regla=$cotizacion->tipo;
         $archivo=$name.$regla.$id.".pdf";
         $pdf=PDF::loadView($rutapdf,compact($redic,'cotizacion','empresa','cotizacion_registro','cotizacion_registro2','regla','sum','igv','array','sub_total','moneda','banco'));

         $contenido=$pdf->download();
         Storage::disk($redic)->put($archivo,$contenido);

         return view('mailbox.create',compact('archivo','clientes','redic'));

       }elseif ($tipo=='App\Cotizacion_Servicios') {

        $rutapdf = 'transaccion.venta.servicios.cotizacion.print';
        $name = 'Cotizacion_Servicio_';

        $banco=Banco::where('estado','0')->get();
        $moneda=Moneda::where('principal',1)->first();
        $cotizacion_registro=Cotizacion_Servicios_factura_registro::where('cotizacion_servicio_id',$id)->get();
        $cotizacion_registro2=Cotizacion_Servicios_boleta_registro::where('cotizacion_servicio_id',$id)->get();
        foreach ($cotizacion_registro as $cotizacion_registros) {
         $array[]=kardex_entrada_registro::where('producto_id',$cotizacion_registros->producto_id)->avg('precio');
       }

        // $cotizacion_registro=Cotizacion_registro::where('cotizacion_id',$id)->get();
       $cotizacion=Cotizacion_Servicios::find($id);
       $empresa=Empresa::first();
       $sum=0;
       $igv=Igv::first();
       $sub_total=0;
       $end=0;
       $regla=$cotizacion->tipo;

       $archivo=$name.$regla.$id.".pdf";
       $pdf=PDF::loadView($rutapdf,compact($redic,'cotizacion','empresa','cotizacion_registro','cotizacion_registro2','regla','sum','igv','array','sub_total','moneda','banco'));

       $contenido=$pdf->download();
       Storage::disk($redic)->put($archivo,$contenido);
       return view('mailbox.create',compact('archivo','clientes','redic'));

     }

     else{
      $mi_empresa=Empresa::first();
      if($tipo == 'App\GarantiaGuiaIngreso'){
        $rutapdf= 'transaccion.garantias.guia_ingreso.show_pdf';
        $garantia_guia_ingreso = $tipo::find($id);
        $name = 'Guia_Ingreso_';
      }
      elseif($tipo == 'App\GarantiaGuiaEgreso'){
        $rutapdf= 'transaccion.garantias.guia_egreso.show_pdf';
        $garantias_guias_egreso = $tipo::find($id);
        $name = 'Guia_Egreso_';
      }elseif($tipo == 'App\GarantiaInformeTecnico'){
        $rutapdf= 'transaccion.garantias.informe_tecnico.show_pdf';
        $garantias_informe_tecnico = $tipo::find($id);
        $name = 'Informe_Tecnico_';
      }
      $archivo=$name.$id.".pdf";
      $pdf=PDF::loadView($rutapdf,compact($redic,'mi_empresa'));
      $content=$pdf->download();
      Storage::disk($redic)->put($archivo,$content);
      return view('mailbox.create',compact('archivo','clientes','redic'));
    }
        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;

  }

  public function send(Request $request){

    $id_usuario=auth()->user()->id;
    $correo_busqueda=EmailConfiguraciones::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;

    /////////ENVIO DE CORREO/////// https://myaccount.google.com/u/0/lesssecureapps?pli=1 <--- VAINA DE AUTORIZACION PARA EL GMAIL

        $smtpAddress = $correo_busqueda->smtp; // = $request->smtp
        $port = $correo_busqueda->port;
        $encryption = $correo_busqueda->encryption;
        $yourEmail = $correo;
        //$mailbackup =  ; // = $request->yourmail
        $yourPassword = $correo_busqueda->password;
        $sendto = $request->get('remitente')  ;
        $titulo = $request->get('asunto');
        $mensaje = $request->get('mensaje');
        $bakcup=    $correo_busqueda->email_backup ;

        $file = $request->archivo;
        $pdf=$request->get('pdf');
        $carpet =$request->get('redict');
        $pdfile = storage_path().'/app/public/'.$carpet.'/'.$pdf;

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
          $mensaje =$request->get('mensaje') ;
          $texto= strip_tags($mensaje);
          $mail = new EmailBandejaEnvios;
          $mail->id_usuario =auth()->user()->id;
          $mail->destinatario =$correo;
          $mail->remitente =$request->get('remitente') ;
          $mail->asunto =$request->get('asunto') ;
          $mail->mensaje =$request->get('mensaje') ;
          $mail->mensaje_sin_html =$texto ;
          $mail->fecha_hora =Carbon::now();
          $mail-> save();

          $newfile2 = $request->file('archivos');
          if($request->hasfile('archivo')){
            foreach ($newfile2 as $file2) {
              $guardar_email_archivo=new EmailBandejaEnviosArchivos;
              $guardar_email_archivo->id_bandeja_envios=$mail->id;
              $guardar_email_archivo->archivo= $file2->getClientOriginalName();
              $guardar_email_archivo->fecha_hora=Carbon::now();
              $guardar_email_archivo->save();
            }
          }
          $archivo_pdf = new EmailBandejaEnviosArchivos;
          $archivo_pdf->id_bandeja_envios=$mail->id;
          $archivo_pdf->archivo=$pdf;
          $archivo_pdf->fecha_hora=Carbon::now();
          $archivo_pdf->save();

          return redirect()->route('email.index');
        }
        return "Something went wrong :(";
      }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

      $mail=EmailBandejaEnvios::find($id);
      return view('mailbox.show',compact('mail'));
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
        //
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

