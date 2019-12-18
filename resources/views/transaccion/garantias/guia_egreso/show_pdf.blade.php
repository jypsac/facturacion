<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Egreso</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>

<body class="white-bg">
<div class="ibox" style="margin-bottom:0px;">
    <div class="table-responsive" >
        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:100px;height: 50px ;margin-top: 5px">
        <img align="right" src="{{asset('storage/marcas/'.$garantias_guias_egreso->garantia_ingreso_i->marcas_i->imagen)}}" style="width: 100px;height: 50px;margin-top: 5px">
    </div>
    <div class="table-responsive" ><br><br><br><br><br>
        <p>{{$mi_empresa->calle}}<br>{{$mi_empresa->correo}} / {{$mi_empresa->telefono}} - {{$mi_empresa->movil}}</p>
    </div>
</div>

<h2 style="text-align: center;margin-top:0px;"> <strong>Guía de Egreso</strong></h2>

<div class="wrapper wrapper-content animated fadeIn">

<div class="table-responsive">
    <table class="table table-bordered table-striped cero">
        <thead>
            <tr>
                <td style="width: 70px;">Motivo</td>
                <th style="width: 70px;">{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;">{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">22-22--22</th>
                <td style="width: 70px;">Orden de Servicio</td>
                <th style="width: 70px;"> {{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}</th>
            </tr>   
        </thead>
    </table>
    <table class="table table-bordered table-striped cero">
        <thead>
            <tr>
                <td style="width: 70px;">Ing. Asigando</td>
                <th style="width: 70px;"> {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</th>
                <td style="width: 70px;">Asunto</td>
                <th style="width: 70px;">{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}</th>
                
            </tr>
        </thead>
    </table>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            {{-- <div class="ibox-title"> --}}
            <h4>Datos del Ciente</h4>
            {{-- </div> --}}
            <div>
                <table class="table table-bordered white-bg">
                    <tbody>
            <tr>
                <td style="width: 70px;">Nombre o Empresa</td>
                <th style="width: 200px;">{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}</th>
                <td style="width: 70px;">Direccion</td>
                <th style="width: 200px;">{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->direccion}}</th>
            </tr>
            <tr>
                <td style="width: 70px;">Telefono</td>
                <th style="width: 200px;">{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->telefono}}</th>
                <td style="width: 70px;">Correo</td>
                <th style="width: 200px;"> {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}</th>
            </tr>
             <tr>
                <td style="width: 70px;">Contacto</td>
                <th style="width: 200px;"> {{$garantias_guias_egreso->garantia_ingreso_i->contactos->nombre}}</th>
                <td style="width: 70px;">Numero de Documentacion</td>
                <th style="width: 200px;">{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}}</th>
            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            {{-- <div class="ibox-title"> --}}
            <h4>Datos del Equipo</h4>
            {{-- </div> --}}
            <div>
                <table class="table table-bordered white-bg">
                    <tbody>
            <tr>
                <td style="width: 70px;">Modelo</td>
                <th style="width: 200px;"> {{$garantias_guias_egreso->garantia_ingreso_i->nombre_equipo}}</th>
                <td style="width: 70px;">Numero de Serie</td>
                <th style="width: 200px;">{{$garantias_guias_egreso->garantia_ingreso_i->numero_serie}}</th>
            </tr>
            <tr>
                <td style="width: 70px;">Codigo Interno</td>
                <th style="width: 200px;">{{$garantias_guias_egreso->garantia_ingreso_i->codigo_interno}}</th>
                <td style="width: 70px;">Fecha de Compra</td>
                <th style="width: 200px;">{{$garantias_guias_egreso->garantia_ingreso_i->fecha_compra}}</th>
            </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<div class="col-lg-13">
    <div class="ibox">
        {{-- <div class="ibox-title"> --}}
        <h4>Descripcion Del Problema</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">
                        {!! nl2br($garantias_guias_egreso->descripcion_problema)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-13">
    <div class="ibox cero ">
        {{-- <div class="ibox-title"> --}}
        <h4>Revicion y Diagnostico</h4>
        {{-- </div> --}}
        <div class="border"> <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">
                     {!! nl2br($garantias_guias_egreso->diagnostico_solucion)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-13">
    <div class="ibox">

        {{-- <div class="ibox-title"> --}}
        <h4>Recomendaciones</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-70" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">
                         {!! nl2br($garantias_guias_egreso->recomendaciones)!!}
                    </div>
                </span>

            </div>
        </div>
    </div>
</div>

<div style="height: 150px"></div>



<div class="">
    <table class="table  white-bg ">
                    <tbody>
            <tr>
                <td class="blanco" style="width: 70px;border-top: none;" ><hr style="width:200px;"  /> </td>
                <td class="blanco" style="border-top: none;"></td>
                <td class="blanco" style="width: 70px; border-top: none;"><hr style="width:200px;"  /> </td>
                
            </tr>
             <tr >
               
                <th class="blanco" style="width: 200px;border-top: none;"><center>Departamento de Servicio Tecnico<br>Ing. {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->nombres}}
                 {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</center></th>
                <th class="blanco" style="border-top: none;"></th>
                <th class="blanco" style="width: 200px; border-top: none;"><center>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br>
                     ({{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}} :
                     {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}})</center></th>
            </tr>
                    </tbody>
                </table>
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

    </script>
