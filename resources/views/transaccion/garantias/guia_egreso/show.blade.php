@extends('layout')

@section('title', 'Ver - Guia de Egreso')
@section('breadcrumb', 'Ver Guia de Egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.index'))
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
                                <strong>Motivo : {{$garantias_guias_egreso->motivo}}</strong><br><br>
                                <strong>Asunto : {{$garantias_guias_egreso->asunto}}</strong><br><br>
                                <p>Ing. Asigando : {{$garantias_guias_egreso->ing_asignado}}</p>
                                <p>Marca : {{$garantias_guias_egreso->marca}}</p>
                                <p>Orden de Servicio : {{$garantias_guias_egreso->orden_servicio}}</p>
                                <p>Fecha : {{$garantias_guias_egreso->fecha}}</p>
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
                                            <p>Nombre o Empresa : {{$garantias_guias_egreso->nombre_cliente}}</p>
                                            <p>Direccion : {{$garantias_guias_egreso->direccion}}</p>
                                            <p>Telefono : {{$garantias_guias_egreso->telefono}}</p>
                                            <p>Correo : {{$garantias_guias_egreso->correo}}</p>
                                            <p>Contacto : {{$garantias_guias_egreso->contacto}}</p>
                                            <p>Numero de Documentacion : {{$garantias_guias_egreso->numero_documento}}</p>
                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Datos del Equipo</a></li>
                                    
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <p>Modelo : {{$garantias_guias_egreso->nombre_equipo}}</p>
                                            <p>Numero de Serie : {{$garantias_guias_egreso->numero_serie}}</p>
                                            <p>Codigo Interno : {{$garantias_guias_egreso->codigo_interno}}</p>
                                            <p>Fecha de Compra : {{$garantias_guias_egreso->fecha_compra}}</p>
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
                                

                                {!! nl2br($garantias_guias_egreso->descripcion_problema)!!}
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
                                Diagnostico y Solucion
                            </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-10" class="tab-pane active">
                                <div class="panel-body">
                                    
    
                                    {!! nl2br($garantias_guias_egreso->diagnostico_solucion)!!}
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
                                Recomendaciones
                            </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-10" class="tab-pane active">
                                <div class="panel-body">
    
                                    {!! nl2br($garantias_guias_egreso->recomendaciones)!!}
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