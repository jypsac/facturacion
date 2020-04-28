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
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                            <div class="row">
                                <div class="col-sm-4 text-left" align="left">

                                    <address class="col-sm-4" align="left">
                                        <!-- <h5>De:</h5>
                                        <i class=" fa fa-user">:</i><strong > {{$empresa->nombre}}</strong><br>
                                        <i class=" fa fa-building">:</i> <br>
                                        <i class="fa fa-phone">:</i>  -->
                                        <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                                    </address>
                                </div>
                                <div class="col-sm-4">
                                </div>

                                <div class="col-sm-3 ">
                                    <h4>{{$empresa->nombre}}</h4>
                                    <h4>{{$empresa->ruc}}</h4>
                                    <h4>{{$empresa->calle}}</h4>
                                    <h4 class="text-navy">Cotizacion N°: {{$cotizacion->cod_comision}}</h4>

                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-7" align="center">
                                    <div class="form-control"><h3>Contanto Cliente</h3>
                                        <div align="left">
                                            <strong>Nombre:</strong> &nbsp;{{$cotizacion->cliente->nombre}}<br>
                                            <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Fecha:</strong> &nbsp;{{$cotizacion->created_at}}<br>
                                            <strong>Direccion:</strong>&nbsp; {{$cotizacion->cliente->direccion}}<br>
                                            <strong>Telefono:</strong>&nbsp; {{$cotizacion->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Celular:</strong>&nbsp; {{$cotizacion->cliente->celular}}<br>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5" align="center">
                                    <div class="form-control" style="height: 200px"><h3>Condiciones Generales</h3>
                                        <div align="left">
                                            <strong>Precios:</strong> &nbsp;{{$cotizacion->id }}<br>
                                            <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}<br>
                                            <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}<br>
                                            <strong>Plazo Entrega:</strong> &nbsp;{{$cotizacion->id }}<br>
                                            <strong>Garantia:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                            <strong>Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                         <!-- <strong>Comisonista:</strong> &nbsp;{{$cotizacion->comisionista_id}} -->

                                        </div>
                                    </div>
                                </div>


                            </div><br>
                            <div class="row">
                                <div class="col-sm-12" >
                                <h4>Observacion:</h4>
                                {{$cotizacion->observacion }}
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                    <tr>
                                        <th >Codigo Producto</th>
                                        <th>Unidad de medida</th>
                                        <th >Descripcion</th>
                                        <th >Cantidad</th>
                                        <th >Precio</th>
                                        <th >Valor venta</th>

                                        <th style="display: none">S/.</th><!--
                                        <th style="background: #f3f3f4">Precio Total</th> -->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($regla=="factura")
                                      @foreach($cotizacion_registro as $cotizacion_registros)
                                    <tr>
                                        <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                        <td>{{$cotizacion_registros->producto->unidad_i_producto->medida}}</td>
                                        <td>{{$cotizacion_registros->producto->nombre}}</td>
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

                                      @endforeach

                                      <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">Sub Total</td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">
                                            S/.{{round($sub_total, 2)}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background: #f3f3f4;">IGV</td>
                                        <td style="background: #f3f3f4;">
                                            S/.{{round($igv_p, 2)}}
                                        </td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">Total</td>
                                        <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">
                                            S/.{{$end}}
                                        </td>
                                    </tr>
                                      @else
                                        @foreach($cotizacion_registro2 as $cotizacion_registros)
                                            <tr>
                                                <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                                                <td>{{$cotizacion_registros->producto->unidad_i_producto->medida}}</td>
                                                <td>{{$cotizacion_registros->producto->nombre}}</td>
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

                                        @endforeach
                                          <tr>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td></td>
                                              <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">Total</td>
                                              <td style="background: #4f4f4f73;color:white;border-left:1px solid #26262682">
                                                  {{$end=round($sub_total, 2)}}
                                              </td>
                                          </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div><!-- /table-responsive -->




                        <footer style="padding-top: 150px">
                       <div class="row">
                            <div class="col-sm-6" align="left">



                            <h3>
                            <?php $v=new CifrasEnLetras() ;
                            $letra=($v->convertirEurosEnLetras($end));

                            $letra_final = strstr($letra, 'soles',true);

                            $end_final=strstr($end, '.');
                            ?>

                                {{$letra_final}} {{$end_final}}/100 {{$moneda->nombre}}
                                 </h3>
                            <table>
                                    <tr>
                                        {{-- <td style="width: 70px">Telefono</td><td>:</td><td>&nbsp;{{$cotizacion->personal->telefono}}</td>
                                    <tr>
                                        <td style="width: 70px">Celular</td><td>:</td><td>&nbsp;{{$cotizacion->personal->celular}}</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 70px">Email</td><td>:</td><td>&nbsp;{{$cotizacion->personal->email}}</td> --}}
                                    </tr>
                                     {{-- <tr>
                                        <td style="width: 70px">Web</td><td>:</td><td>&nbsp;{{$cotizacion->personal->telefono}}</td>
                                    </tr> --}}
                                </table>

                            </div>
                            <div class="col-sm-6" align="center">

                                <hr width="200" style="color:black">
                                {{-- <p> {{$cotizacion->personal->nombres}} {{$cotizacion->personal->apellidos}} <br> <strong>{{$cotizacion->personal->profesion}}</strong>  </p> --}}
                            </div>
                       </div>
                        </footer>

                        </div>
                </div>
            </div>
                    
            </div>
        </div>
        
       
<style type="text/css">
    .form-control{border-radius: 10px; height: 150px;}
    .ibox-tools a{color: white !important}
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
