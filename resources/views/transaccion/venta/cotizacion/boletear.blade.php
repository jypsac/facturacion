 @extends('layout')

 @section('title', 'Boletear Cotizacion')
 @section('breadcrumb', 'Boletear')
 @section('breadcrumb2', 'Boletear')
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
    <form action="{{route('cotizacion.boletear_store')}}"  enctype="multipart/form-data" method="post">
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
                                    <h3 style="padding-top:10px ">RUC : {{$empresa->ruc}}</h3>
                                    <h2>BOLETA ELECTRONICA</h2>
                                    <input type="text" value="{{$cotizacion->id}}" name="id_cotizador" hidden="hidden">
                                    <p >{{$boleta_codigo}}</p>
                                    <input type="text" value="{{$cotizacion->comisionista_id}}" name="id_comisionista" hidden="hidden">
                                </center>
                            </div>
                        </div>
                    </div><br>
                        <table class="table ">
                            <tbody>
                                <tr>
                                    <td><b>Señor(es)</b></td>
                                    <td>:</td>
                                    <td colspan="3"><input type="text" class="form-control" value="{{$cotizacion->cliente->nombre}}" readonly="readonly" ></td>
                                    <td colspan="2"><b>RUC</b></td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" value="{{$cotizacion->cliente->numero_documento}}"  readonly="readonly"></td>
                                </tr>
                                <tr>
                                    <td><b>Direccion</b></td>
                                    <td style="width: 3px">:</td>
                                    <td colspan="3"><input type="text" class="form-control" value="{{$cotizacion->cliente->direccion}}" readonly="readonly">
                                    <td colspan="2"><b>Orden de Compra</b></td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control" value="0" name="orden_compra"></td>
                                </tr>
                                <tr>
                                    <td><b>Condiciones de Pago</b></td>
                                    <td>:</td>
                                    <td colspan="3"><input type="text" class="form-control" value="{{$cotizacion->forma_pago->nombre }}" readonly="readonly">
                                    <td colspan="2"><b>Guia Remision</b></td>
                                    <td style="width: 3px">:</td>
                                    <td><input type="text" class="form-control" value="0" name="guia_remision"></td>
                                </tr>
                                <tr>
                                    <td><b>Fecha Emision</b></td>
                                    <td>:</td>
                                    <td><input type="date" class="form-control" value="{{date("Y-m-d")}}"  readonly="readonly" name=fecha_emision></td>
                                    <td><b>Fecha de Vencimiento</b></td>
                                    <td>:</td>
                                    <td><input type="text" class="form-control"  name="fecha_vencimiento" value="{{$cotizacion->fecha_vencimiento }}" readonly="readonly"></td>
                                    <td><b>Tipo Moneda</b></td><td style="width: 3px">:</td>
                                    <td><input type="text" class="form-control" value="{{$cotizacion->moneda->nombre }}" readonly="readonly"></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th >ITEM</th>
                                    <th >Codigo Producto</th>
                                    <th >Cantidad</th>
                                    <th >Descripción</th>
                                    <th >Valor Unitario</th>
                                    <th>Valor Venta </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizacion_registro as $index => $cotizacion_registros)
                                <span hidden="hidden">{{$i=1}} </span>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                    <td>{{$cotizacion_registros->cantidad}}</td>
                                    <td>
                                        {{$cotizacion_registros->producto->nombre}}
                                        <span style="font-size: 10px">{{$cotizacion_registros->producto->descripcion}}</span>
                                        <textarea class="form-control col-sm-12" name="numero_serie[{{$index}}]" placeholder="N° Serie"></textarea>
                                    </td>
                                    <td>S/.{{$cotizacion_registros->precio}}</td>
                                    <td>{{($cotizacion_registros->cantidad*$cotizacion_registros->precio)-($cotizacion_registros->cantidad*$cotizacion_registros->precio*$cotizacion_registros->descuento/100)}}</td>
                                    <td style="display: none">{{$sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio)-($cotizacion_registros->cantidad*$cotizacion_registros->precio*$cotizacion_registros->descuento/100)+$sub_total}}
                                        S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                        {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                    </td>
                                </tr>
                                <span hidden="hidden">{{$i++}}</span>
                                @endforeach
                               
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
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
                                <p class="form-control a"> S/.0.0</p>
                            </div>
                            <div class="col-sm-3 ">
                                <p class="form-control a"> Importe Total</p>
                                <p class="form-control a"> S/.{{round($sub_total, 2)}}</p>
                            </div>
                        </div> <br>
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
                        <div class="col-sm-4">
                            <p><u>centro de Atencion : </u></p>
                            Nombre : {{$cotizacion->user_personal->personal->nombres }} <br>
                            Telefono : {{$cotizacion->user_personal->personal->telefono }}<br>
                            Celular : {{$cotizacion->user_personal->personal->celular }}<br>
                            Email : {{$cotizacion->user_personal->personal->email }}<br>
                            Web : {{$empresa->pagina_web}} <br>
                        </div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"><br><br>
                            
                        </div>

                    </div>
                        <button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp;
                </div>
            </div>
        </div>
    </form>
</div>


    <style type="text/css">
        .ruc{border-radius: 10px; height: 150px;}
        .form-control{border-radius: 10px; }
        .ibox-tools a{color: white !important}
        .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}    </style>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection
