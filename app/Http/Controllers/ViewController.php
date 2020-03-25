<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoCambio;
use Carbon\Carbon;

class ViewController extends Controller
{
    public function home()
    {
        $consulta=TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first();
        
            return view('home',compact('consulta'));
        
        
        
    }
}
