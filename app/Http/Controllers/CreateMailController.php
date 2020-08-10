<?php

namespace App\Http\Controllers;

use App;
use App\CreateMail;
use App\Mailbox;
use Illuminate\Http\Request;
class CreateMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $mailbox =Mailbox::all();
       return view('mailbox.index',compact('mailbox'));
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
    $correo_busqueda=CreateMail::where('id_usuario',$id_usuario)->first();
    $correo=$correo_busqueda->email;
    $boton=$request->get('boton');

    if ($boton=='mensaje') {
        $mail = new Mailbox;
        $mail->id_usuario =auth()->user()->id;
        $mail->destinatario =$correo;
        $mail->remitente =$request->get('remitente') ;
        $mail->asunto =$request->get('asunto') ;
        $mail->mensaje =$request->get('mensaje') ;
        $mail->archivo =$request->get('archivo') ;
        $mail->pdf =$request->get('pdf') ;
        $mail->fecha_hora =$request->get('fecha_hora') ;
        $mail-> save();
        return redirect()->route('email.index');
        }
    elseif ($boton=='configuracion') {
        $configmail = new CreateMail;
        $configmail->id_usuario = Auth::User()->id;
        $configmail->email =$request->get('email') ; //coloca
        $configmail->password = $request->get('password') ;
        $configmail->email_backup = $request->get('email_backup');
        $configmail->smtp =$request->get('smtp') ;
        $configmail->port = $request->get('port');
        $configmail->encryption= $request->get('encryp') ;
        $configmail-> save();
        return 'se guardo bien confi';

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
        return 'holi';
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
