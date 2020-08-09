<?php

namespace App\Http\Controllers;

use App\CreateMail;
use Illuminate\Http\Request;
use App;
use Mailbox;

class CreateMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $mailbox =App\Mailbox::all();
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
        $boton=$request->get('boton');
        if ($boton=='mensaje') {
           $hola='hola';
           return $hola;
        }/*
        $configmail = new CreateMail;
        $configmail->id_usuario = Auth::User()->id;
        $configmail->email =$request->get('email') ; //coloca
        $configmail->password = $request->get('password') ;
        $configmail->email_backup = $request->get('email_backup');
        $configmail->smtp =$request->get('smtp') ;
        $configmail->port = $request->get('port');
        $configmail->encryption= $request->get('encryp') ;
        $configmail-> save();
        return back();*/
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
