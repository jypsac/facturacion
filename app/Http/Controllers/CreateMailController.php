<?php

namespace App\Http\Controllers;

use App\CreateMail;
use Illuminate\Http\Request;
use App;

class CreateMailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mailbox.config');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       $cmail= new CreateMail;
       $cmail->id_usuario = Auth::user()->id;
       $cmail->email = $request->emai;
       $cmail->password = $request->password;
       $cmail->email_backup = $request->bakupmail;
       $cmail->smtp = $request->smtp;
       $cmail->port = $request->port;
       $cmail->encryption = $request->encryp;
       $cmail->save();
       return back();
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
     * @param  \App\CreateMail  $createMail
     * @return \Illuminate\Http\Response
     */
    public function show(CreateMail $createMail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CreateMail  $createMail
     * @return \Illuminate\Http\Response
     */
    public function edit(CreateMail $createMail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CreateMail  $createMail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreateMail $createMail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CreateMail  $createMail
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreateMail $createMail)
    {
        //
    }
}
