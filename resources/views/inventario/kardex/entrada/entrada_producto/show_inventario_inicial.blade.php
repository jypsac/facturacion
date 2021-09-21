@extends('layout')

@section('title', 'Ver')
@section('breadcrumb', 'INVENTARIO INICIAL')
@section('breadcrumb2', 'INVENTARIO INICIAL')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')
@section('button2', 'Nueva Entrada')
@section('config',route('kardex-entrada.create'))

@section('content')

<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-6">
                       <div style="height:  140px"></div>
                       <address class="col-sm-6">
                        <h5>De:</h5>
                        <i class=" fa fa-user">:</i><strong > </strong><br>
                        <i class=" fa fa-building">:</i> <br>
                        <i class="fa fa-phone">:</i>
                    </address>
                </div>
                <div class="col-sm-3">
                </div>

                <div class="col-sm-3 text-right">
                    <div class="form-control ruc" >
                        <center>
                            <h3 style="padding-top:10px ">RUC : {{$mi_empresa->ruc}}</h3>
                            <h2>INVENTARIO INICIAL</h2>
                            <h4 class="text-navy">{{$inventario_inicial->codigo_guia}}</h4>
                        </center>
                    </div><br>
                    <address>
                        <img src="https://www.flaticon.es/svg/static/icons/svg/2897/2897818.svg" width="13px" alt="">:<strong>{{$inventario_inicial->almacen->nombre}} - {{$inventario_inicial->almacen->abreviatura}}</strong><br>
                        <i class=" fa fa-building">:</i>{{$inventario_inicial->almacen->direccion}}<br>
                        <i class="fa fa-phone">:</i> {{$mi_empresa->telefono}} / {{$mi_empresa->movil}} <br>
                        <strong><i class="fa fa-clock-o" aria-hidden="true"></i></strong> {{$inventario_inicial->created_at}}</span> <br>
                        <strong><i class="fa fa-shopping-cart" aria-hidden="true"></i></strong>  {{$inventario_inicial->fecha_compra}}</span>
                    </address>
                </div>
            </div>

            <div class="table-responsive m-t">
                <table class="table invoice-table" >
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th style="width:150px">Cantidad</th>
                            <th style="width:150px">Precio </th>
                            <th style="background: #f3f3f4;width:150px">Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($kardex_entradas_registros as $kardex_entradas_registro)
                     <tr>
                        <td>
                            <select class="select2_demo_3 asf" name="articulo[]" required="" id="producto1" >
                                <option></option>
                                @foreach($productos as $producto)
                                <option value="{{$producto->id}}" @if($producto->id==$kardex_entradas_registro->id) selected=""@endif >{{$producto->nombre}}- {{$producto->codigo_original}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="background: #f3f3f4"><input type="text" class="form-control" value="{{$kardex_entradas_registro->cantidad_inicial}}"></td>

                        <td><input type="text" class="form-control" value="{{$kardex_entradas_registro->id}}"></td>
                        <td style="background: #f3f3f4"><input type="text" class="form-control" value="{{$kardex_entradas_registro->id}}"></td>
                    </tr>
                    @endforeach
                </tbody>

            </table>

            <p aling="right"><b>Nota:</b> Guia Emitada en {{$inventario_inicial->moneda->nombre}}</p>
        </div>
        <div>
            <h3>Precio Nacional Total</h3>
        </div>
        <div class="row" style="text-align: center;">
            <div class="col-sm-3 ">
                <p class="form-control a"> Sub Total</p>
                <p class="form-control a">{{$moneda_nacional->simbolo}}. {{$inventario_inicial->precio_nacional_total}}</p>
            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> Op. Agravada</p>
                <p class="form-control a">{{$moneda_nacional->simbolo}}. 00</p>
            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> IGV</p>
                <p class="form-control a">{{$moneda_nacional->simbolo}}. {{round(($inventario_inicial->precio_nacional_total*($igv->igv_total/100)),2)}}</p>
            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> Importe Total</p>
                <p class="form-control a">{{$moneda_nacional->simbolo}}. {{round($inventario_inicial->precio_nacional_total+($inventario_inicial->precio_nacional_total*($igv->igv_total/100)),2)}}</p>
            </div>
        </div>
        <br>
        <div>
            <h3>Precio Extranjero Total </h3>
        </div>
        <div class="row" style="text-align: center;">

            <div class="col-sm-3 ">
                <p class="form-control a"> Sub Total</p>
                <p class="form-control a">{{$moneda_extranjera->simbolo}}. {{$inventario_inicial->precio_extranjero_total}}</p>
            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> Op. Agravada</p>
                <p class="form-control a">{{$moneda_extranjera->simbolo}}. 00</p>
            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> IGV</p>
                <p class="form-control a">{{$moneda_extranjera->simbolo}}. {{round(($inventario_inicial->precio_extranjero_total*($igv->igv_total/100)),2)}}</p>
            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> Importe Total</p>
                <p class="form-control a">{{$moneda_extranjera->simbolo}}. {{round($inventario_inicial->precio_extranjero_total+($inventario_inicial->precio_extranjero_total*($igv->igv_total/100)),2)}}</p>
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
.form-control{border-radius: 5px;}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    font-size: 12px;
}
.select2-container--default .select2-selection--single {
    border: none;
}
span.select2.select2-container.select2-container--default{
    width: 100%!important;
    background-color: #FFFFFF;
    background-image: none;
    border-radius: 1px;
    display: block;
    padding: 3px 12px;
    border: 1px solid #e5e6e7;
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
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
    $(".select2_demo_3").select2({
        placeholder: "Seleccionar Producto",
        allowClear: true
    });
</script>

@endsection
