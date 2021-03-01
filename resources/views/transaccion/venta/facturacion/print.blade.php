<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facturacion/Print</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- <script src="@yield('vue_js', '#')" defer></script> -->

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
        window.close();
        }
    </SCRIPT>

</head>
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">

 <div class="row">
    <div class="col-lg-12">
        <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
            <div class="row">
                <div class="col-sm-4 text-left" align="left">

                    <address class="col-sm-4" align="left">

                        <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                    </address>
                </div>
                <div class="col-sm-4">
                </div>

                <div class="col-sm-4 ">
                    <div class="form-control ruc" style="height: 125px">
                        <center>
                            <h3 style="padding-top:10px ">RUC : {{$empresa->ruc}}</h3>
                            <h2>FACTURA ELECTRONICA</h2>
                            <h5> {{$facturacion->codigo_fac}}</h5>

                        </center>

                    </div>
                </div>
            </div><br>

            <table class="table ">
                <thead>

                    <tr>
                        <td style="width: 170px"><b>Señor(es)</b></td><td style="width: 3px">:</td>
                        <td  colspan="4">
                            @if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                            @else{{$facturacion->cotizacion->cliente->nombre}}
                            @endif
                        </td>

                        <td style="width: 100px"><b>RUC</b></td><td style="width: 3px">:</td><td  style="width: 150px">
                            @if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                            @else{{$facturacion->cotizacion->cliente->numero_documento}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><b>Direccion</b></td><td style="width: 3px">:</td>
                        <td colspan="4">
                            @if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                            @else{{$facturacion->cotizacion->cliente->direccion}}
                            @endif
                        </td>

                        <td><b>Orden de Compra</b></td><td>:</td>
                        <td> {{$facturacion->orden_compra}}</td>
                    </tr>
                    <tr>
                        <td><b>Condiciones de Pago</b></td><td style="width: 3px">:</td>
                        <td colspan="4">
                            @if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                            @else{{$facturacion->cotizacion->forma_pago->nombre }}
                            @endif
                        </td>

                        <td><b>Guia Remision</b></td><td style="width: 3px">:</td>
                        <td> {{$facturacion->guia_remision}}</td>
                    </tr>
                    <tr>
                        <td><b>Fecha Emision</b></td><td style="width: 3px">:</td>
                        <td>{{$facturacion->fecha_emision}}</td>

                        <td ><b>Fecha de Vencimiento</b></td><td style="width: 3px">:</td>
                        <td >{{$facturacion->fecha_vencimiento }}</td>

                        <td><b>Tipo Moneda</b></td><td style="width: 3px">:</td>
                        <td>@if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                            @else{{$facturacion->cotizacion->moneda->nombre }}
                            @endif
                        </td>
                    </tr>
                </thead>
            </table>

            <br>
@if($facturacion->tipo=="producto")
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>Codigo Producto</th>
                            <th>Cantidad</th>
                            <th>Unid.Medida</th>
                            <th>Descripción</th>
                            <th>Valor Unitario</th>
                            <th>Dscto.%</th>
                            <th>Precio Unitario</th>
                            <th>Valor Venta </th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            @foreach($facturacion_registro as $facturacion_registros)
                            <span hidden="hidden">{{$i=1}} </span>
                            <tr>
                                <td>{{$i}} </td>
                                <td>{{$facturacion_registros->producto->codigo_producto}}</td>
                                <td>{{$facturacion_registros->cantidad}}</td>
                                <td>{{$facturacion_registros->producto->unidad_i_producto->medida}}</td>
                                <td>{{$facturacion_registros->producto->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                                <td>{{$facturacion_registros->precio}}</td>
                                <td>{{$facturacion_registros->descuento}}%</td>
                                <td>{{$facturacion_registros->precio_unitario_comi}}</td>
                                <td>{{$facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}</td>
                                <td style="display: none">
                                    {{$sub_total=($facturacion_registros->cantidad*$facturacion_registros->precio_unitario_comi)+$sub_total}}
                                    {{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                </td>
                                <p>Hola</p>
                            </tr>
                            <span hidden="hidden">{{$i++}}</span>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
@else
    <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>Codigo Producto</th>
                            <th>Cantidad</th>

                            <th>Descripción</th>
                            <th>Valor Unitario</th>
                            <th>Dscto.%</th>
                            <th>Precio Unitario</th>
                            <th>Valor Venta </th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            @foreach($facturacion_registro as $facturacion_registros)
                            <span hidden="hidden">{{$i=1}} </span>
                            <tr>
                                <td>{{$i}} </td>
                                <td>{{$facturacion_registros->servicio->codigo_servicio}}</td>
                                <td>{{$facturacion_registros->cantidad}}</td>

                                <td>{{$facturacion_registros->servicio->nombre}}</td>
                                <td>{{$facturacion_registros->precio}}</td>
                                <td>{{$facturacion_registros->descuento}}%</td>
                                <td>{{$facturacion_registros->precio_unitario_comi}}</td>
                                <td>{{$facturacion_registros->precio_unitario_comi * $facturacion_registros->cantidad }}</td>
                                <td style="display: none">
                                    {{$sub_total=($facturacion_registros->cantidad*$facturacion_registros->precio_unitario_comi)+$sub_total}}
                                    {{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                </td>
                            </tr>
                            <span hidden="hidden">{{$i++}}</span>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
@endif


            <br><br><br><br>
            <div class="row">
                <div class="col-sm-3 ">
                    <p class="form-control a"> Sub Total</p>
                    <p class="form-control a"> S/.{{round($sub_total, 2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Op. Agravada</p>
                    <p class="form-control a"> S/.00</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> IGV</p>
                    <p class="form-control a"> S/.{{round($igv_p, 2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Importe Total</p>
                    <p class="form-control a"> S/.{{$end}}</p>
                </div>
            </div><br>
            <div class="row">
                @foreach($banco as $bancos)
                <div class="col-sm-3 " align="center">
                    <p class="form-control" style="height: 100px">
                      <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 100px;height: 30px;">
                      <br>
                      N° S/. : {{$bancos->numero_soles}}
                      <br>
                      N° $ : {{$bancos->numero_dolares}}<br>

                  </p>
              </div>
              @endforeach

          </div>
          <br>

              <div class="row">
                        <div class="col-sm-3">
                            <p><u>centro de Atencion : </u></p>
                            Telefono : {{$facturacion->user->personal->nombres }}<br>
                            Telefono : {{$facturacion->user->personal->telefono }}<br>
                            Celular : {{$facturacion->user->personal->celular }}<br>
                            Email : {{$facturacion->user->personal->email }}<br>
                            Web :
                            <a href="{{$empresa->pagina_web}}" target="blank_">{{$empresa->pagina_web}}</a><br>
                        </div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>

                    </div>



      </div>
  </div>

</div>




    <style type="text/css">
        .form-control{border-radius: 10px; height: auto;}
        .ibox-tools a{color: white !important}
        .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}
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

    {{-- IMPRIMIR --}}
    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>