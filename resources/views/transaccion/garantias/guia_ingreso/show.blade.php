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

        <div class="row m-t-lg">
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
        </div>
        <div class="row m-t-lg">
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
        </div>
        <div class="row m-t-lg">
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
        </div>
        <div class="row m-t-lg">
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
        </div>

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