<?php

namespace App\Http\Controllers;

use App\Mailbox;
use Illuminate\Http\Request;
use App;
use Swift_Mailer;
use Swift_MailTransport;
use Swift_Message;
use Swift_Attachment;
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
         //$mail = Mailbox::all();
         return view('mailbox.send');
    }
    public function send(Request $request){



        $smtpAddress = 'smtp.gmail.com'; // = $request->smtp
        $port = 465;
        $encryption = 'ssl';
        $yourEmail = 'danielrberru@gmail.com';
        $mailbackup = ''; // = $request->yourmail
        $yourPassword = 'digimonheroes@1';
        $sendto = $request->enviara;
        $titulo = $request->titulo;
        $mensaje = $request->mensaje;

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

         $newfile = $request->file('archivo');
 
        foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();
            \Storage::disk('mailbox')->put($nombre,  \File::get($file));
            $data[] = $nombre;
            $news[] = storage_path().'/app/public/'.$nombre;
            $message = (new \Swift_Message($yourEmail)) ->setFrom([ $yourEmail => $titulo])->setTo([ $sendto ])->setBody($mensaje, 'text/html');
             foreach ($news as $attachment) {
                $message->attach(\Swift_Attachment::fromPath($attachment));
            }
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
