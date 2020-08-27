<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cotizacion- Impresion</title>

    {{-- <link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ url('font-awesome/css/font-awesome.css') }}" rel="stylesheet">



 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


  {{--   <link href="{{ url('css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('css/style.css') }}" rel="stylesheet"> --}}

    <script src="@yield('vue_js', '#')" defer></script>
{{-- 
    <link href="{{ url('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{ url('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet"> --}}

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
            <div class="row">  
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 20px;">
                            <div>
                                <div  style="text-align: left;align-content: left;width: 45%;float: left;" align="left" >
                                    <address >
                                        <!-- <h5>De:</h5>
                                        <i class=" fa fa-user">:</i><strong > {{$empresa->nombre}}</strong><br>
                                        <i class=" fa fa-building">:</i> <br>
                                        <i class="fa fa-phone">:</i>  -->
                                        <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="250px">
                                    </address>
                                </div>
                                    <div style="text-align: right;right: auto;" align="right"   >
                                        <h4>{{$empresa->nombre}}</h4>
                                        <h4>{{$empresa->ruc}}</h4>
                                        <h4>{{$empresa->calle}}</h4>
                                        <h4 class="text-navy">Cotizacion N°: {{$cotizacion->cod_comision}}</h4>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div >
                                <div class="" style="align-content: left;width: 55%;float: left;padding-right: 5px" align="center">
                                    <div class="form-control"><h3>Contacto Cliente</h3>
                                        <div align="left">
                                            <strong>Señor(es):</strong>&nbsp;{{$cotizacion->cliente->nombre}}<br>
                                            <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Fecha:</strong> &nbsp;{{$cotizacion->created_at}}<br>
                                            <strong>Direccion:</strong>&nbsp; {{$cotizacion->cliente->direccion}}<br>
                                            <strong>Telefono:</strong>&nbsp; {{$cotizacion->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Celular:</strong>&nbsp; {{$cotizacion->cliente->celular}}<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="" align="center" style="text-align: center;align-content: left;width: 45%;float: left;padding-left: 5px" align="left">
                                    <div class="form-control" ><h3>Condiciones Generales</h3>
                                        <div align="left">
                                            <!-- <strong>Precios:</strong> &nbsp;{{$cotizacion->id }}<br> -->
                                            <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}<br>
                                            <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}<br>
                                            <!-- <strong>Plazo Entrega:</strong> &nbsp;{{$cotizacion->id }}<br> -->
                                            <strong>Garantia:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                            <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                         <!-- <strong>Comisonista:</strong> &nbsp;{{$cotizacion->comisionista_id}} -->
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-12" >
                                <h4>Observacion:</h4>
                                {{$cotizacion->observacion }}
                                </div>
                            </div><br>

                            <div class="">
                                <table class="table" style="border-radius: 5px">
                                    <thead>
                                    <tr>
                                        <th>ITEM </th>
                                        <th>Codigo </th>
{{--                                         <th>Unidad</th> --}}
                                        <th>Descripcion</th>
                                        <th>Cantidad</th>
                                        <th style="width: 86px">P.Unitario</th>
                                        <th>Total</th>

                                        <th style="display: none">S/.</th><!--
                                        <th style="background: #f3f3f4">Precio Total</th> -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                     @if ($regla=="factura")<span hidden="hidden">{{$i=1}} </span>
                                    @foreach($cotizacion_registro as $cotizacion_registros)
                                    <tr>
                                        <td>{{$i}} </td>
                                        <td>{{$cotizacion_registros->servicio->codigo_servicio}}</td>
                                        {{-- <td>{{$cotizacion_registros->servicio->unidad_i_producto->medida}}</td> --}}
                                        <td>{{$cotizacion_registros->servicio->nombre}}</td>
                                        <td>{{$cotizacion_registros->cantidad}}</td>
                                        <td>{{$cotizacion_registros->precio_unitario_comi}}</td>

                                        <td>{{$cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi}}</td>
                                        <td style="display: none"> {{$sub_total = ($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi) + $sub_total }} 
                                            @if ($regla=="factura")
                                            S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                            {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                            @endif
                                        </td>

                                    </tr>


                                        <span hidden="hidden">{{$i++}}</span>
                                   @endforeach

                                    @else <span hidden="hidden">{{$i=1}} </span>
                                    @foreach($cotizacion_registro2 as $cotizacion_registros)
                                    <tr>
                                        <td>{{$i}} </td>
                                                <td>{{$cotizacion_registros->servicio->codigo_producto}}</td>
                                                <td>{{$cotizacion_registros->servicio->unidad_i_producto->medida}}</td>
                                                <td>{{$cotizacion_registros->servicio->nombre}}</td>
                                                <td>{{$cotizacion_registros->cantidad}}</td>
                                                <td>{{$cotizacion_registros->precio_unitario_comi}}</td>

                                                <td>{{$cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi}}</td>
                                                <td style="display: none">{{$sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total}}
                                                    @if ($regla=="factura")
                                                        S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                                        {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                                    @endif
                                                </td>

                                            </tr>
                                     <span hidden="hidden">{{$i++}}</span>

                                    @endforeach

                                    @endif
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->

                        <footer style="padding-top: 150px">

                        </footer>

                        <!-- Totales de Productos -->
                                @if ($regla=="factura")
                                <h3 align="left">
                            <?php $v=new CifrasEnLetras() ;
                            $letra=($v->convertirEurosEnLetras($end));

                            $letra_final = strstr($letra, 'soles',true);

                            $end_final=strstr($end, '.');
                            ?>

                                Son : {{$letra_final}} {{$end_final}}/100 {{$moneda->nombre}}
                                 </h3>
                                
                                <div class="" style="text-align: center;" align="center">
                                    <div style="width: 20%;height: 248px;float: left;">
                                    </div>
                                    <div style="width: 20%;height: 248px;float: left;">
                                    </div>
                                    <div style="width: 20%;height: 248px;float: left;">
                                    </div>
                                    <div style="width: 25%;height: 248px;float: left;">
                                    </div>
                                    <div style="align-items: right;text-align: center;align-content: right;" align="right">
                                        <div class=" " style="padding: inherit;">
                                            <p class="" ><strong> Sub Total</strong></p>
                                            <p class=""  > S/.{{round($sub_total, 2)}}</p>
                                        </div>
                                        <div class=" ">
                                            <p class=""> <strong>Op. Agravada</strong></p>
                                            <p class=""  > S/.00</p>
                                        </div>
                                        <div class=" ">
                                            <p class=""> <strong>IGV</strong></p>
                                            <p class=""  > S/.{{round($igv_p, 2)}}</p>
                                        </div>
                                         <div class=" ">
                                            <p class=""> <strong>Importe Total</strong></p>
                                            <p class=""  > S/.{{$end}}</p>
                                        </div>
                                    </div>
                                </div>
                                    @else
                                 <div class="" style="text-align: center;" align="center">
                                    <div style="width: 20%;height: 248px;float: left;">
                                    </div>
                                    <div style="width: 20%;height: 248px;float: left;">
                                    </div>
                                    <div style="width: 20%;height: 248px;float: left;">
                                    </div>
                                    <div style="width: 25%;height: 248px;float: left;">
                                    </div>
                                    <div style="align-items: right;text-align: center;align-content: right;" align="right">
                                        <div class=" " style="padding: inherit;">
                                        <p class=""> <strong> Sub Total</strong></p>
                                        <p class=""> S/.{{$end=round($sub_total, 2)}}</p>
                                    </div>
                                    <div class="col-sm-3 ">
                                        <p class=""><strong> Op. Agravada</strong></p>
                                        <p class=""> S/.00</p>
                                    </div>
                                    <div class=" ">
                                        <p class=""> <strong>IGV</strong></p>
                                        <p class=""> S/.00</p>
                                    </div>
                                     <div class="">
                                        <p class=""> <strong>Importe Total</strong></p>
                                        <p class=""> S/.{{$end=round($sub_total, 2)}}</p>
                                    </div>
                                </div>
                                </div>
                                    @endif


                                <br>
                        <!-- Fin Totales de Productos -->
                            <div class="">
                             @foreach($banco as $bancos)
                                     <div class="" align="center" style="width: 25%;float: left;padding: 5px;">
                                         <p class="form-control" style="height: 100px;font-size: 10px;padding: 16px;">
                                         <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 100px;height: 30px;">
                                         <br>
                                         N° Soles: {{$bancos->numero_soles}}
                                         <br>
                                          N° Dolares: {{$bancos->numero_dolares}}<br>
                                         </p>
                                    </div>

                            @endforeach
                            </div>
                            <br><br><br><br><br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p><u>Centro de Atencion : </u></p>
                                Telefono : {{$cotizacion->user_personal->personal->telefono }}<br>
                                Celular : {{$cotizacion->user_personal->personal->celular }}<br>
                                Email : {{$cotizacion->user_personal->personal->email }}<br>
                                Web : {{$empresa->pagina_web}}<br>
                                    </div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-3"><br><br>
                                        <hr>
                                        <center>{{$cotizacion->user_personal->personal->nombres }}</center>
                                    </div>

                                </div>


                        </div>
                </div>
            </div>

        </div>
<style type="text/css">
    .form-control{border-radius: 10px; height: 150px;}
    .ibox-tools a{color: white !important}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
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
