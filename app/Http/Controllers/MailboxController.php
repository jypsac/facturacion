<?php

namespace App\Http\Controllers;

use App;
use App\CreateMail;
use App\Mailbox;
use App\User;
use Illuminate\Http\Request;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;

class MailboxController extends Controller
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
        $config_email=CreateMail::where('id_usuario',$id_usuario)->get();
        return view('mailbox.configuracion.index',compact('config_email','user'));

    }
    public function send(Request $request){

        $smtpAddress = 'smtp.gmail.com'; // = $request->smtp
        $port = 465;
        $encryption = 'ssl';
        $yourEmail = 'danielrberru@gmail.com';
        $mailbackup = ''; // = $request->yourmail
        $yourPassword = '';
        $sendto = $request->enviara;
        $titulo = $request->titulo;
        $mensaje = $request->mensaje;

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

         $newfile = $request->file('archivo');
        if($request->hasfile('archivo')){
            foreach ($newfile as $file) {
                $nombre =  $file->getClientOriginalName();
                \Storage::disk('mailbox')->put($nombre,  \File::get($file));

                $news[] = storage_path().'/app/public/'.$nombre;
                $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
                 foreach ($news as $attachment) {
                    $message->attach(\Swift_Attachment::fromPath($attachment));
                }
            }
        }else{
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');

        }
        if($mailer->send($message)){
            return back();
        }
         return "Something went wrong :(";

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mailbox.configuracion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mailbox  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function show(Mailbox $mailbox)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mailbox  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function edit(Mailbox $mailbox)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mailbox  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mailbox $mailbox)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mailbox  $mailbox
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mailbox $mailbox)
    {
        //
    }
}
