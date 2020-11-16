 @extends('layout')

 @section('title', 'Facturar Cotizacion')
 @section('breadcrumb', 'Facturar')
 @section('breadcrumb2', 'Facturar')
 @section('href_accion', route('cotizacion.show',$cotizacion->id))
 @section('value_accion', 'Atras')

 @section('content')
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <head>
    <script type="text/javascript">
        $(document).ready(function() {

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });


        });
    </script>
</head>
<div class="wrapper wrapper-content animated fadeInRight">
   <form action="{{route('cotizacion.facturar_store')}}"  enctype="multipart/form-data" method="post">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/logo.png')}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">RUC:202020202</h3>
                                <h2>FACTURA ELECTRONICA</h2>
                                <input type="text" value="{{$cotizacion->id}}" name="id_cotizador" hidden="hidden">
                                <p>{{$cod_fac}}</p>
                                <input type="text" value="{{$cotizacion->comisionista_id}}" name="id_comisionista" hidden="hidden">
                            </center>
                        </div>
                    </div>
                </div><br>
                <table class="table ">
                    <thead>
                        <tr>
                            <td style="width: 170px"><b>Razon Social</b></td>
                            <td style="width: 3px">:</td>
                            <td style="width: 200px" colspan="4">
                                <input type="text" class="form-control" value="{{$cotizacion->cliente->nombre}}" readonly="readonly" >
                            </td>
                            <td style="width: 140px"><b>RUC</b></td>
                            <td style="width: 3px">:</td>
                            <td>
                                <input type="text" class="form-control" value="{{$cotizacion->cliente->numero_documento}}"  readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td><b>Direccion</b></td>
                            <td style="width: 3px">:</td>
                            <td colspan="4"><input type="text" class="form-control" value="{{$cotizacion->cliente->direccion}}" readonly="readonly">
                                <td><b>Orden de Compra</b></td>
                                <td>:</td>
                                <td><input type="text" class="form-control" value="0" name="orden_compra"></td>
                            </tr>
                            <tr>
                                <td><b>Condiciones de Pago</b></td>
                                <td style="width: 3px">:</td>
                                <td colspan="4"><input type="text" class="form-control" value="{{$cotizacion->forma_pago->nombre }}" readonly="readonly"></td>
                                <td><b>Guia Remision</b></td>
                                <td style="width: 3px">:</td>
                                <td><input type="text" class="form-control" value="0" name="guia_remision"></td>
                            </tr>
                            <tr>
                                <td><b>Fecha Emision</b></td>
                                <td style="width: 3px">:</td>
                                <td><input type="date" class="form-control" value="{{date("Y-m-d")}}"  readonly="readonly" name=fecha_emision></td>
                                <td style="width: 180px"><b>Fecha de Vencimiento</b></td>
                                <td style="width: 3px">:</td>
                                <td style="width: 200px"><input type="text" class="form-control"  name="fecha_vencimiento" value="{{$cotizacion->fecha_vencimiento }}" readonly="readonly"></td>
                                <td><b>Tipo Moneda</b></td>
                                <td style="width: 3px">:</td><td><input type="text" class="form-control" value="{{$cotizacion->moneda->nombre }}" readonly="readonly" ></td>
                            </tr>
                        </thead>
                    </table>
                    <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>Codigo Producto</th>
                                    <th>Cantidad</th>
                                    <th>Descripción</th>
                                    <th>Stock</th>
                                    <th>Valor Unitario</th>
                                    <th>Valor Venta </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $index => $cotizacion_registros)
                                <tr>
                                    <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                    <td>{{$cotizacion_registros->cantidad}}</td>
                                    <td>
                                        {{$cotizacion_registros->producto->nombre}}
                                        <span style="font-size: 10px">{{$cotizacion_registros->producto->descripcion}}</span>
                                        <input type="text" class="form-control col-sm-4" name="numero_serie[{{$index}}]" placeholder="N° Serie">
                                    </td>
                                <td>{{$array_cantidad[$index]}}</td>
                                    {{-- MODIFICAR ESTA PARTE CON LOGICA DE REPROGRAMACION PARA UN NUEVO PRODUCTO DIRECTAMENTE DESDE KARDEX --}}
                                    <td>S/.{{$array[$index]}}</td>
                                    <td>{{$array[$index]*$cotizacion_registros->cantidad}}</td>

                                    
                                    <td style="display: none">{{$sub_total=($cotizacion_registros->cantidad*$array[$index])-($cotizacion_registros->cantidad*$array[$index]*$cotizacion_registros->descuento/100)+$sub_total}}
                                        S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                        {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                    </td>

                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3" rowspan="4">
                                        <div class="row">
                                            <div class="col-lg-2" align="center">
                                                <img src="https://www.codigos-qr.com/qr/php/qr_img.php?d=https%3A%2F%2Fwww.jypsac.com%2F&s=6&e=m" alt="Generador de Códigos QR Codes" height="150px" />
                                            </div>
                                            <div class="col-lg-10" align="center">
                                                <h3>
                                                    <?php $v=new CifrasEnLetras() ;
                                                    $letra=($v->convertirEurosEnLetras($end));
                                                    $letra_final = strstr($letra, 'soles',true);
                                                    $end_final=strstr($end, '.');
                                                    ?>
                                                    {{$letra_final}} {{$end_final}}/100 {{$cotizacion->moneda->nombre }}
                                                </h3>
                                                Representacion impresa de la Factura electrónica Puede ser <br>consultada en https://cloud.horizontcpe.com/ConsultaComprobanteE/<br> Autorizado mediante la Resolución de intendencia N° <br>0340050001931/SUNAT/SUNAT
                                            </div>
                                        </div>
                                    </td>
                                    <td>Sub Total</td>
                                    <td>
                                        S/.{{round($sub_total, 2)}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>IGV</td>
                                    <td>S/.{{round($igv_p, 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Importe Total</td>
                                    <td>S/.{{$end}}</td>
                                </tr>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                    <button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true">Guardar</i></button>&nbsp;
                </div>
            </div>
        </div>
    </form>
</div>


<style type="text/css">
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;}
</style>

<!-- Mainly scripts -->
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
