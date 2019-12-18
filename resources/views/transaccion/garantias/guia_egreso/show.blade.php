@extends('layout')

@section('title', 'Ver - Guia de Egreso')
@section('breadcrumb', 'Ver Guia de Egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.index'))
@section('value_accion', 'Atras')

@section('content')


<div class="ibox" style="margin-bottom:0px;">
    <div class="table-responsive" >
        <img align="left" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="width:200px;height: 70px ;margin-top: 20px">
        <img align="right" src="{{asset('storage/marcas/'.$garantias_guias_egreso->garantia_ingreso_i->marcas_i->imagen)}}" style="width: 200px;height: 70px;margin-top: 20px">
    </div>
    <div class="table-responsive" >
        <p>{{$empresa->calle}}<br>{{$empresa->correo}} / {{$empresa->telefono}} - {{$empresa->movil}}</p>
    </div>
</div>
<div class="table-responsive" align="right">
                    <div class="title-action" style="padding-top: 0;" >
                        <a href="mailto:user@gmail.com?subject=Envio de Garantia&body=Envio%20el%20link%20de%20garantia%20%20%20{{route('impresiones_egreso' ,$garantias_guias_egreso->id)}}" class="btn btn-white"><i class="fa fa-envelope" ></i> Gmail </a>
                        <a href="{{route('pdf_egreso' ,$garantias_guias_egreso->id)}}" class="btn btn-white"><i class="fa fa-file-pdf-o"></i> PDF </a>
                        <a href="{{route('impresiones_egreso' ,$garantias_guias_egreso->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
                    </div>
                </div>

<h2 style="text-align: center;margin-top:0px;"> <strong>Guía de Egreso</strong></h2>

<div class="wrapper wrapper-content animated fadeIn">

<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 70px;">Motivo</td>
                <th style="width: 70px;">{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}</th>
                <td style="width: 70px;">Marca</td>
                <th style="width: 70px;">{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}}</th>
                <td style="width: 70px;">Fecha</td>
                <th style="width: 70px;">22-22--22</th>
                <td style="width: 70px;">Orden de Servicio</td>
                <th style="width: 70px;"> {{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}</th>
            </tr>   
        </thead>
    </table>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <td style="width: 70px;">Ing. Asigando</td>
                <th style="width: 70px;"> {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</th>
                <td style="width: 70px;">Asunto</td>
                <th style="width: 70px;">{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}</th>
                
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
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Direccion</span>
                            </td>
                            <td>
                                <strong> {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->direccion}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Telefono</span>
                            </td>
                            <td>
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->telefono}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Correo</span>
                            </td>
                            <td>
                                <strong> {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Contacto</span>
                            </td>
                            <td>
                                <strong> {{$garantias_guias_egreso->garantia_ingreso_i->contactos->nombre}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="bar">Numero de Documentacion</span>
                            </td>
                            <td>
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}}</strong>
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
                                <strong> {{$garantias_guias_egreso->garantia_ingreso_i->nombre_equipo}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Numero de Serie </span>
                            </td>
                            <td>
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->numero_serie}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Codigo Interno</span>
                            </td>
                            <td>
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->codigo_interno}}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="line">Fecha de Compra</span>
                            </td>
                            <td>
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->fecha_compra}}</strong>
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
                        {!! nl2br($garantias_guias_egreso->descripcion_problema)!!}
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
                     {!! nl2br($garantias_guias_egreso->diagnostico_solucion)!!}
                    {{-- </div> --}}
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
            <div class="ibox-content text-left h-50">
                <span id="sparkline8">
                    <div class="panel-body">
                         {!! nl2br($garantias_guias_egreso->recomendaciones)!!}
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

    .child1 {
        /* background: #60e0b0; */
        height: 7rem;
        padding: .2rem;

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


<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


@endsection
