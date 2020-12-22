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
@page { size: 420mm 297mm landscape; }
</style>
<body class="white-bg">
{{-- <div class="ibox" style=" margin-bottom:0px; width: 100%">
    <div class="table-responsive" >

        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 50px ;margin-top: 5px">
    </div>
</div> --}}
    <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
        <tr>
            <td style="width: auto;border-color: white" rowspan="2" valign="top">
                <img align="" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="margin-top: 0px;" width="300px" />
                <br>
            </td>
            <td style="width: 30%; ;border: 1px #e5e6e7 solid;border-radius: 8px;margin-top: 0px" align="right">
                <center>
                    <h3 style="text-align: center;padding-top:10px;margin-bottom: -28px;margin-top: -10px"> R.U.C {{$empresa->ruc}}</h3><br>
                    <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >FACTURA ELECTRONICA</h2><br>
                    <h5 style="text-align: center;margin-bottom: -5px" >{{$facturacion->codigo_fac}}</h5>
                </center>
            </td>
        </tr>
    </table>

<div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
<table class="table " width="100%" style="border-collapse: collapse;">
    <tbody>
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
    </tbody>
</table>

<div class="form-control" style="border: none;height: auto" >
    <div align="left">
       
    </div>
</div>
<br>
@if($facturacion->tipo=="producto")
<div class="table-responsive">
    <table class="table " style="border-top: 0px" >
        <thead style="">
            <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                <td width="10px">ITEM </td>
                <td width="120px" >Codigo Producto</td>
                <td width="60px">Cantidad</td>
                <td width="60px">Unid.Medida</td>
                <td width="auto">Descripción</td>
                <td width="auto">Valor Unitario</td>
                <td width="auto">Dscto.%</td>
                <td width="auto">Precio Unitario</td>
                <td width="auto">Valor Venta</td>
            </tr>
        </thead>
        <tbody>
            @foreach($facturacion_registro as $facturacion_registros)
            <tr>
                <td>{{$i++}} </td>
                <td>{{$facturacion_registros->producto->codigo_producto}}</td>
                <td>{{$facturacion_registros->cantidad}}</td>
                <td>{{$facturacion_registros->producto->unidad_i_producto->medida}}</td>
                <td>{{$facturacion_registros->producto->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                <td>{{$facturacion_registros->precio}}</td>
                <td>{{$facturacion_registros->descuento}}%</td>
                <td>{{$facturacion_registros->precio_unitario_desc}}</td>
                <td>{{$facturacion_registros->precio_unitario_desc * $facturacion_registros->cantidad }}</td>
                <td style="display: none">
                    {{$sub_total=($facturacion_registros->cantidad*$facturacion_registros->precio_unitario_desc)+$sub_total}}
                    {{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table >
</div>
@else
<div class="table-responsive">
    <table class="table " style="border-top: 0px" >
        <thead style="">
           <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                <td width="30px">ITEM </td>
                <td width="120px" >Codigo Servicio</td>
                <td width="auto">Cantidad</td>
                <td width="400px">Descripcion</td>
                <td width="auto">Valor Unitario</td>
                <td width="auto">Dscto.%</td>
                <td width="auto">Precio Unitario</td>
                <td width="80px">Valor Venta</td>
            </tr>
        </thead>
        <tbody>
          @foreach($facturacion_registro as $facturacion_registros)
            <tr>
                <td>{{$i++}} </td>
                <td>{{$facturacion_registros->servicio->codigo_servicio}}</td>
                <td>{{$facturacion_registros->cantidad}}</td>

                <td>{{$facturacion_registros->servicio->nombre}}</td>
                <td>{{$facturacion_registros->precio}}</td>
                <td>{{$facturacion_registros->descuento}}%</td>
                <td>{{$facturacion_registros->precio_unitario_desc}}</td>
                <td>{{$facturacion_registros->precio_unitario_desc * $facturacion_registros->cantidad }}</td>
                <td style="display: none">
                    {{$sub_total=($facturacion_registros->cantidad*$facturacion_registros->precio_unitario_desc)+$sub_total}}
                    {{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div><!-- /table-responsive -->
@endif
<footer style="padding-top: 120px">

<table style="border: white 0px solid;text-align: center;" >
    <tr style="border: white 0px solid" >
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                Subtotal <br style="height: 2px;">
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                 Op. Agravada <br style="height: 2px;">
             </td>
         <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                IGV  <br style="height: 2px;">
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                Importe Total <br style="height: 2px;">
            </td>
    </tr>
    <tr style="border: white 0px solid" >
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                {{-- {{$simbologia=$cotizacion->moneda->simbolo}}. --}}    S/.{{round($sub_total, 2)}}
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                {{-- {{$simbologia=$cotizacion->moneda->simbolo}} --}}S/.00
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
               {{-- {{$simbologia=$cotizacion->moneda->simbolo}} --}} S/.{{round($igv_p, 2)}}
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                {{-- {{$cotizacion->moneda->simbolo}} --}}    S/.{{$end}}
            </td>
    </tr>
</table>
</center>


<br>

<!-- Fin Totales de Productos -->
<br>
<table style="border-collapse: separate;">
    <tr>
         <th style="width: 2%;border-color: white"></th>
        @foreach($banco as $bancos)
        @if($banco_count==3)
        <th width="33%" style="border: 1px #e5e6e7 solid;border-radius: 8px;">
        @elseif($banco_count==2)
        <th width="50%"style="border: 1px #e5e6e7 solid;border-radius: 8px;">
        @elseif($banco_count==1)
        <th width="100%"style="border: 1px #e5e6e7 solid;border-radius: 8px;">
        @else
        <th width="20%"style="border: 1px #e5e6e7 solid;border-radius: 8px;">
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
         <th style="width: 2%;border-color: white"></th>
        @endforeach
    </tr>
</table>
<div class="row">
<br>
<table style="border:  0px solid white">
    <tr style="border:  0px solid white">
        <td>
            <p><u>centro de Atencion : </u></p>
            Telefono : {{$facturacion->user->personal->nombres }}<br>
            Telefono : {{$facturacion->user->personal->telefono }}<br>
            Celular : {{$facturacion->user->personal->celular }}<br>
            Email : {{$facturacion->user->personal->email }}<br>
            Web :{{$empresa->pagina_web}} <br>
        </td>
        <td >
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            {{-- <hr> --}}
            {{-- <center>{{$cotizacion->user_personal->personal->nombres }}</center> --}}
        </td>
    </tr>
</table>
</div>

{{--  --}}
<style>

    *{font-size: 14px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
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
    .table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    border-top-width: 0px;

}
</style>
