@extends('layout')

@section('title', 'Ver Informe Tecnico')
@section('breadcrumb', 'Ver informe Tecnico')
@section('breadcrumb2', 'Informe Tecnico')
@section('href_accion', route('garantia_informe_tecnico.index') )
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
                            <strong>Motivo : {{$garantias_informe_tecnico->motivo}}</strong><br><br>
                            <strong>Asunto : {{$garantias_informe_tecnico->asunto}}</strong><br><br>
                            <p>Ing. Asigando : {{$garantias_informe_tecnico->ing_asignado}}</p>
                            <p>Marca : {{$garantias_informe_tecnico->marca}}</p>
                            <p>Orden de Servicio : {{$garantias_informe_tecnico->orden_servicio}}</p>
                            <p>Fecha : {{$garantias_informe_tecnico->fecha}}</p>
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
                                        <p>Nombre o Empresa : {{$garantias_informe_tecnico->nombre_cliente}}</p>
                                        <p>Direccion : {{$garantias_informe_tecnico->direccion}}</p>
                                        <p>Telefono : {{$garantias_informe_tecnico->telefono}}</p>
                                        <p>Correo : {{$garantias_informe_tecnico->correo}}</p>
                                        <p>Contacto : {{$garantias_informe_tecnico->contacto}}</p>
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
                                        <p>Modelo : {{$garantias_informe_tecnico->nombre_equipo}}</p>
                                        <p>Numero de Serie : {{$garantias_informe_tecnico->numero_serie}}</p>
                                        <p>Codigo Interno : {{$garantias_informe_tecnico->codigo_interno}}</p>
                                        <p>Fecha de Compra : {{$garantias_informe_tecnico->fecha_compra}}</p>
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
                            

                            {!! nl2br($garantias_informe_tecnico->descripcion_problema)!!}
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
                                

                                {!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!}
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
                            Informe
                        </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="tab-10" class="tab-pane active">
                            <div class="panel-body">

                                {!! nl2br($garantias_informe_tecnico->informe)!!}
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
                        Imagenes
                    </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="tab-10" class="tab-pane active">
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
@stop