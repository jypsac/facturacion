<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\GarantiaInformeTecnico;

class ConsultasController extends Controller
{
    public function garantias_guias_ingreso()
    {
        $garantias_guias_ingresos=GarantiaGuiaIngreso::all();
        return view('consulta.garantia.garantias_guias_ingreso.index',compact('garantias_guias_ingresos'));
    }

    public function garantias_guias_egreso()
    {
        $garantias_guias_egresos=GarantiaGuiaEgreso::all();
        return view('consulta.garantia.garantias_guias_egreso.index',compact('garantias_guias_egresos'));
    }

    public function garantias_informe_tecnico()
    {
        $garantias_informe_tecnicos=GarantiaInformeTecnico::all();
        return view('consulta.garantia.garantias_informe_tecnico.index',compact('garantias_informe_tecnicos'));
    }
}
