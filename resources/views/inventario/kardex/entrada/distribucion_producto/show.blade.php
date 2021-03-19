@extends('layout')
@section('title', 'Ver')
@section('href_accion', route('kardex-entrada-Distribucion.index') )
@section('value_accion', 'Atras')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-8">
                     <address class="col-sm-8">
                        <h5>Distribuido:</h5>
                        <i class=" fa fa-user">:</i><strong > {{$mi_empresa->nombre}}</strong><br>
                        De:</i> {{$kardex_entradas->almacen->nombre}}<br>
                       Al:</i> {{$kardex_entradas->almacen->nombre}}
                    </address></div>
                    
                    <div class="col-sm-4" align="right">
                        <div class="form-control ruc" >
                            <center>
                                <h3 style="padding-top:10px ">RUC : {{$mi_empresa->ruc}}</h3>
                                <h2>GUIA DE DISTRIBUCION </h2>
                                <h4 class="text-navy">{{$kardex_entradas->codigo_guia}}</h4>
                            </center>
                        </div></div>
                    </div>
                    <div class="table-responsive m-t">
                        <table class="table invoice-table" >
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th style="text-align: left;">Nombre/Descripcion</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($kardex_entradas_registros as $kardex_entradas_registro)
                             <tr>
                                <td>  {{$kardex_entradas_registro->producto->codigo_producto}}</td>
                                <td style="text-align: left;">
                                    {{$kardex_entradas_registro->producto->nombre}}/{{$kardex_entradas_registro->producto->codigo_original}} {{$kardex_entradas_registro->producto->descripcion}}
                                </td>
                                <td>{{$kardex_entradas_registro->cantidad_inicial}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
