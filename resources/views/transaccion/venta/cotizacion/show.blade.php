@extends('layout')
@section('title', 'Cotizacion Ver')
@section('breadcrumb', 'Cotizacion')
@section('breadcrumb2', 'Cotizacion')
@section('href_accion', route('cotizacion.index'))
@section('value_accion', 'Atras')
@section('nombre', 'nueva cotizacion')
@section('onclick',"event.preventDefault();document.getElementById('nueva_cot').submit();")

@section('content')

<form action="{{ route($nueva_cot)}}"enctype="multipart/form-data" method="post" id="nueva_cot">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$almacen}}">
    <input  hidden="hidden" type="submit"  >
</form>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title">
        <div class="ibox-tools">
            <a class="btn btn-success" href="{{route('cotizacion.print',$cotizacion->id)}}" target="_blank">Imprimir</a>
        </div>
    </div>
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
                    <th>Unidad</th>
                    <th>Descripcion</th>
                    <th>Cantidad</th>
                    <th>P.Unitario</th>
                    <th>Total <span hidden="hidden">{{$simbologia=$cotizacion->moneda->simbolo}}</span></th>
                </tr>
            </thead>
            <tbody>
               @foreach($cotizacion_registro as $cotizacion_registros)
               <tr>
                <td>{{$i}} </td>
                <td>{{$cotizacion_registros->producto->codigo_producto}}</td>
                <td>{{$cotizacion_registros->producto->unidad_i_producto->medida}}</td>
                <td>{{$cotizacion_registros->producto->nombre}}  <span style="font-size: 10px">{{$cotizacion_registros->producto->descripcion}}</span></td>
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
    <div class="col-sm-3 ">
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
    </div>
</div>
</footer>

<br>
<!-- Fin Totales de Productos -->
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
    .form-control{border-radius: 10px; height: 150px;}
    .ibox-tools a{color: white !important}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}

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


@endsection