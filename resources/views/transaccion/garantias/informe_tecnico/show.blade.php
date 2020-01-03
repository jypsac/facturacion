@extends('layout')

@section('title', 'Ver Informe Tecnico')
@section('breadcrumb', 'Ver informe Tecnico')
@section('breadcrumb2', 'Informe Tecnico')
@section('href_accion', route('garantia_informe_tecnico.index') )
@section('value_accion', 'Atras')

@section('content')

<div class="ibox" style="margin-bottom:0px;">
    <div class="table-responsive" >
        <img align="left" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="width:200px;height: 70px ;margin-top: 20px">
        <img align="right" src="{{asset('storage/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="width: 200px;height: 70px;margin-top: 20px">
    </div>
    <div class="table-responsive" >
        <p>{{$empresa->calle}}<br>{{$empresa->correo}} / {{$empresa->telefono}} - {{$empresa->movil}}</p>
    </div>
</div>
<div class="table-responsive" align="right">
                    <div class="title-action" style="padding-top: 0;" >
                        <form class="btn" style="text-align: none;padding-right: 0" action="{{route('pdf_informe' ,$garantias_informe_tecnico->id)}}">
                        <input type="text" name="archivo" maxlength="50" value="{{$garantias_informe_tecnico->orden_servicio}}">
                         <button type="submit" class="btn btn-white"><i class="fa fa-file-pdf-o"></i> PDF </button></form>  
                        <a href="mailto:user@gmail.com?subject=Envio de Garantia&body=Envio%20el%20link%20de%20garantia%20%20%20{{route('impresiones_informe' ,$garantias_informe_tecnico->id)}}" class="btn btn-white"><i class="fa fa-envelope" ></i> Email </a><!-- 
                        <a href="{{route('pdf_informe' ,$garantias_informe_tecnico->id)}}" class="btn btn-white"><i class="fa fa-file-pdf-o"></i> PDF </a> -->
                        <a href="{{route('impresiones_informe' ,$garantias_informe_tecnico->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
                    </div>
                </div>

<h2 style="text-align: center;margin-top:0px;"> <strong>Guía Informe Tecnico</strong></h2>

<div class="wrapper wrapper-content animated fadeIn">

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 70px;">Motivo</td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;"> {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">{{$garantias_informe_tecnico->fecha}}</th>
                <td style="width: 70px;">Orden de Servicio</td>
                <th style="width: 70px;"> {{$garantias_informe_tecnico->orden_servicio}}</th>
            </tr>
            <tr>

                <td colspan="2" style="width: 70px;">Ing. Asigando</td>
                <th colspan="2" style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</th>
                <td colspan="2" style="width: 70px;">Asunto</td>
                <th colspan="2" style="width: 70px;">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}</th>

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
                <table class="table table-bordered white-bg" >
                    <tbody>
                        <tr>
                            <td>
                                <span data-diameter="40" class="updating-chart">Nombre o Empresa </span>
                            </td>
                            <td>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Direccion</span>
                            </td>
                            <td>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Telefono</span>
                            </td>
                            <td>
                                <strong> {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Correo</span>
                            </td>
                            <td>
                                <strong> {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Contacto</span>
                            </td>
                            <td>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contactos->nombre}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Numero de Documento</span>
                            </td>
                            <td>
                                <strong> {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}}</strong>
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
            {{-- <div class="ibox-title"> --}}
            <h4>Datos del Equipo</h4>
            {{-- </div> --}}
            <div>
                <table class="table table-bordered white-bg">
                    <tbody>
                        <tr>
                            <td>
                                <span data-diameter="40" class="updating-chart">Modelo</span>
                            </td>
                            <td>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Numero de Serie </span>
                            </td>
                            <td>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Codigo Interno</span>
                            </td>
                            <td>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Fecha de Compra</span>
                            </td>
                            <td>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Descripcion Del Problema</span>
                            </td>
                            <td>
                                <p>{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema)!!}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Revision y diagnostico</span>
                            </td>
                            <td>
                                <p style="font-size: 10px">{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico)!!}</p>
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
        {{-- <div class="ibox-title"> --}}
        <h4>Estetica</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-10">
                <span id="sparkline8">
                    <div class="panel-body">
                        {!! nl2br($garantias_informe_tecnico->estetica)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>



<div class="col-lg-13">
    <div class="ibox ">
        {{-- <div class="ibox-title"> --}}
        <h4>Revisión y diagnóstico</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-10">
                <span id="sparkline8">
                    {{-- <div class="panel-body"> --}}
                   {!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!}
                    {{-- </div> --}}
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
            <div class="ibox-content text-left h-50">
                <span id="sparkline8">
                    <div class="panel-body">
                                {!! nl2br($garantias_informe_tecnico->causas_del_problema)!!}
                    </div>
                </span>

            </div>
        </div>
    </div>
</div>
<div class="col-lg-13">
    <div class="ibox">

        {{-- <div class="ibox-title"> --}}
        <h4>Solucion</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-50">
                <span id="sparkline8">
                    <div class="panel-body">
                                {!! nl2br($garantias_informe_tecnico->solucion)!!}
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



</div>


<style>
    .container {
        /* background: #e0e0e0; */
        margin: 1 1 1rem;
        height: 7rem;
        display: flex;
        align-items: start;
    }


    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }
    td{background: white;}

</style>


<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


@endsection
