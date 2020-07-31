<?php

namespace App\Http\Controllers;

use App\Mailbox;
use Illuminate\Http\Request;

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
        $yourEmail = 'danielrberru@gmail.com'; // = $request->yourmail
        $yourPassword = $request->password;


        //Envio del mail al corre 
        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);

        $sendto = $request->enviara;
        $titulo = $request->titulo;
        $mensaje = $request->mensaje;
        
      
         $newfile = $request->file('archivo');
 
        foreach ($newfile as $file) {
            $nombre =  $file->getClientOriginalName();

            \Storage::disk('archivo')->put($nombre,  \File::get($file));

            //$arc =  $file->getClientOriginalName();

            $data[] = $nombre;
            $news[] = public_path().'/storage/archivos/'.$nombre;
            $message = (new \Swift_Message($yourEmail)) // nombre arriba 
             ->setFrom([ $yourEmail => $titulo])
             ->setTo([ $sendto ])
             
             ->setBody($mensaje, 'text/html');
             

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
