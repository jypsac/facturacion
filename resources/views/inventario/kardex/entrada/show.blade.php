@extends('layout')

@section('title', 'Ver')
@section('breadcrumb', 'kardex_entradas-Ver')
@section('breadcrumb2', 'kardex_entradas-Ver')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-6">
                        <address class="col-sm-6">
                            <h5>De:</h5>
                            <i class=" fa fa-user">:</i><strong > {{$kardex_entradas->provedor->empresa}}</strong><br>
                            <i class=" fa fa-building">:</i> {{$kardex_entradas->provedor->direccion}}<br>
                            <i class="fa fa-phone">:</i> {{$kardex_entradas->provedor->celular_provedor}}
                        </address>
                    </div>
                    <div class="col-sm-3">
                    </div>

                    <div class="col-sm-3 text-right">
                        <h4>Guia Entrada</h4>
                        <h4 class="text-navy">GE-000{{$kardex_entradas->id}}</h4>
                        <span>Para:</span>
                        <address>
                            <i class=" fa fa-user">:</i><strong> {{$mi_empresa->nombre}}</strong><br>
                            <i class=" fa fa-building">:</i>{{$mi_empresa->calle}}<br>
                            <i class="fa fa-phone">:</i> {{$mi_empresa->telefono}} / {{$mi_empresa->movil}}
                        </address>
                        <p>
                            <span><strong>Fecha de la factura:</strong> {{$kardex_entradas->provedor->created_at}}</span><br/>
                        </p>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table" >
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio {{$moneda_nacional->nombre}}</th>
                                <th style="background: #f3f3f4">Precio Total {{$moneda_nacional->nombre}}</th>
                                <th>Precio {{$moneda_extranjera->nombre}}</th>
                                <th style="background: #f3f3f4">Precio Total {{$moneda_extranjera->nombre}}</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($kardex_entradas_registros as $kardex_entradas_registro)
                           <tr>
                            <td>
                                <strong>{{$kardex_entradas_registro->producto->nombre}}/{{$kardex_entradas_registro->producto->codigo_original}}</strong><br>
                                <small>{{$kardex_entradas_registro->producto->descripcion}}</small>
                            </td>
                            <td>{{$kardex_entradas_registro->cantidad_inicial}}</td>
                            <td>{{$moneda_nacional->simbolo}} {{$kardex_entradas_registro->precio_nacional}}</td>
                             <td style="background: #f3f3f4">{{$moneda_nacional->simbolo}}.{{$kardex_entradas_registro->precio_nacional * $kardex_entradas_registro->cantidad_inicial}}</td>

                            <td>{{$moneda_extranjera->simbolo}} {{$kardex_entradas_registro->precio_extranjero}}</td>
                            <td style="background: #f3f3f4">{{$moneda_extranjera->simbolo}}{{$moneda_nacional->precio_extranjero}}{{$kardex_entradas_registro->precio_extranjero * $kardex_entradas_registro->cantidad_inicial}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table><p aling="right"><b>Nota:</b> Guia Emitada en {{$kardex_entradas->moneda->nombre}}</p>
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
