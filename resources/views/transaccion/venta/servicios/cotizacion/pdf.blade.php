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
                    <h2 style="font-size: 19px;text-align: center;margin-bottom: -28px" >COTIZACION ELECTRONICA</h2><br>
                    <h5 style="text-align: center;margin-bottom: -5px" >{{$cotizacion->cod_cotizacion}}</h5>
                </center>
            </td>
        </tr>
    </table>
<div class="wrapper wrapper-content animated fadeIn" style="margin-top: -10px ">
<table style="width: 100%;border-collapse:separate;margin-top: -20px">
    <tr >
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 8px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
            <strong>Señor(es):</strong>&nbsp;{{$cotizacion->cliente->nombre}}<br>
            <strong>{{$cotizacion->cliente->documento_identificacion}} :</strong>&nbsp;{{$cotizacion->cliente->numero_documento}}&nbsp;&nbsp;<br>
            <strong>Fecha:</strong>&nbsp;{{$cotizacion->created_at}}<br>
            <strong>Telefono:</strong>&nbsp; {{$cotizacion->cliente->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Celular:</strong>&nbsp; {{$cotizacion->cliente->celular}}<br>
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

<div class="form-control" style="border: none;height: auto" >
    <div align="left">
        <strong>observaciones:</strong> &nbsp; {{$cotizacion->observacion }}<br>
    </div>
</div>
<br>
{{-- <span hidden="" style="color:white;">{{$i=1}}</span> --}}
<span hidden="" style="color:white;">{{$i=1}}</span>

<div class="table-responsive">
    <table class="table " style="border-top: 0px" >
        <thead align="left">
           <tr style="text-align: left;font-weight: bold;border-top-width:  0px ">
                <th >ITEM </th>
                <th >Codigo</th>
                <th >Descripcion</th>
                <th >Cantidad</th>
                <th >P.Unitario</th>
                <th >Total <span hidden="hidden"></span></th>
            </tr>
        </thead>
        <tbody align="left">
             @if ($regla=="factura")
                 {{-- <span hidden="" style="color:white;">{{$i=1}}</span> --}}
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

            @else
            {{-- <span hidden="" style="color:white;">{{$i=1}}</span> --}}
            @foreach($cotizacion_registro2 as $cotizacion_registros)
            <tr>
                <td>{{$i}} </td>
                <td>{{$cotizacion_registros->servicio->codigo_servicio}}</td>
                {{-- <td>{{$cotizacion_registros->servicio->unidad_i_producto->medida}}</td> --}}
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


<footer style="padding-top: 120px">
@if ($regla=="factura")
 <h3 align="left">
    <?php $v=new CifrasEnLetras() ;
    $letra=($v->convertirEurosEnLetras($end));
    $letra_final = strstr($letra, 'soles',true);
    $end_final=strstr($end, '.');
    ?>
    Son : {{$letra_final}} {{$end_final}}/100 {{$moneda->nombre}}
</h3>

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
                {{$simbologia=$cotizacion->moneda->simbolo}}.{{round($sub_total, 2)}}
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
               {{$simbologia=$cotizacion->moneda->simbolo}}.00
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
             {{$simbologia=$cotizacion->moneda->simbolo}}.{{round($igv_p, 2)}}
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
               {{$simbologia=$cotizacion->moneda->simbolo}}.{{$end}}
            </td>
    </tr>
</table>
@else
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
                {{$simbologia=$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}}
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
               {{$simbologia=$cotizacion->moneda->simbolo}}.00
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
             {{$simbologia=$cotizacion->moneda->simbolo}}.00
            </td>
        <th style="width: 2%;border-color: white"></th>
            <td style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 25%">
               {{$simbologia=$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}}
            </td>
    </tr>
</table>
@endif
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
            <p><u>Centro de Atencion : </u></p>
            Telefono : {{$cotizacion->user_personal->personal->telefono }}<br>
            Celular : {{$cotizacion->user_personal->personal->celular }}<br>
            Email : {{$cotizacion->user_personal->personal->email }}<br>
            Web : {{$empresa->pagina_web}} <br>
        </td>
        <td >
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <hr>
            <center>{{$cotizacion->user_personal->personal->nombres }}</center>
        </td>
    </tr>
</table>
</div>

{{--  --}}
<style>

    *{font-size: 15px;color: #495057;font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"}
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
