<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Ingreso</title>{{-- 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>

<body class="white-bg">

<div class="ibox" style=" margin-bottom:0px; width: 100%">
    <div class="table-responsive" >
        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 50px ;margin-top: 5px">
        <img align="right" src="{{asset('storage/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" style="width: 100px;height: 50px;margin-top: 5px">
    </div>
    <div class="table-responsive" ><br><br><br><br><br>
        <p align="left">{{$mi_empresa->calle}}<br>{{$mi_empresa->correo}} / {{$mi_empresa->telefono}} - {{$mi_empresa->movil}}</p>
    </div>
</div>
    <table style="width: 100%;border-collapse:separate">
    <tr>
        <th style="width: 70%;border-color: white"></th>
        <th style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto" align="center">
                <p style="margin: 5px;font-weight: 200;"> R.U.C {{$mi_empresa->ruc}}</p>
                <p style="margin: 5px;font-size: 15px">GUIA DE INGRESO</p>
                <p style="margin: 5px">{{$garantia_guia_ingreso->orden_servicio}}</p>
        </th>
    </tr>
    </table>


<div class="wrapper wrapper-content animated fadeIn">
<table style="width: 100%;border-collapse:separate">
    <tr>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto" >  
            <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
            <strong>Nombre o Empresa:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->nombre}}<br>
            <strong>{{$garantia_guia_ingreso->clientes_i->documento_identificacion}}:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>&nbsp;{{$garantia_guia_ingreso->fecha}}<br>
            <strong>Telefono:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Correo:</strong>&nbsp; {{$garantia_guia_ingreso->clientes_i->email}}<br>
            <strong>Direccion:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->direccion}}<br>
            <strong>Contacto:</strong>&nbsp;{{$garantia_guia_ingreso->contactos->nombre}}<br>
        </td>
        <th style="width: 10%;border-color: white"></th>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
            <strong>Ing. Asignado:</strong>&nbsp;{{$garantia_guia_ingreso->personal_laborales->personal_l->nombres}} {{$garantia_guia_ingreso->personal_laborales->personal_l->apellidos}}<br>
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
                <strong>Modelo:</strong>&nbsp;{{$garantia_guia_ingreso->nombre_equipo}}
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
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Descripcion del Problema</strong></center><br>
            <span> {!! nl2br($garantia_guia_ingreso->descripcion_problema)!!}</span>
            <br>
        </td>
    </tr>
</table >
<br>
<table style="width: 100%;border-collapse:separate">
    <tr>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Revision y Diagnostico</strong></center><br>
            <span> {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}</span>
            <br>
        </td>
    </tr>
</table>
<br>
<table style="width: 100%;border-collapse:separate">
    <tr>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Estetica</strong></center><br>
            <span>  {!! nl2br($garantia_guia_ingreso->estetica)!!}</span>
            <br>
        </td>
    </tr>
</table>
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

<div style="height: 100px"></div>
<br><br><br><br>

<div class="">
    <table class="table  white-bg ">
                    <tbody>
            <tr>
                <td class="blanco" style="width: 70px;border-top: none;" ><hr style="width:200px;border-top-width:0.1px"  /> </td>
                <td class="blanco" style="border-top: none;"></td>
                <td class="blanco" style="width: 70px; border-top: none;"><hr style="width:200px;border-top-width:0.1px"  /> </td>
                
            </tr>
             <tr >
               
                <th class="blanco" style="width: 200px;border-top: none;"><center>    Departamento de Servicio Tecnico <br>Ing. {{$garantia_guia_ingreso->personal_laborales->personal_l->nombres}} {{$garantia_guia_ingreso->personal_laborales->personal_l->apellidos}}</center></th>
                <th class="blanco" style="border-top: none;"></th>
                <th class="blanco" style="width: 200px; border-top: none;"><center>{{$garantia_guia_ingreso->clientes_i->nombre}}<br> ({{$garantia_guia_ingreso->clientes_i->documento_identificacion}}: {{$garantia_guia_ingreso->clientes_i->numero_documento}})  </center></th>
            </tr>
                    </tbody>
                </table>
</div>
<div style="height: 90px"></div>
<div class="footer">
        <div >
            <p><b>IMPORTANTE:</b> El plazo para el recojo del equipo es de 15 días calendario. en caso de no recoger el equipo dentro de los plazos, este será trasladado al almacén. debiendo pagar S/.20.00 por cada semana que transcurra por gastos administrativos, seguros y almacenaje. Así mismo pasado los 90 días el cliente pierde el derecho total sobre el equipo. </p>
         </div>
         <div>
              <table class="table table-bordered white-bg">
                    <tbody>
            <tr>
                <th >{{$garantia_guia_ingreso->clientes_i->nombre}}</th>
                <th >{{$garantia_guia_ingreso->orden_servicio}}</th>
                <th >{{$garantia_guia_ingreso->clientes_i->nombre}}</th>
                <th>{{$garantia_guia_ingreso->orden_servicio}}</th>
                <th >{{$garantia_guia_ingreso->clientes_i->nombre}}</th>
                <th >{{$garantia_guia_ingreso->orden_servicio}}</th>
            </tr>
                    </tbody>
                </table>
         </div>

</div>


</div>
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

