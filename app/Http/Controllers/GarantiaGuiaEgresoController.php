<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use Barryvdh\DomPDF\Facade as PDF;
use App\Marca;
use App\Contacto;
use App\Empresa;
use App\Cliente;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Attachment;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Auth;

class GarantiaGuiaEgresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $garantias_guias_egresos=GarantiaGuiaEgreso::all();
        return view('transaccion.garantias.guia_egreso.index',compact('garantias_guias_egresos'));
    }

    public function guias()
    {
        $marcas=Marca::all();
        $garantias_guias_ingresos=GarantiaGuiaIngreso::where('estado',1)->where('egresado',0)->get();
        return view('transaccion.garantias.guia_egreso.ingresos',compact('marcas','garantias_guias_ingresos'));

    }

    public function store(Request $request)
    {
        $id=$request->get('id');
        //consulta
        $guia_ingreso=GarantiaGuiaIngreso::where('id',$id)->first();

        //Validacion
        if (empty($guia_ingreso)){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Numero de Guia no existe en Registro.']);}
        if ($guia_ingreso->egresado==1){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Guia de Ingreso ya fue Egresada.']);}
        if ($guia_ingreso->estado==0){return redirect()->route('garantia_guia_egreso.guias')->withErrors(['Guia de Ingreso a sido anulada. por ello no puede ser Egresada.']);}
        //Validacion

        //GUIA EGRESO
        $garantia_guia_egreso=new GarantiaGuiaEgreso;
        $garantia_guia_egreso->garantia_ingreso_id=$guia_ingreso->id;
        $garantia_guia_egreso->estado=1;
        $garantia_guia_egreso->egresado=1;
        $garantia_guia_egreso->informe_tecnico=0;
        $garantia_guia_egreso->orden_servicio=$guia_ingreso->orden_servicio;
        $garantia_guia_egreso->fecha=date('Y-m-d');
        $garantia_guia_egreso->descripcion_problema=$request->get('descripcion_problema');
        $garantia_guia_egreso->diagnostico_solucion=$request->get('diagnostico_solucion');
        $garantia_guia_egreso->recomendaciones=$request->get('recomendaciones');
        $garantia_guia_egreso->save();
        //GUIA INGRESO
        $garantia_guia_ingreso=GarantiaGuiaIngreso::find($id);
        $garantia_guia_ingreso->egresado=1;
        $garantia_guia_ingreso->save();

        return redirect()->route('garantia_guia_egreso.show',$garantia_guia_egreso->id);
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
     $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
     $usuario = User::where('personal_id',$garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
     return view('transaccion.garantias.guia_egreso.show',compact('garantias_guias_egreso','empresa','contacto','usuario'));
 }


 public function create_egreso($id)
 {
    $empresa=Empresa::first();
    $garantias_guias_ingresos=GarantiaGuiaIngreso::find($id);
    if(empty($garantias_guias_ingresos)){return redirect()->route('garantia_guia_egreso.guias');}
    if($garantias_guias_ingresos->egresado!=0 or $garantias_guias_ingresos->estado==0){return redirect()->route('garantia_guia_egreso.guias');}
    return view('transaccion.garantias.guia_egreso.create_egreso',compact('garantias_guias_ingresos','empresa','id'));
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
        $guia_egreso=GarantiaGuiaEgreso::find($id);
        $guia_egreso->descripcion_problema=$request->get('descripcion_problema');
        $guia_egreso->diagnostico_solucion=$request->get('diagnostico_solucion');
        $guia_egreso->recomendaciones=$request->get('recomendaciones');
        $guia_egreso->save();
        return redirect()->route('garantia_guia_egreso.show',$guia_egreso->id);
    }

    public function print($id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        $usuario = User::where('personal_id',$garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
        return view('transaccion.garantias.guia_egreso.show_print',compact('garantias_guias_egreso','mi_empresa','contacto','usuario'));
    }

    public function pdf(Request $request,$id){
        $contacto = Contacto::all();
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        $usuario = User::where('personal_id',$garantias_guias_egreso->garantia_ingreso_i->personal_lab_id)->first();
        $archivo=$request->get('archivo');

        // return view('transaccion.garantias.guia_ingreso.show_print',compact('garantia_guia_ingreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome');
        $pdf=PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa','contacto'));
    //     return $pdf->download();
        return $pdf->download('Guia Egreso - '.$archivo.' .pdf');
    }
    function email($id){
        $mi_empresa=Empresa::first();
        $garantias_guias_egreso=GarantiaGuiaEgreso::find($id);
        // return view('transaccion.garantias.guia_egreso.show_print',compact('garantia_guia_egreso','mi_empresa'));
        // $pdf=App::make('dompdf.wrapper');
        // $pdf=loadView('welcome').;
        $archivo=$id.".pdf";
        $pdf=PDF::loadView('transaccion.garantias.guia_egreso.show_pdf',compact('garantias_guias_egreso','mi_empresa'));
        $content=$pdf->download();
        Storage::disk('garantias_guias_egreso')->put($archivo,$content);

        return view('transaccion.garantias.guia_egreso.correo',compact('id'));
    }

    public function enviar(Request $request){
       $smtpAddress = 'smtp.gmail.com'; // = $request->smtp
       $port = 465;
       $encryption = 'ssl';
        $yourEmail = 'danielrberru@gmail.com'; // = $request->yourmail
        $yourPassword = 'digimonheroes@1'; //colocar el password,


        //Envio del mail al corre
        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $sendto = $request->sendto;
        $titulo = $request->titulo;
        $mensaje = $request->mensaje;
        $file = $request->id;

        $pdfile = storage_path().'/app/public/guia_egreso/'.$file.'.pdf';

        $newfile = $request->file('archivo');

        if($request->hasfile('archivo')){
            foreach ($newfile as $dofile) {
                $nombre =  $dofile->getClientOriginalName();
                \Storage::disk('mailbox')->put($nombre,  \File::get($dofile));
                $news[] = storage_path().'/app/public/'.$nombre;
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
                $message->attach(\Swift_Attachment::fromPath($pdfile));
                foreach ($news as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }
            }
        }else{
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
            $message->attach(\Swift_Attachment::fromPath($pdfile));

        }

        if($mailer->send($message)){
           return redirect()->route('garantia_guia_egreso.index');
       }
       return "Something went wrong :(";

   }
   public function ticket_guia_egreso(Request $request){
        $ids = $request->get('id');
        // $facturacion=Facturacion::find($ids);
        $garantia_egreso = GarantiaGuiaEgreso::find($ids);
        $empresa=Empresa::first();

        $nombre_impresora = "EPSONTICKET";

        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        #Mando un numero de respuesta para saber que se conecto correctamente.
        echo 1;

         //EMPRESA
        $empresa=Empresa::first();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text("GUIA DE EGRESO\n");
        $printer->text($garantia_egreso->orden_servicio."\n");
        $printer->text("===============================\n");
        $printer->text($garantia_egreso->created_at."\n");
        $printer->text($empresa->nombre."\n");
        $printer->setEmphasis(true);
        $printer->text("RUC: ".$empresa->ruc."\n");
        // $printer->setEmphasis(false);
        $printer->text($empresa->calle." - ".$empresa->ciudad." - ".$empresa->region_provincia."\n");
        $printer->text("Telefono: ".$empresa->telefono);
        $printer->setEmphasis(false);
        $printer->text("\n===============================\n");
        //CLIENTE
        $cliente_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Cliente", ':', $garantia_egreso->garantia_ingreso_i->clientes_i->nombre);
        $printer->text($cliente_dato."\n");
        $cliente_id= sprintf('%-15.20s %-2.2s %-21.21s', $garantia_egreso->garantia_ingreso_i->clientes_i->documento_identificacion, ':', $garantia_egreso->garantia_ingreso_i->clientes_i->numero_documento);
        $printer->text($cliente_id);
        $printer->text("\n===============================\n");
        //TRABAJADOR
        $trabajador_dato = sprintf('%-15.15s %-2.2s %-21.21s', "Ing. Asignado", ':', $garantia_egreso->garantia_ingreso_i->personal_laborales->nombres);
        $printer->text($trabajador_dato."\n");
        $motivo= sprintf('%-15.15s %-2.2s %-21.21s', "Motivo", ':', $garantia_egreso->garantia_ingreso_i->motivo);
        $printer->text($motivo."\n");
        $marca= sprintf('%-15.15s %-2.2s %-21.21s', "Marca", ':', $garantia_egreso->garantia_ingreso_i->marcas_i->nombre);
        $printer->text($marca."\n");
        $asunto= sprintf('%-15.15s %-2.2s %-21.21s', "Asunto", ':', $garantia_egreso->garantia_ingreso_i->asunto);
        $printer->text($asunto);
        $printer->text("\n===============================\n");
        //DATOS DEL EQUIPO
        $modelo= sprintf('%-15.15s %-2.2s %-21.21s', "Modelo", ':', $garantia_egreso->garantia_ingreso_i->nombre_equipo);
        $printer->text($modelo."\n");
        $n_serie= sprintf('%-15.15s %-2.2s %-21.21s', "Nro.  Serie", ':', $garantia_egreso->garantia_ingreso_i->numero_serie);
        $printer->text($n_serie."\n");
        $codigo_int= sprintf('%-15.15s %-2.2s %-21.21s', "Codigo Interno", ':', $garantia_egreso->garantia_ingreso_i->codigo_interno);
        $printer->text($codigo_int."\n");
        $fecha_compra= sprintf('%-15.15s %-2.2s %-21.21s', "Fecha Compra", ':', $garantia_egreso->garantia_ingreso_i->fecha_compra);
        $printer->text($fecha_compra);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("\n===============================\n");


        $printer->feed(3);
        $printer->cut();
        $printer->pulse();
        $printer->close();
      }
}
