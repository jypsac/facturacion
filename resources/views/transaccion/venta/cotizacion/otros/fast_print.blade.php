<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cotizacion- Impresion</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>

</head>

{{-- LLAMADO AL BODY EN FUNCION CERRAR CON UNA DURACION DE 10 SEGUNDOS --}}
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="wrapper wrapper-content animated fadeInRight">
        {{--  --}}
        <div class="wrapper wrapper-content animated fadeInRight">
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

                            <div class="col-sm-4">
                                <div class="form-control" align="center" style="height: auto;">
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">COTIZACION ELECTRONICA</h2>
                                    <h5> COTPF 001-0000000{{$codigo}}</h5>
                                </div>
                            </div>
                        </div><br>
                        <div class="row" align="center" style="padding-bottom: 5px">
                            <div class="col-sm-6" align="center">
                                <div class="form-control">
                                    <h3>Contacto Cliente</h3>
                                    <div align="left">
                                        <strong>Señor(es):</strong> &nbsp;{{$cliente_id->nombre}}<br>
                                        <strong>{{$cliente_id->documento_identificacion}} :</strong> &nbsp;{{$cliente_id->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Fecha:</strong> &nbsp;{{$fecha_emision}}<br>
                                        <strong>Direccion:</strong>&nbsp; {{$cliente_id->direccion}}<br>
                                        <strong>Telefono:</strong>&nbsp; {{$cliente_id->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <strong>Celular:</strong>&nbsp; {{$cliente_id->celular}}<br>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                               <div class="form-control" >
                                   <h3>Condiciones Generales</h3>
                                   <div align="left">
                                    <strong>Forma De Pago:</strong> &nbsp;{{$forma_pago_id }}<br>
                                    <strong>Validez :</strong> &nbsp;{{$validez}}<br>
                                    <strong>Garantia:</strong> &nbsp;{{$garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <strong>Tipo de Moneda:</strong> &nbsp;{{$moneda_id->nombre}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                           <div class="form-control" style="border: none;height: auto" >
                               <div align="left">
                                <strong>observaciones:</strong> &nbsp;{{$observacion }}<br>
                            </div>
                        </div>
                    </div>

                </div><br>
                <div class="table-responsive">
                    <table class="table " >
                        <thead>
                           <tr >
                            <th>ITEM </th>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>P.Unitario</th>
                            <th>Total<span >{{$moneda_id->simbolo}}</span></th>
                        </tr>
                    </thead>
                    <tbody> <span hidden="">{{$i=1}}</span>
                     @foreach ($producto_id as $index => $producto_ids)
                     <tr>
                        <td>{{$i++}}</td>
                        <td>{{$articulos[$index]}}</td>
                        <td>{{$cantidad[$index]}}</td>
                        <td>{{$moneda_id->simbolo}}{{$precio[$index]}}</td>
                        <td>{{$moneda_id->simbolo}}{{$cantidad[$index] *$precio[$index]}}</td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!-- /table-responsive -->

        <footer style="padding-top: 120px">
         <h3 align="left">
            <?php $v=new CifrasEnLetras() ;
            $letra=($v->convertirEurosEnLetras($end));
            $letra_final = strstr($letra, 'soles',true);
            ?>
            Son : {{$letra_final}} {{$end_final}}/100 {{$moneda_id->nombre }}
        </h3>

        <div class="row">
            <div class="col-sm-3 ">
                <p class="form-control a"> Sub Total</p>
                <p class="form-control a">{{$moneda_id->simbolo}}{{$costo_sub_total}}</p>
            </div>

            <div class="col-sm-3 ">
                <p class="form-control a"> Op. Agravada</p>
                <p class="form-control a">{{$moneda_id->simbolo}}00.00</p>
            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> IGV</p>
                <p class="form-control a">{{$moneda_id->simbolo}}{{$costo_igv}}</p>

            </div>
            <div class="col-sm-3 ">
                <p class="form-control a"> Importe Total</p>
                <p class="form-control a">{{$moneda_id->simbolo}}{{$costo_total}}</p>
            </div>
        </div>
    </footer>

    <br>
    <!-- Fin Totales de Productos -->
    <div class="row">
        @foreach($banco as $bancos)

        @if($banco_count==3)
        <div class="col-sm-4 " align="center">
            <p class="form-control" >

                @elseif($banco_count==2)
                <div class="col-sm-6" align="center">
                    <p class="form-control">

                        @elseif($banco_count==1)
                        <div class="col-sm-12" align="center" style="width: 100px">
                            <p class="form-control" style="width: 426px;">

                                @else
                                <div class="col-sm-3 " align="center">
                                    <p class="form-control" >
                                        @endif

                                        <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="height: 30px;"><br>
                                        <span style="font-size: 11px"><strong> {{$bancos->tipo_cuenta}}</strong></span>
                                        <br>
                                        <span style="font-size: 12px">
                                          S/: {{$bancos->numero_soles}}
                                          <br>
                                          $: {{$bancos->numero_dolares}}<br>
                                      </span>
                                  </p>
                              </div>
                              @endforeach
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-sm-3">
                                <p><u>centro de Atencion : </u></p>
                                Telefono : {{$personal->telefono }}<br>
                                Celular : {{$personal->celular }}<br>
                                Email : {{$personal->email }}<br>
                                Web : {{$empresa->pagina_web}} <br>
                            </div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"></div>
                            <div class="col-sm-3"><br><br>
                                <hr>
                                <center>{{$personal->nombres }}</center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  --}}

        <style>
            .form-control{margin-top: 5px; border-radius: 5px}
            p#texto{
                text-align: center;
                color:black;
            }

            input#archivoInput{
                position:absolute;
                top:0px;
                left:0px;
                right:0px;
                bottom:0px;
                width:100%;
                height:100%;
                opacity: 0  ;
            }
        </style>
        <style type="text/css">
            .form-control{border-radius: 10px; padding: 10px }
            .ibox-tools a{color: white !important}
            .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
            .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}

        </style>

        <!-- Mainly scripts -->
        <script src="js/jquery-3.1.1.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>

        {{-- IMPRIMIR --}}
        <script type="text/javascript">
            window.print();
        </script>
