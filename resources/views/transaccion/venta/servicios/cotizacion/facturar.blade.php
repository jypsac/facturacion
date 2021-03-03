@extends('layout')

 @section('title', 'Facturar Servicio Cotizacion')
 @section('breadcrumb', 'Facturar Servicio')
 @section('breadcrumb2', 'Facturar Servicio')
 @section('href_accion', route('cotizacion_servicio.show',$cotizacion->id))
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
   <form action="{{route('cotizacion_servicio.facturar_store')}}"  enctype="multipart/form-data" method="post">
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
                                <input type="text" value="{{$cotizacion->id}}" name="id_cotizador" hidden="" >
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
                                <td style="width: 3px">:</td><td><input type="text" class="form-control" value="{{$cotizacion->moneda->nombre }}" readonly="readonly" > <input type="text" name="tipo_moneda" hidden="" value="{{$cotizacion->moneda->id }}"></td>
                            </tr>
                        </thead>
                    </table>
                    <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th >Codigo Producto</th>
                                    <th >Cantidad</th>
                                    <th >Descripción</th>
                                    <th >Valor Unitario</th>
                                    <th>Valor Venta </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizacion_registro as $index => $cotizacion_registros)
                                <tr>
                                    <td>{{$cotizacion_registros->servicio->codigo_servicio}}</td>
                                    <td>{{$cotizacion_registros->cantidad}}</td>
                                    <td>
                                        {{$cotizacion_registros->servicio->nombre}} / {{$cotizacion_registros->servicio->descripcion}}</span>

                                    </td>

                                    <td style="display: none">
                                         {{$coti_dec = round($cotizacion_registros->precio-($cotizacion_registros->promedio_original*$cotizacion_registros->descuento/100),2)}}
                                        {{$coti_comi = round($coti_dec+($coti_dec*$cotizacion_registros->comision/100),2)}}
                                    </td>
                                    <td>{{$moneda->simbolo}}. {{$coti_comi}}</td>
                                    <td>{{$moneda->simbolo}}. {{($coti_comi)*$cotizacion_registros->cantidad}}</td>
                                    <td style="display: none;">

                                        <br>
                                        {{$sub_total=($coti_comi+$sub_total)*$cotizacion_registros->cantidad}}
                                        S/.{{$igv_p=round($sub_total*$igv->igv_total/100, 2)}}
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
                                        {{$moneda->simbolo}}. {{round($sub_total, 2)}} <input type="text" hidden="" name="sub_total_sin_igv" value="{{round($sub_total, 2)}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td>IGV</td>
                                    <td>{{$moneda->simbolo}}. {{round($igv_p, 2)}}</td>
                                </tr>
                                <tr>
                                    <td>Importe Total</td>
                                    <td>{{$moneda->simbolo}}. {{$end}} <input type="text" name="precio_final_igv" hidden="" value="{{$end}}" ></td>
                                </tr>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                    <input type="text" name="name" maxlength="50" hidden="" value="{{$cotizacion->cod_cotizacion}}"  >
                    <input type="text" name="id" maxlength="50" hidden="" value="{{$cotizacion->id}}"  >
                    <input type="text" name="remitente" hidden=""  value="{{$cotizacion->cliente->email}}"  >
                    <div class="row" align="center">
                        <div class="col-sm-4">
                        </div>
                        <div class="  col-sm-6 alert alert-info" >
                            <p style="margin-bottom: 0px">!Al momento de Facturar se le enviará una copia al correo del cliente!</p>
                        </div>
                        <div class="col-sm-2" align="center">
                            <button class="btn btn-primary " style="margin-top: 5px" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true">Guardar</i></button>&nbsp;
                        </div>
                    </div>
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
