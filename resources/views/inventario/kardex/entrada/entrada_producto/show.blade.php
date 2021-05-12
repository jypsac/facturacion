@extends('layout')

@section('title', 'Ver')
@section('breadcrumb', 'kardex_entradas-Ver')
@section('breadcrumb2', 'kardex_entradas-Ver')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')
@section('button2', 'Nueva Entrada')
@section('config',route('kardex-entrada.create'))

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-6">
                       <div style="height:  140px"></div>
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
                        <div class="form-control ruc" >
                            <center>
                                <h3 style="padding-top:10px ">RUC : {{$mi_empresa->ruc}}</h3>
                                <h2>GUIA DE ENTRADA </h2>
                                <h4 class="text-navy">{{$kardex_entradas->codigo_guia}}</h4>
                            </center>
                        </div><br>
                        <address>
                            <img src="https://www.flaticon.es/svg/static/icons/svg/2897/2897818.svg" width="13px" alt="">:<strong>{{$kardex_entradas->almacen->nombre}} - {{$kardex_entradas->almacen->abreviatura}}</strong><br>
                            <i class=" fa fa-building">:</i>{{$kardex_entradas->almacen->direccion}}<br>
                            <i class="fa fa-phone">:</i> {{$mi_empresa->telefono}} / {{$mi_empresa->movil}} <br>
                            <strong><i class="fa fa-clock-o" aria-hidden="true"></i></strong> {{$kardex_entradas->created_at}}</span> <br>
                            <strong><i class="fa fa-shopping-cart" aria-hidden="true"></i></strong>  {{$kardex_entradas->fecha_compra}}</span>
                        </address>
                    </div>
                </div>

                <div class="table-responsive m-t">
                    <table class="table invoice-table" >
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th style="text-align: left;">Nombre/Descripcion</th>
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
                            <td>  {{$kardex_entradas_registro->producto->codigo_producto}}</td>
                            <td style="text-align: left;">
                              {{$kardex_entradas_registro->producto->nombre}}/{{$kardex_entradas_registro->producto->codigo_original}}<br>{{$kardex_entradas_registro->producto->descripcion}}
                            </td>
                            <td>{{$kardex_entradas_registro->cantidad_inicial}}</td>
                            <td>{{$moneda_nacional->simbolo}} {{$kardex_entradas_registro->precio_nacional}}</td>
                            <td style="background: #f3f3f4">{{$moneda_nacional->simbolo}}.{{$kardex_entradas_registro->precio_nacional * $kardex_entradas_registro->cantidad_inicial}}</td>

                            <td>{{$moneda_extranjera->simbolo}} {{$kardex_entradas_registro->precio_extranjero}}</td>
                            <td style="background: #f3f3f4">{{$moneda_extranjera->simbolo}}{{$moneda_nacional->precio_extranjero}}{{$kardex_entradas_registro->precio_extranjero * $kardex_entradas_registro->cantidad_inicial}}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

                    <p aling="right"><b>Nota:</b> Guia Emitada en {{$kardex_entradas->moneda->nombre}}</p>
            </div>
            <div>
                <h3>Precio Nacional Total</h3>
            </div>
            <div class="row" style="text-align: center;">
                <div class="col-sm-3 ">
                    <p class="form-control a"> Sub Total</p>
                    <p class="form-control a">{{$moneda_nacional->simbolo}}. {{$kardex_entradas->precio_nacional_total}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Op. Agravada</p>
                    <p class="form-control a">{{$moneda_nacional->simbolo}}. 00</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> IGV</p>
                    <p class="form-control a">{{$moneda_nacional->simbolo}}. {{round(($kardex_entradas->precio_nacional_total*($igv->igv_total/100)),2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Importe Total</p>
                    <p class="form-control a">{{$moneda_nacional->simbolo}}. {{round($kardex_entradas->precio_nacional_total+($kardex_entradas->precio_nacional_total*($igv->igv_total/100)),2)}}</p>
                </div>
            </div>
            <br>
            <div>
                <h3>Precio Extranjero Total </h3>
            </div>
            <div class="row" style="text-align: center;">

                <div class="col-sm-3 ">
                    <p class="form-control a"> Sub Total</p>
                    <p class="form-control a">{{$moneda_extranjera->simbolo}}. {{$kardex_entradas->precio_extranjero_total}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Op. Agravada</p>
                    <p class="form-control a">{{$moneda_extranjera->simbolo}}. 00</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> IGV</p>
                    <p class="form-control a">{{$moneda_extranjera->simbolo}}. {{round(($kardex_entradas->precio_extranjero_total*($igv->igv_total/100)),2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Importe Total</p>
                    <p class="form-control a">{{$moneda_extranjera->simbolo}}. {{round($kardex_entradas->precio_extranjero_total+($kardex_entradas->precio_extranjero_total*($igv->igv_total/100)),2)}}</p>
                </div>
            </div>
            <br>

        </div>

    </div>
</div>
</div>

<style type="text/css">
    .form-control{margin-top: 5px; border-radius: 5px}
    p#texto{
        text-align: center;
        color:black;
    }
    p.form-control.a{
        margin-bottom: 0px;
    }
</style>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection
