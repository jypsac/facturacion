<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizacion</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control, .single-line {
    background-color: #FFFFFF;
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
</style>
<body class="white-bg">
{{-- <div class="ibox" style=" margin-bottom:0px; width: 100%">
    <div class="table-responsive" >

        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 50px ;margin-top: 5px">
    </div>
</div> --}}
    <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
        <tr>
            <td style="width: auto;border-color: white" rowspan="2">
                <img align="" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="height: 75px;margin-top: 5px" />
            </td>
            <td style="width: 30%; ;border: 1px #e5e6e7 solid;border-radius: 8px;margin-top: 0px" align="right">
                <center>

                    <span style="margin: 5px;font-weight: 200;text-align: center;"> R.U.C {{$empresa->ruc}}</span><br>
                    <span style="margin: 5px;font-size: 15px;text-align: center;" >COTIZACION ELECTRONICA</span><br>
                    <span style="margin: 5px;text-align: center;" >{{$cotizacion->cod_cotizacion}}</span>
                </center>
            </td>
        </tr>
    </table>
<div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
<table style="width: 100%;border-collapse:separate;margin-top: -20px">
    <tr >
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
            <strong>Nombre o Empresa:</strong>&nbsp;{{$cotizacion->cliente->nombre}}<br>
            <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong>&nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;<br>
            <strong>Fecha:</strong>&nbsp;{{$cotizacion->created_at}}<br>
            <strong>Telefono:</strong>&nbsp;{{$cotizacion->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Celular:</strong>&nbsp;{{$cotizacion->cliente->celular}}<br>
        </td>
        <th style="width: 5%;border-color: white"></th>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
            <strong>Forma de Pago:</strong>&nbsp;{{$cotizacion->forma_pago->nombre }}<br>
            <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}<br>
            <strong>Garantia:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
            <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        </td>
    </tr>
</table>
<div class="col-sm-12" align="center">
       <div class="form-control" style="border: none;height: auto" >
           <div align="left">
            <strong>observaciones:</strong> &nbsp;{{$cotizacion->observacion }}<br>
        </div>
    </div>
</div>
<br>

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

<table style="border: white 0px solid;text-align: center;" >
    <tr style="border: white 0px solid" >
        <td style="border: 1px #e5e6e7 solid;border-radius: 4px;">
            {{-- <p style="height: 5px;"> Sub Total</p> --}}
            Subtotal <br style="height: 2px;">
            <hr >
            {{$simbologia=$cotizacion->moneda->simbolo}}.{{round($sub_total, 2)}}
            {{-- <p style="height: 5px">{{$simbologia=$cotizacion->moneda->simbolo}}.{{round($sub_total, 2)}}</p> --}}
        </td>
        <td style="border: 0px #e5e6e7 solid;border-radius: 4px;"> </td>
        <td style="border: 1px #e5e6e7 solid;border-radius: 4px;">
             Op. Agravada <br style="height: 2px;">
            <hr >
             {{$simbologia=$cotizacion->moneda->simbolo}}.00
            {{-- <p style="height: 5px"> Op. Agravada</p>
            <p style="height: 5px"> {{$simbologia=$cotizacion->moneda->simbolo}}.00</p> --}}
        </td>
        <td style="border: 0px #e5e6e7 solid;border-radius: 4px;">  </td>
        <td style="border: 1px #e5e6e7 solid;border-radius: 4px;">
            IGV  <br style="height: 2px;">
            <hr >
            @if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{round($igv_p, 2)}} @else  {{$cotizacion->moneda->simbolo}}.00 @endif
            {{-- <p style="height: 5px"> IGV</p>
            <p style="height: 5px"> @if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{round($igv_p, 2)}} @else  {{$cotizacion->moneda->simbolo}}.00 @endif</p> --}}
        </td>
        <td style="border: 0px #e5e6e7 solid;border-radius: 4px;"> </td>
        <td style="border: 1px #e5e6e7 solid;border-radius: 4px;">
            Importe Total <br style="height: 2px;">
            <hr >
            @if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{$end}} @else  {{$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}} @endif
            {{-- <p style="height: 5px"> Importe Total</p>
            <p style="height: 5px"> @if ($regla=="factura"){{$cotizacion->moneda->simbolo}}.{{$end}} @else  {{$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}} @endif</p> --}}
        </td>
    </tr>
</table>
</center>


<br>

<!-- Fin Totales de Productos -->
<br>
<table>
    <tr>
        @foreach($banco as $bancos)
        @if($banco_count==3)
        <th width="33%" style="border: 1px #e5e6e7 solid;border-radius: 4px;">
        @elseif($banco_count==2)
        <th width="50%"style="border: 1px #e5e6e7 solid;border-radius: 4px;">
        @elseif($banco_count==1)
        <th width="100%"style="border: 1px #e5e6e7 solid;border-radius: 4px;">
        @else
        <th width="20%"style="border: 1px #e5e6e7 solid;border-radius: 4px;">
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
        </th>
        @endforeach
    </tr>
</table>
<div class="row">
<br>
<table>
    <tr>
        <td>
            <p><u>centro de Atencion : </u></p>
            Telefono : {{$cotizacion->user_personal->personal->telefono }}<br>
            Celular : {{$cotizacion->user_personal->personal->celular }}<br>
            Email : {{$cotizacion->user_personal->personal->email }}<br>
            Web : {{$empresa->pagina_web}} <br>
        </td>
        <td>
            <hr>
        <center>{{$cotizacion->user_personal->personal->nombres }}</center>
        </td>
    </tr>
</table>
</div>

{{--  --}}
<style>

    *{font-size: 10px}
    .cero{
    margin-bottom: 0px;

    }
     .table-bordered .blanco {
    border: none;
}
    .blanco{border: none;
        border: medium transparent;
        }
    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }

</style>
