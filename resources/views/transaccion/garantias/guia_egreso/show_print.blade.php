<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guia Egreso</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

</head>

<body class="white-bg">
<div class="ibox" style="margin-bottom:0px;">
    <div class="table-responsive" ><!-- 
        <img align="right" src="{{asset('img/logos/logo.jpg')}}" style="width: 150px;height: 100px"> -->
        <img align="left" src="{{asset('img/logos/epson.png')}}" style="width: 180px;height: 100px">
        <img align="right" src="{{asset('img/logos/epson.png')}}" style="width: 180px;height: 100px">
    </div>
</div>

<h2 style="text-align: center;margin-top:0px;"> <strong>Guía de Ingreso</strong></h2>

<div class="wrapper wrapper-content animated fadeIn">
 
<div class="table-responsive">
    <table class="table table-bordered table-striped cero" >
        <thead>
            <tr>
                <td style="width: 100px;">Motivo</td>
                <th>{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}</th>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-striped cero">
        <thead>
            <tr>
                <td style="width: 70px;">Ing. Asigando</td>
                <th style="width: 200px;"> {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->nombres}}
                 {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">22-22--22</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;">{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}}</th>
                <td style="width: 80px;">Orden de Servicio</td>
                <th style="width: 120px;"> {{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}</th>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-striped ceros">
        <thead>
            <tr>
                <td style="width: 100px;">Asunto</td>
                <th>{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}</th>
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


<div class="container">
    <div class="child1"><br>
        <hr />
        <td>Departamento de Servicio Tecnico</td>
        <p style="width:200px;" align="center">Ing. {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->nombres}}
                 {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</p>
    </div>
    <div class="child2"><br>
        <hr />
        <p style="width:200px;" align="center">{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br>
            ({{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}} :
{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}})</p>
    </div>
</div>



</div>
<style>
    .cero{
    margin-bottom: 0px;

    }
    .container {
        /* background: #e0e0e0; */
        margin: 1 1 1rem;
        height: 7rem;
        display: flex;
        align-items: start;
    margin-top:10rem;

    }

    .child1 {
        /* background: #60e0b0; */
        height: 7rem;
        padding: .2rem;
    margin-left: 120px;

    }

    .child2 {
        /* background: #60e0b0; */
        padding: .2rem;
        height: 7rem;
        margin-left: 30%;
    }

    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }

</style>

<!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>
