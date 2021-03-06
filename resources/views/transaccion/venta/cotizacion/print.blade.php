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
                            <h5>{{$cotizacion->cod_cotizacion}} </h5>
                        </div>
                    </div>
                </div><br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3>Contacto Cliente</h3>
                            <div align="left">
                                <strong>Señor(es):</strong> &nbsp;{{$cotizacion->cliente->nombre}}<br>
                                <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong> &nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$cotizacion->created_at}}<br>
                                <strong>Direccion:</strong>&nbsp; {{$cotizacion->cliente->direccion}}<br>
                                <strong>Telefono:</strong>&nbsp; {{$cotizacion->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Celular:</strong>&nbsp; {{$cotizacion->cliente->celular}}<br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                       <div class="form-control" >
                           <h3>Condiciones Generales</h3>
                           <div align="left">
                            <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}<br>
                            <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}<br>
                            <strong>Garantia:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" align="center">
                   <div class="form-control" style="border: none;height: auto" >
                       <div align="left">
                        <strong>observaciones:</strong> &nbsp;{{$cotizacion->observacion }}<br>
                    </div>
                </div>
            </div>

        </div><br>
        <div class="table-responsive">
            <table class="table " >
                <thead>
                   <tr >
                    <th>ITEM </th>
                    <th>Codigo </th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>P.Unitario</th>
                    <th>Total <span hidden="hidden">{{$simbologia=$cotizacion->moneda->simbolo}}</span></th>
                </tr>
            </thead>
            <tbody>
               @foreach($cotizacion_registro as $cotizacion_registros)
               <tr>
                <td>{{$i++}} </td>
                <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                <td>{{$cotizacion_registros->producto->nombre}} <br>{{$cotizacion_registros->producto->descripcion}}</span></td>
                <td>{{$cotizacion_registros->cantidad}}</td>
                <td>{{$cotizacion_registros->precio_unitario_comi}}</td>
                <td>{{$cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi}}</td>
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
    $end_final=strstr($end, '.');
    ?>
    Son : {{$letra_final}} {{$end_final}}/100 {{$cotizacion->moneda->nombre }}
</h3>

<div class="row">
   {{--  <div class="col-sm-3 ">
        <p class="form-control a"> Sub Total</p>
        <p class="form-control a">{{$simbologia=$cotizacion->moneda->simbolo}}.{{round($sub_total, 2)}}</p>
    </div>
    <div class="col-sm-3 ">
        <p class="form-control a"> Op. Agravada</p>
        <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.00</p>
    </div>
    <div class="col-sm-3 ">
        <p class="form-control a"> IGV</p>
        <p class="form-control a"> @if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{round($igv_p, 2)}} @else  {{$cotizacion->moneda->simbolo}}.00 @endif</p>
    </div>
    <div class="col-sm-3 ">
        <p class="form-control a"> Importe Total</p>
        <p class="form-control a"> @if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{$end}} @else  {{$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}} @endif</p>
    </div> --}}
    <div class="col-sm-8 ">

    </div>
    <div class="col-sm-4 form-control" >
        <span style="display: block;float: left"> Sub Total:</span>
        <span style="display: block;float: right;"> {{$simbologia=$cotizacion->moneda->simbolo}}. {{number_format($sub_total, 2)}}</span>
        <br>
        <span style="display: block;float: left"> Op. Agravada: </span>
        <span style="display: block;float: right">{{$simbologia}}. {{number_format($cotizacion->op_gravada,2)}}</span><br>
        <span style="display: block;float: left"> Op. Inafecta: </span>
        <span style="display: block;float: right">{{$simbologia}} {{ number_format($cotizacion->op_inafecta,2)}}</span><br>
        <span style="display: block;float: left"> Op. Exonerada: </span>
        <span style="display: block;float: right">{{$simbologia}}. {{number_format($cotizacion->op_exonerada,2)}} </span><br>
        <span style="display: block;float: left"> I.G.V.: </span>
        <span style="display: block;float: right">@if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{number_format(round($igv_p, 2),2)}} @else  {{$cotizacion->moneda->simbolo}}.00 @endif</span><br>
        <span style="display: block;float: left"> Importe Total: </span>
         <span style="display: block;float: right">@if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{$end}} @else  {{$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}} @endif</span>
    </div>
</div>
</footer>

<br>
<!-- Fin Totales de Productos -->
<div class="row">
     @foreach($banco as $bancos)

    @if($banco_count==3)
    <div class="col-sm-4 " align="center">
    <p class="form-control">

    @elseif($banco_count==2)
    <div class="col-sm-6" align="center">
    <p class="form-control">

    @elseif($banco_count==1)
    <div class="col-sm-12" align="center" style="width: 100px">
    <p class="form-control" style="width: 426px;">

    @else
    <div class="col-sm-3 " align="center">
    <p class="form-control" style="height: 110px">
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
        Telefono : {{$cotizacion->user_personal->personal->telefono }}<br>
        Celular : {{$cotizacion->user_personal->personal->celular }}<br>
        Email : {{$cotizacion->user_personal->personal->email }}<br>
        Web : {{$empresa->pagina_web}} <br>
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
{{--  --}}
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
