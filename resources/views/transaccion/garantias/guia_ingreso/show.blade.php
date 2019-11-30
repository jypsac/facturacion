@extends('layout')

@section('title', 'Ver - Guia de Ingreso')
@section('breadcrumb', 'Ver Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index'))
@section('value_accion', 'Atras')

@section('content')

<div class="ibox" style="margin-bottom:0px;">
    <div class="table-responsive" >
        <img align="left" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="width:200px;height: 70px ;margin-top: 20px">
        <img align="right" src="{{asset('storage/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" style="width: 200px;height: 70;margin-top: 20px">
    </div>
    <div class="table-responsive" >
        <p>{{$empresa->calle}}<br>{{$empresa->correo}} / {{$empresa->telefono}} - {{$empresa->movil}}</p>
    </div>
</div>
<div class="table-responsive" align="right">
                    <div class="title-action" style="padding-top: 0;" >
                        <a href="mailto:user@gmail.com?subject=Envio de Garantia&body=Envio%20el%20link%20de%20garantia%20%20%20{{route('impresiones_ingreso' ,$garantia_guia_ingreso->id)}}" class="btn btn-white"><i class="fa fa-envelope" ></i> Gmail </a>
                        <a href="{{route('pdf_ingreso' ,$garantia_guia_ingreso->id)}}" class="btn btn-white"><i class="fa fa-file-pdf-o"></i> PDF </a>
                        <a href="{{route('impresiones_ingreso' ,$garantia_guia_ingreso->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
                    </div>
                </div>

<h2 style="text-align: center;margin-top:0px;"> <strong>Guía de Ingreso</strong></h2>

<div class="wrapper wrapper-content animated fadeIn">

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 100px;">Motivo</td>
                <th>{{$garantia_guia_ingreso->motivo}}</th>
            </tr>
        </thead>
    </table>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 70px;">Ing. Asigando</td>
                <th style="width: 200px;">{{$garantia_guia_ingreso->personal_laborales->personal_l->nombres}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->fecha}}</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;">{{$garantia_guia_ingreso->marcas_i->nombre}}</th>
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
                                <strong>{{$garantia_guia_ingreso->clientes_i->nombre}}<strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Direccion</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->clientes_i->direccion}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Telefono</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->clientes_i->telefono}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Correo</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->clientes_i->email}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Contacto</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->contactos->nombre}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Numero de Documentacion</span>
                            </td>
                            <td>
                                <strong>{{$garantia_guia_ingreso->clientes_i->numero_documento}}</strong>
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



<div class="col-lg-13">
    <div class="ibox">
        {{-- <div class="ibox-title"> --}}
        <h4>Descripcion Del Problema</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-10">
                <span id="sparkline8">
                    <div class="panel-body">
                        {!! nl2br($garantia_guia_ingreso->descripcion_problema)!!}
                    </div>
                </span>
            </div>
        </div>
    </div>
</div>



<div class="col-lg-13">
    <div class="ibox ">
        {{-- <div class="ibox-title"> --}}
        <h4>Revicion y Diagnostico</h4>
        {{-- </div> --}}
        <div class="border">
            <div class="ibox-content text-left h-10">
                <span id="sparkline8">
                    {{-- <div class="panel-body"> --}}
                    {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}
                    {{-- </div> --}}
                </span>
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
            <div class="ibox-content text-left h-50">
                <span id="sparkline8">
                    <div class="panel-body">
                        {!! nl2br($garantia_guia_ingreso->estetica)!!}
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
