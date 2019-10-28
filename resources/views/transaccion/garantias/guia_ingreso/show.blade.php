@extends('layout')

@section('title', 'Ver - Guia de Ingreso')
@section('breadcrumb', 'Ver Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index'))
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeIn">

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Datos Generales</a></li>

                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <strong>Motivo : {{$garantia_guia_ingreso->motivo}}</strong><br><br>
                            <strong>Asunto : {{$garantia_guia_ingreso->asunto}}</strong><br><br>
                            <p>Ing. Asigando : {{$garantia_guia_ingreso->ing_asignado}}</p>
                            <p>Marca : {{$garantia_guia_ingreso->marca}}</p>
                            <p>Orden de Servicio : {{$garantia_guia_ingreso->orden_servicio}}</p>
                            <p>Fecha : {{$garantia_guia_ingreso->fecha}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row m-t-lg">
        <div class="col-lg-6">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Datos de Cientes</a></li>

                </ul>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <p>Nombre o Empresa : {{$garantia_guia_ingreso->nombre_cliente}}</p>
    <p>Direccion : {{$garantia_guia_ingreso->direccion}}</p>
    <p>Telefono : {{$garantia_guia_ingreso->telefono}}</p>
    <p>Correo : {{$garantia_guia_ingreso->correo}}</p>
    <p>Contacto : {{$garantia_guia_ingreso->contacto}}</p>
    <p>Numero de Documentacion : {{$garantia_guia_ingreso->numero_documento}}</p>
</div>
</div>
</div>
</div>
</div>
<!-- <center><img src="{{asset('img/logos/logo.jpg')}}" style="width: 180px;height: 100px"></center>
                                            <center> -->
<div class="col-lg-6">
    <div class="tabs-container">
        <ul class="nav nav-tabs" role="tablist">
            <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Datos del Equipo</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" id="tab-1" class="tab-pane active">
                <div class="panel-body">
                    <p>Modelo : {{$garantia_guia_ingreso->nombre_equipo}}</p>
                    <p>Numero de Serie : {{$garantia_guia_ingreso->numero_serie}}</p>
                    <p>Codigo Interno : {{$garantia_guia_ingreso->codigo_interno}}</p>
                    <p>Fecha de Compra : {{$garantia_guia_ingreso->fecha_compra}}</p>
                    <p>-</p>
                </div>
            </div>
        </div>
    </div>
</div>
</div> --}}


<div class="ibox ">
    <div class="ibox-content">
        

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <td style="width: 70px;">Ing. Asigando</td>
                    <th style="width: 200px;">{{$garantia_guia_ingreso->ing_asignado}}</th>
                    <td style="width: 70px;">Fecha</td>
                    <th style="width: 70px;">{{$garantia_guia_ingreso->fecha}}</th>
                    <td style="width: 70px;">Marca</td>
                    <th style="width: 70px;">{{$garantia_guia_ingreso->marca}}</th>
                    <td style="width: 80px;">Orden de Servicio</td>
                    <th style="width: 120px;">{{$garantia_guia_ingreso->orden_servicio}}</th>
                </tr>
                </thead>
            </table>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <td style="width: 100px;">Asunto</td>
                    <th>{{$garantia_guia_ingreso->asunto}}</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Datos del Ciente</h5>
            </div>
            <div>
                <table class="table table-bordered white-bg">
                    <tbody>
                        <tr>
                            <td>
                                <span data-diameter="40" class="updating-chart">Nombre o Empresa </span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->nombre_cliente}}<strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Direccion</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->direccion}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Telefono</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->telefono}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Correo</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->correo}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Contacto</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->contacto}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Numero de Documentacion</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->numero_documento}}</strong>
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
                <h5>Datos del Equipo</h5>
            </div>
            <div>
                <table class="table table-bordered white-bg">
                    <tbody>
                        <tr>
                            <td>
                                <span data-diameter="40" class="updating-chart">Modelo</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->nombre_equipo}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Numero de Serie </span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->numero_serie}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Codigo Interno</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->codigo_interno}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Fecha de Compra</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->fecha_compra}}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


{{-- <div class="row m-t-lg">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-10">
                        Descripcion Del Problema
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-10" class="tab-pane active">
                    <div class="panel-body">


                        {!! nl2br($garantia_guia_ingreso->descripcion_problema)!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="col-lg-13">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Descripcion Del Problema</h5>
        </div>
        <div class="ibox-content text-left h-200">
            <span id="sparkline8">
                <div class="panel-body">
                    {!! nl2br($garantia_guia_ingreso->descripcion_problema)!!}
                </div>
            </span>
        </div>
    </div>
</div>


{{-- <div class="row m-t-lg">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-10">
                        Revicion y Diagnostico
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-10" class="tab-pane active">
                    <div class="panel-body">


                        {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="col-lg-13">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Revicion y Diagnostico</h5>
        </div>
        <div class="ibox-content text-left h-200">
            <span id="sparkline8">
                <div class="panel-body">
                    {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}
                </div>
            </span>
        </div>
    </div>
</div>

{{-- <div class="row m-t-lg">
    <div class="col-lg-12">
        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-10">
                        Estetica
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="tab-10" class="tab-pane active">
                    <div class="panel-body">

                        {!! nl2br($garantia_guia_ingreso->estetica)!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="col-lg-13">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Estetica</h5>
        </div>
        <div class="ibox-content text-left h-200">
            <span id="sparkline8">
                <div class="panel-body">
                    {!! nl2br($garantia_guia_ingreso->estetica)!!}
                </div>
            </span>
        </div>
    </div>
</div>


{{-- new view --}}



{{-- the end --}}
</div>





<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@endsection
