<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guia Informe Tecnico</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

</head>

<body class="white-bg" style="height:50%">

<div class="ibox" style="margin-bottom:0px;">
    <div class="table-responsive" >
        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 70px ;margin-top: 20px">
        <img align="right" src="{{asset('storage/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="width: 200px;height: 70px;margin-top: 20px">
    </div>
    <div class="table-responsive" >
        <p>{{$mi_empresa->calle}}<br>{{$mi_empresa->correo}} / {{$mi_empresa->telefono}} - {{$mi_empresa->movil}}</p>
    </div>
</div>
<h2 style="text-align: center;margin-top:0px;"> <strong>Guía de Informe Técnico</strong></h2>

<div class="wrapper wrapper-content animated fadeIn">
 
<div class="table-responsive">
    <table class="table table-bordered table-striped correo">
        <thead>
            <tr>
                <td style="width: 70px;">Motivo</td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;"> {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha}}</th>
                <td style="width: 70px;">Orden de Servicio</td>
                <th style="width: 70px;"> {{$garantias_informe_tecnico->orden_servicio}}</th>

            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-striped cero">
        <thead>
            <tr>

                <td style="width: 70px;">Ing. Asigando</td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</th>
                <td style="width: 70px;">Asunto</td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}</th>

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
                <th style="width: 200px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}</th>
                <td style="width: 70px;">Direccion</td>
                <th style="width: 200px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}</th>
            </tr>           
             <tr>
                <td style="width: 70px;">Telefono</td>
                <th style="width: 200px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}</th>
                <td style="width: 70px;">Correo</td>
                <th style="width: 70px;"> {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}</th>
            </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12" >
        <div class="ibox ">
          {{-- <div class="ibox-title"> --}}
            <h4>Datos del Equipo</h4>
            {{-- </div> --}}
                <table class="table table-bordered white-bg">
                    <tbody>
            <tr>
                <td style="width: 70px;">Modelo</td>
                <th style="width: 200px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}</th>
                <td style="width: 70px;">Numero de Serie </td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}</th>
            </tr>            
            <tr>
                <td style="width: 70px;">Codigo Interno</td>
                <th style="width: 200px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}</th>
                <td style="width: 70px;">Fecha de Compra</td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra}}</th>
            </tr>
            <tr>
                <td style="width: 70px;">Descripcion Del Problema</td>
                <th style="width: 200px;" colspan="3">{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema)!!}</th>               
            </tr>  
            <tr>  
            <td style="width: 70px;" >Revision y diagnostico</td>
                <th style="width: 70px;" colspan="3">{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico)!!}</th>  
            </tr> 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="col-lg-13">
    <div class="ibox ">
         {{-- <div class="ibox-title"> --}}
        <h4>Estetica</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding:10px;">
                        {!! nl2br($garantias_informe_tecnico->estetica)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-13">
    <div class="ibox  ">
         {{-- <div class="ibox-title"> --}}
        <h4>Revicion y Diagnostico</h4>
        {{-- </div > --}}
        <div class="border"> 
            <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">{!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!}

                    </div>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-13">
    <div class="ibox">
    {{-- <div class="ibox-title"> --}}
        <h4>Causas Del Problema</h4>
    {{-- </div> --}}
        <div class="border">
         <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;"> {!! nl2br($garantias_informe_tecnico->causas_del_problema)!!}

                    </div>
                </span>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="col-lg-13">
    <div class="ibox">
        {{-- <div class="ibox-title"> --}}
        <h4>Solucion</h4>
       {{-- </div > --}}
        <div class="border">
         <div class="ibox-content text-left h-10" style="padding: 0px;">
                <span id="sparkline8">
                    <div class="panel-body" style="padding: 10px;">  {!! nl2br($garantias_informe_tecnico->solucion)!!}

                    </div>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-13">
    <div class="ibox">

        {{-- <div class="ibox-title"> --}}
        <h4>Fotos</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-50">
                <span id="sparkline8">
                    <div class="panel-body">
                                 @if($garantias_informe_tecnico->image1<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image1}}" style="width: 250px;">
                            @endif

                            @if($garantias_informe_tecnico->image2<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image2}}" style="width: 250px;">
                            @endif

                            @if($garantias_informe_tecnico->image3<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image3}}" style="width: 250px;">
                            @endif

                            @if($garantias_informe_tecnico->image4<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image4}}" style="width: 250px;">
                            @endif

                            @if($garantias_informe_tecnico->image5<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image5}}" style="width: 250px;">
                            @endif

                            @if($garantias_informe_tecnico->image6<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image6}}" style="width: 250px;">
                            @endif

                            @if($garantias_informe_tecnico->image7<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image7}}" style="width: 250px;">
                            @endif

                            @if($garantias_informe_tecnico->image8<>"sin_foto")
                                <img src="{{ asset('/imagenes')}}/{{$garantias_informe_tecnico->image8}}" style="width: 250px;">
                            @endif
                    </div>
                </span>

            </div>
        </div>
    </div>
</div>
</body>
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


