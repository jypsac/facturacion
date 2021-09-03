<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Boleta/Print</title>

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
                            <h2>BOLETA ELECTRONICA</h2>
                            <h5> {{$boleta->codigo_boleta}}</h5>

                        </center>

                    </div>
                </div>
            </div><br>

            <div class="row" align="center" style="padding-bottom: 5px">
                <div class="col-sm-6" align="center">
                    <div class="form-control">
                        <h3> Datos Generales</h3>
                        <div align="left">
                            <strong>Cliente:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->cliente->nombre}}
                                @else{{$boleta->cotizacion->cliente->nombre}}
                                @endif <br>
                            <strong>R.U.C:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->cliente->numero_documento}}
                                @else{{$boleta->cotizacion->cliente->numero_documento}}
                                @endif <br>
                            <strong>Direccion:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->cliente->direccion}}
                                @else{{$boleta->cotizacion->cliente->direccion}}
                                @endif <br>
                            <strong>Condiciones de Pago:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->forma_pago->nombre }}
                                @else{{$boleta->cotizacion->forma_pago->nombre }}
                                @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong>Tipo de Moneda:</strong>
                                @if(isset($boleta->cliente_id)){{$boleta->moneda->nombre }}
                                @else{{$boleta->cotizacion->moneda->nombre }}
                                @endif <br>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6" align="center">
                 <div class="form-control" >
                     <h3>Condiciones Generales</h3>
                     <div align="left">
                        <strong>Orden de Compra:</strong>
                            {{$boleta->orden_compra}} <br>
                        <strong>Guia de Remision:</strong>
                            {{$boleta->guia_remision}} <br>
                        <strong>Fecha Emision:</strong>
                            {{$boleta->fecha_emision}} <br>
                        <strong>Fecha de Vencimiento:</strong>
                            {{$boleta->fecha_vencimiento }} <br>

                    </div>
                </div>
            </div>
            <div class="col-sm-12" align="center">
             <div class="form-control" style="border: none;height: auto" >
                 <div align="left">

                </div>
            </div>
        </div>

    </div>
    <br>
@if($boleta->tipo=="producto")
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
                            @foreach($boleta_registro as $boleta_registros)
                            <span hidden="hidden">{{$i=1}} </span>
                            <tr>
                                <td>{{$i}} </td>
                                <td>{{$boleta_registros->producto->codigo_producto}}</td>
                                <td>{{$boleta_registros->cantidad}}</td>
                                <td>{{$boleta_registros->producto->unidad_i_producto->medida}}</td>
                                <td>{{$boleta_registros->producto->nombre}} <br><strong>N/S:</strong> {{$boleta_registros->numero_serie}}</td>
                                <td>{{$boleta_registros->precio}}</td>
                                <td>{{$boleta_registros->descuento}}%</td>
                                <td>{{$boleta_registros->precio_unitario_desc}}</td>
                                <td>{{$boleta_registros->precio_unitario_desc * $boleta_registros->cantidad }}</td>
                                <td style="display: none">{{$sub_total=($boleta->op_gravada)}}
                                        S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                        {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                    </td>
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
                            <th>Codigo Servicio</th>
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
                            @foreach($boleta_registro as $boleta_registros)
                            <span hidden="hidden">{{$i=1}} </span>
                            <tr>
                                <td>{{$i}} </td>
                                <td>{{$boleta_registros->servicio->codigo_servicio}}</td>
                                <td>{{$boleta_registros->cantidad}}</td>

                                <td>{{$boleta_registros->servicio->nombre}} </td>
                                <td>{{$boleta_registros->precio}}</td>
                                <td>{{$boleta_registros->descuento}}%</td>
                                <td>{{$boleta_registros->precio_unitario_desc}}</td>
                                <td>{{$boleta_registros->precio_unitario_desc * $boleta_registros->cantidad }}</td>
                                <td style="display: none">{{$sub_total=($boleta->op_gravada)}}
                                        S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
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
                    <p class="form-control a"> S/.00</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Importe Total</p>
                    <p class="form-control a"> S/.{{round($sub_total, 2)}}</p>
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
                            Telefono : {{$boleta->user->personal->nombres }}<br>
                            Telefono : {{$boleta->user->personal->telefono }}<br>
                            Celular : {{$boleta->user->personal->celular }}<br>
                            Email : {{$boleta->user->personal->email }}<br>
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
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}

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