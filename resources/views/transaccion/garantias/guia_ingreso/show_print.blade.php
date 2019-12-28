<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guia Ingreso</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
        window.close();
        }
    </SCRIPT>

</head>

{{-- LLAMADO AL BODY EN FUNCION CERRAR CON UNA DURACION DE 10 SEGUNDOS --}}
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">

<div class="ibox" style="margin-bottom:0px;">
    <div class="table-responsive" >
        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 70px ;margin-top: 20px">
        <img align="right" src="{{asset('storage/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" style="width: 200px;height: 70px;margin-top: 20px">
    </div>
    <div class="table-responsive" >
        <p>{{$mi_empresa->calle}}<br>{{$mi_empresa->correo}} / {{$mi_empresa->telefono}} - {{$mi_empresa->movil}}</p>
    </div>
</div>

<h2 style="text-align: center;margin-top:0px;"> <strong>Guía de Ingreso</strong></h2>

<div class="wrapper wrapper-content animated fadeIn">
 
<div class="table-responsive">
    <table class="table table-bordered table-striped cero">
        <thead>
            <tr>
                <td style="width: 100px;">Motivo</td>
                <th style="width: 100px;">{{$garantia_guia_ingreso->motivo}}</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->marcas_i->nombre}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->fecha}}</th>
                <td style="width: 70px;">Orden de Servicio</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->orden_servicio}}</th>
                
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-striped cero">
        <thead>
            <tr>
                <td style="width: 70px;">Ing. Asigando</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->personal_laborales->personal_l->nombres}} {{$garantia_guia_ingreso->personal_laborales->personal_l->apellidos}}</th>
                <td style="width: 70px;">Asunto</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->asunto}}</th>
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

</div>


<div class="row">
    <div class="col-lg-12" style="
    height: 105px;
">
        <div class="ibox ">
            {{-- <div class="ibox-title"> --}}
            <h4>Datos del Equipo</h4>
            {{-- </div> --}}
            <div>
                <table class="table table-bordered white-bg">
                    <tbody>
            <tr>
                <td style="width: 70px;">Modelo</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->nombre_equipo}}</th>
                <td style="width: 70px;">Numero de Serie </td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->numero_serie}}</th>
            </tr>            <tr>
                <td style="width: 70px;">Codigo Interno</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->codigo_interno}}</th>
                <td style="width: 70px;">Fecha de Compra</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->fecha_compra}}</th>
            </tr>      
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<div class="col-lg-13">
    <div class="ibox cero">
        {{-- <div class="ibox-title"> --}}
        <h4>Descripcion Del Problema</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding:10px;">
                        {!! nl2br($garantia_guia_ingreso->descripcion_problema)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>



<div class="col-lg-13">
    <div class="ibox cero ">
        {{-- <div class="ibox-title"> --}}
        <h4>Revisión y diagnóstico</h4>
        {{-- </div> --}}
        <div class="border"> <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">
                    {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-13">
    <div class="ibox cero">

        {{-- <div class="ibox-title"> --}}
        <h4>Estetica</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-70" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">
                        {!! nl2br($garantia_guia_ingreso->estetica)!!}
                    </div>
                </span>

            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="child1"><br>
        <hr />
        <p style="width:250px;" align="center">Departamento de Servicio Tecnico <br>
        Ing. {{$garantia_guia_ingreso->personal_laborales->personal_l->nombres}} {{$garantia_guia_ingreso->personal_laborales->personal_l->apellidos}}</p>
    </div>
    <div class="child2"><br>
        <hr />
        <p style="width:200px;" align="center">{{$garantia_guia_ingreso->clientes_i->nombre}}<br> ({{$garantia_guia_ingreso->clientes_i->documento_identificacion}}: {{$garantia_guia_ingreso->clientes_i->numero_documento}})</p>
    </div>
</div>

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
    .cero{
    margin-bottom: 0px;

    }
    .container {
        /* background: #e0e0e0; */
        margin: 1 1 1rem;
        height: 7rem;
        display: flex;
        align-items: start;
    margin-top:8rem;

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

    {{-- IMPRIMIR --}}
    <script type="text/javascript">
        window.print();
    </script>


