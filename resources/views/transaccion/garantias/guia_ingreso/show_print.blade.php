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
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 100px;">Motivo</td>
                <th></th>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 70px;">Ing. Asigando</td>
                <th style="width: 200px;"></th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;"></th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;"></th>
                <td style="width: 80px;">Orden de Servicio</td>
                <th style="width: 120px;"></th>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 100px;">Asunto</td>
                <th></th>
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
                            <td>
                                <span data-diameter="40" class="updating-chart">Nombre o Empresa </span>
                            </td>
                            <td>
                                <strong> <strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Direccion</span>
                            </td>
                            <td>
                                <strong> </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Telefono</span>
                            </td>
                            <td>
                                <strong> </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Correo</span>
                            </td>
                            <td>
                                <strong> </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Contacto</span>
                            </td>
                            <td>
                                <strong> </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Numero de Documentacion</span>
                            </td>
                            <td>
                                <strong> </strong>
                            </td>
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
            <div class="ibox-title">
            <h4>Datos del Equipo</h4>
            </div> 
            <div>
                <table class="table table-bordered white-bg">
                    <tbody>
                        <tr>
                            <td>
                                <span data-diameter="40" class="updating-chart">Modelo</span>
                            </td>
                            <td>
                                <strong>  </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Numero de Serie </span>
                            </td>
                            <td>
                                <strong> </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Codigo Interno</span>
                            </td>
                            <td>
                                <strong> </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Fecha de Compra</span>
                            </td>
                            <td>
                                <strong></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<div class="col-lg-13">
    <div class="ibox">
         <div class="ibox-title"> 
        <h4>Descripcion Del Problema</h4>
       </div> 
        <div class="border">
            <div class="ibox-content text-left h-10">
                <span id="sparkline8">
                    <div class="panel-body">
                       
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>



<div class="col-lg-13">
    <div class="ibox ">
        <div class="ibox-title"> 
        <h4>Revicion y Diagnostico</h4>
      </div>
        <div class="border">
            <div class="ibox-content text-left h-10">
                <span id="sparkline8">
             <div class="panel-body"> 
                    
                    </div> 
                </span>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-13">
    <div class="ibox">

        <div class="ibox-title">
        <h4>Estetica</h4>
       </div> 
        <div class="border">
            <div class="ibox-content text-left h-50">
                <span id="sparkline8">
                    <div class="panel-body">
                       
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
        <p style="width:200px;" align="center">Fernndo Franco Solia</p>
        <p style="width:200px;" align="center">S&R SAC-CSA EPSON</p>
    </div>
    <div class="child2" ><br>
        <hr />
        <p style="width:200px;" align="center">Cliente (Firma y DNI)</p>
    </div>
</div>
</div>

<div class="footer">
        <div >
            <p><b>IMPORTANTE:</b> El plazo para el recojo del equipo es de 15 dias calendario. en caso de no recoger el equipo dentro de los plazos, esre será trasladado al almecen. debiendo pagar S/.20.00 por cada semana que transcurra por gastos administrativos, seguros y almacenaje. Asi mismo pasado los 90 dias el cliente pierde el derecho total sobre el equipo. </p>
         </div>

</div>
<style>
    .container {
        /* background: #e0e0e0; */
        margin: 1 1 1rem;
        height: 7rem;
        display: flex;
        align-items: start;
    }

    .child1 {
        /* background: #60e0b0; */
        height: 7rem;
        padding: .2rem;

    }

    .child2 {
        /* background: #60e0b0; */
        padding: .2rem;
        height: 7rem;
        margin-left: 50%;
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


