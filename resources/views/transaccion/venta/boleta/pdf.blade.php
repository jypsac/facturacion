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
                    <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >BOLETA ELECTRONICA</h2><br>
                    <h5 style="text-align: center;margin-bottom: -5px" >{{$boleta->codigo_boleta}}</h5>
                </center>
            </td>
        </tr>
    </table>

<div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">

<table style="width: 100%;border-collapse:separate;margin-top: -20px">
    <tr >
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Datos Generales </strong></center><br>
            <strong>Señor(es)</strong>&nbsp;
                @if(isset($boleta->cliente_id)){{$boleta->cliente->nombre}}
                @else{{$boleta->cotizacion->cliente->nombre}}
                @endif<br>
            <strong>R.U.C :</strong>&nbsp;
                @if(isset($boleta->cliente_id)){{$boleta->cliente->numero_documento}}
                @else{{$boleta->cotizacion->cliente->numero_documento}}
                @endif&nbsp;&nbsp;<br>
            <strong>Direccion:</strong>&nbsp;
            @if(isset($boleta->cliente_id)){{$boleta->cliente->direccion}}
                @else{{$boleta->cotizacion->cliente->direccion}}
                @endif<br>
            <strong>Condiciones de Pago:</strong>&nbsp;@if(isset($boleta->cliente_id)){{$boleta->forma_pago->nombre }}
                @else{{$boleta->cotizacion->forma_pago->nombre }}
                @endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Tipo de Moneda:</strong>&nbsp;
                @if(isset($boleta->cliente_id)){{$boleta->moneda->nombre }}
                @else{{$boleta->cotizacion->moneda->nombre }}
                @endif<br>
        </td>
        <th style="width: 5%;border-color: white"></th>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
            <strong>Orden de Compra:</strong>&nbsp;{{$boleta->orden_compra}}<br>
            <strong>Guia de Remision:</strong> &nbsp;{{$boleta->guia_remision}}<br>
            <strong>Fecha de Emision:</strong> &nbsp;{{$boleta->fecha_emision}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
            <strong>Fecha de Vencimiento:</strong> &nbsp;{{$boleta->fecha_vencimiento }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
        </td>
    </tr>
</table>
<div class="form-control" style="border: none;height: auto" >
    <div align="left">

    </div>
</div>
<br>
@if($boleta->tipo=="producto")
<div class="table-responsive">
    <table class="table " style="border-top: 0px" >
        <thead style="">
            <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                <td width="10px">ITEM </td>
                <td width="120px" >Codigo Producto</td>
                <td width="60px">Cantidad</td>
                <td width="60px">Unid.Medida</td>
                <td width="200px">Descripción</td>
                <td width="auto">Valor Unitario</td>
                <td width="auto">Dscto.%</td>
                <td width="auto">Precio Unitario</td>
                <td width="auto">Valor Venta</td>
            </tr>
        </thead>
        <tbody>
            @foreach($boleta_registro as $boleta_registros)

                <tr style="border-bottom-width:   0px white ">
                    <td>{{$i++}} </td>
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
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="table-responsive">
    <table class="table " style="border-top: 0px" >
        <thead style="">
           <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                <td width="30px">ITEM </td>
                <td width="120px" >Codigo Servicio</td>
                <td width="auto">Cantidad</td>
                <td width="200px">Descripcion</td>
                <td width="auto">Valor Unitario</td>
                <td width="auto">Dscto.%</td>
                <td width="auto">Precio Unitario</td>
                <td width="80px">Valor Venta</td>
            </tr>
        </thead>
        <tbody>
           @foreach($boleta_registro as $boleta_registros)

                <tr style="border-bottom-width:   0px white ">
                    <td width="30px" style="">{{$i++}} </td>
                    <td  width="120px" style="">{{$boleta_registros->servicio->codigo_servicio}}</td>
                    <td>{{$boleta_registros->cantidad}}</td>

                    <td>{{$boleta_registros->servicio->nombre}} </td>
                    <td>{{$boleta_registros->precio}}</td>
                    <td>{{$boleta_registros->descuento}}%</td>
                    <td>{{$boleta_registros->precio_unitario_desc}}</td>
                    <td>{{$boleta_registros->precio_unitario_desc * $boleta_registros->cantidad }}</td>
                    <td style="display: none">{{$sub_total=($$boleta->op_gravada)}}
                            S/.{{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
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
               {{-- {{$simbologia=$cotizacion->moneda->simbolo}} --}} s/ .00
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
                {{-- {{$cotizacion->moneda->simbolo}} --}}    s/.{{round($sub_total, 2)}}
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
            Telefono : {{$boleta->user->personal->nombres }}<br>
            Telefono : {{$boleta->user->personal->telefono }}<br>
            Celular : {{$boleta->user->personal->celular }}<br>
            Email : {{$boleta->user->personal->email }}<br>
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
