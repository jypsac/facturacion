<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Ingreso</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control, .single-line {
    background-color: #FFFFFF;
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
</style>
<body class="white-bg">
{{-- <div class="ibox" style=" margin-bottom:0px; width: 100%">
    <div class="table-responsive" >

        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 50px ;margin-top: 5px">
    </div>
</div> --}}
    <table style="width: 100%;border-collapse:separate">
        <tr>
            <td style="width: auto;border-color: white" rowspan="2">
                <img align="" src="{{asset('storage/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" style="height: 75px;margin-top: 5px;width: 100;" />
            </td>
            <td style="width: 30%; ;border: 1px #e5e6e7 solid;border-radius: 4px;" align="right">
                <center>
                    <br>
                    <span style="margin: 5px;font-weight: 200;text-align: center;"> R.U.C {{$mi_empresa->ruc}}</span><br>
                    <span style="margin: 5px;font-size: 15px;text-align: center;" >GUIA DE INGRESO</span><br>
                    <span style="margin: 5px;text-align: center;" >{{$garantia_guia_ingreso->orden_servicio}}</span>
                </center>
            </td>
        </tr>
    </table>


<div class="wrapper wrapper-content animated fadeIn">
<table style="width: 100%;border-collapse:separate">
    <tr >
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
            <strong>Nombre o Empresa:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->nombre}}<br>
            <strong>{{$garantia_guia_ingreso->clientes_i->documento_identificacion}}:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>&nbsp;{{$garantia_guia_ingreso->fecha}}<br>
            <strong>Telefono:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Correo:</strong>&nbsp; {{$garantia_guia_ingreso->clientes_i->email}}<br>
            <strong>Direccion:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->direccion}}<br>
            {{-- <strong>Contacto:</strong>&nbsp;{{$garantia_guia_ingreso->contactos->nombre}}<br> --}}
        </td>
        <th style="width: 10%;border-color: white"></th>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
            <strong>Ing. Asignado:</strong>&nbsp;{{$garantia_guia_ingreso->personal_laborales->nombres}} {{$garantia_guia_ingreso->personal_laborales->apellidos}}<br>
            <strong>Motivo:</strong>&nbsp;{{$garantia_guia_ingreso->motivo}}<br>
            <strong>Marca:</strong>&nbsp;{{$garantia_guia_ingreso->marcas_i->nombre}}<br>
            <strong>Asunto:</strong>&nbsp;{{$garantia_guia_ingreso->asunto}}<br>
        </td>
    </tr>
</table>
<br>
<table style="width: 100%;border-collapse:separate">
    <tr>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Datos del Equipo</strong></center><br>

            <span style="float:left;position:relative;width: 59%">
                <strong>MODELO:</strong>&nbsp;{{$garantia_guia_ingreso->nombre_equipo}}
           </span>
            <span style="float:left;position:relative">
                 <strong>Codigo Interno:</strong>&nbsp;{{$garantia_guia_ingreso->codigo_interno}}
            </span>
            <br>
            <span style="float:left;position:relative;width: 59%">
                <strong>Número de Serie:</strong>&nbsp;{{$garantia_guia_ingreso->numero_serie}}
            </span>
            <span style="float:left;position:relative">
                <strong>Fecha de Compra:</strong>&nbsp;{{$garantia_guia_ingreso->fecha_compra}}
            </span>
            <br>
        </td>
    </tr>
</table>
<table style="width: 100%;border-collapse:separate">
    <tr>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 33%">
            <center><strong style="align-content: center;margin: 5px">Descripcion del Problema</strong></center><br>
            <span> {!! nl2br($garantia_guia_ingreso->descripcion_problema)!!}</span>
            <br>
        </td>
        {{-- &nbsp;&nbsp;&nbsp; --}}
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 33%">
            <center><strong style="align-content: center;margin: 5px">Revision y Diagnostico</strong></center><br>
            <span> {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}</span>
            <br>
        </td>
        {{-- &nbsp;&nbsp;&nbsp; --}}
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 33%">
            <center><strong style="align-content: center;margin: 5px">Estetica</strong></center><br>
            <span> {!! nl2br($garantia_guia_ingreso->estetica)!!}</span>
            <br>
        </td>
    </tr>
</table >
<br>

<br>
<br>
{{-- <div class="table-responsive">
    <table class="table table-bordered white-bg">
        <thead>
            <tr >
                <td style="width: 70px;">Motivo</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->motivo}}</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->marcas_i->nombre}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->fecha}}</th>
                <td style="width: 70px;">Orden de Servicio</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->orden_servicio}}</th>

            </tr>
            <tr>
                <td colspan="2">Ing. Asigando</td>
                <th colspan="2">{{$garantia_guia_ingreso->personal_laborales->personal_l->nombres}} {{$garantia_guia_ingreso->personal_laborales->personal_l->apellidos}}</th>
                <td colspan="2">Asunto</td>
                <th colspan="2">{{$garantia_guia_ingreso->asunto}}</th>
            </tr>
        </thead>
    </table>

</div> --}}

{{--
<div class="row">
    <div class="col-lg-12">
        <div class="ibox "> --}}
            {{-- <div class="ibox-title"> --}}
            {{-- <h4>Datos del Ciente</h4> --}}
            {{-- </div> --}}
      {{--       <div>
                <table class="table table-bordered white-bg">
                    <tbody>
            <tr>
                <td style="width: 70px;">Nombre o Empresa</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->clientes_i->nombre}}</th>
                <td style="width: 70px;">Direccion</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->clientes_i->direccion}}</th>
            </tr>
             <tr>
                <td style="width: 70px;">Telefono</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->clientes_i->telefono}}</th>
                <td style="width: 70px;">Correo</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->clientes_i->email}}</th>
            </tr>
            <tr>
                <td style="width: 70px;">Contacto</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->contactos->nombre}}</th>
                <td style="width: 70px;">Numero de documento</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->clientes_i->numero_documento}}</th>
            </tr>            <tr>
                <td style="width: 70px;">Telefono del Contacto</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->contactos->telefono}}</th>
                <td style="width: 70px;">Correo del contacto</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->contactos->email}}</th>
            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 --}}
{{-- </div>
 --}}

{{-- <div class="row">
    <div class="col-lg-12" style="
    height: 105px;
"> --}}
       {{--  <div class="ibox "> --}}
            {{-- <div class="ibox-title"> --}}
{{--             <h4>Datos del Equipo</h4> --}}
            {{-- </div> --}}
            {{-- <div>
                <table class="table table-bordered white-bg">
                    <tbody>
            <tr>
                <td style="width: 70px;">Modelo</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->nombre_equipo}}</th>
                <td style="width: 70px;">Numero de Serie </td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->numero_serie}}</th>
            </tr>
            <tr>
                <td style="width: 70px;">Codigo Interno</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->codigo_interno}}</th>
                <td style="width: 70px;">Fecha de Compra</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->fecha_compra}}</th>
            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
 --}}

{{--
<div class="col-lg-13">
    <div class="ibox cero"> --}}
        {{-- <div class="ibox-title"> --}}
{{--         <h4>Descripcion Del Problema</h4> --}}
        {{-- </div> --}}
{{--         <div class="border">
            <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding:10px;">
                        {!! nl2br($garantia_guia_ingreso->descripcion_problema)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div> --}}

{{--

<div class="col-lg-13">
    <div class="ibox cero "> --}}
        {{-- <div class="ibox-title"> --}}
        {{-- <h4>Revisión y diagnóstico</h4> --}}
        {{-- </div> --}}
{{--         <div class="border"> <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">
                    {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-13"> --}}
    {{-- <div class="ibox cero"> --}}

        {{-- <div class="ibox-title"> --}}
        {{-- <h4>Estetica</h4> --}}
        {{-- </div> --}}
{{--         <div class="border">
            <div class="ibox-content text-left h-70" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">
                        {!! nl2br($garantia_guia_ingreso->estetica)!!}
                    </div>
                </span>

            </div>
        </div>
    </div>
</div> --}}
<footer style="position:fixed;bottom:0;width:100%;height:250px;">
    <div class="">
        <table class=" white-bg ">
            <tbody>
                <tr>
                    <td class="blanco"></td>
                    <td class="blanco" style="width: 70px;border-top: none;" ><hr style="width:200px;border-top-width:0.1px"  /> </td>
                    <td class="blanco" style="border-top: none;"></td>
                    <td class="blanco" style="width: 70px; border-top: none;"><hr style="width:200px;border-top-width:0.1px"  /> </td>
                </tr>
                <tr>
                    <td class="blanco"></td>
                    <th class="blanco" style="width: 200px;border-top: none;"><center>    Departamento de Servicio Tecnico <br>Ing. {{$garantia_guia_ingreso->personal_laborales->nombres}} {{$garantia_guia_ingreso->personal_laborales->apellidos}}</center></th>
                    <th class="blanco" style="border-top: none;"></th>
                    <th class="blanco" style="width: 200px; border-top: none;"><center>{{$garantia_guia_ingreso->clientes_i->nombre}}<br> ({{$garantia_guia_ingreso->clientes_i->documento_identificacion}}: {{$garantia_guia_ingreso->clientes_i->numero_documento}})  </center></th>
                </tr>
                <tr>
                    <td colspan="6" class="blanco"><p><b>IMPORTANTE:</b> Toda revisión por garantía consta de 48 horas. El plazo para el recojo del equipo es de 15 días calendario. en caso de no recoger el equipo dentro de los plazos, este será trasladado al almacén. debiendo pagar S/.20.00 por cada semana que transcurra por gastos administrativos, seguros y almacenaje. Así mismo pasado los 90 días el cliente pierde el derecho total sobre el equipo. </p></td>
                </tr>
            </tbody>
        </table>
        <table style="border: 1px solid #EBEBEB;">
            <tbody>
                <tr align="center" style="box-sizing: border-box;border: 1px solid #EBEBEB;">
                    <th style="width:17%;border: 1px solid #EBEBEB;">{{$garantia_guia_ingreso->clientes_i->nombre}}</th>
                    <th style="width:16%">{{$garantia_guia_ingreso->orden_servicio}}</th>
                    <th style="width:17%;border: 1px solid #EBEBEB;">{{$garantia_guia_ingreso->clientes_i->nombre}}</th>
                    <th style="width:16%">{{$garantia_guia_ingreso->orden_servicio}}</th>
                    <th style="width:17%;border: 1px solid #EBEBEB;">{{$garantia_guia_ingreso->clientes_i->nombre}}</th>
                    <th style="width: 16%">{{$garantia_guia_ingreso->orden_servicio}}</th>
                </tr>
            </tbody>
        </table>
    </div>
</footer>

<style>

    *{font-size: 8px}
    .cero{
    margin-bottom: 0px;

    }
     .table-bordered .blanco {
    border: none;
}
    .blanco{border: none;
        border: medium transparent;
        }
    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }

</style>

