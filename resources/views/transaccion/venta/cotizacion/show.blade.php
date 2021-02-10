@extends('layout')
@section('title', 'Cotizacion Ver')
@section('breadcrumb', 'Cotizacion')
@section('breadcrumb2', 'Cotizacion')
@section('href_accion', route('cotizacion.index'))
@section('value_accion', 'Atras')
@section('button2', 'Nueva cotizacion')
@section('onclick',"event.preventDefault();document.getElementById('nueva_cot').submit();")

@section('content')

<form action="{{ route($nueva_cot)}}"enctype="multipart/form-data" method="post" id="nueva_cot">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$almacen}}">
    <input  hidden="hidden" type="submit"  >
</form>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" style="padding-right: 3.1%;padding-left:  3.1%">
        <div class="row tooltip-demo">
             <div class="col-sm-6" >
              {{--   @if ($regla=='factura')
                    <a class="btn btn-success" href="{{route('cotizacion.facturar',$cotizacion->id)}}" target="_blank">Facturar</a>
                @elseif($regla=='boleta')
                    <a class="btn btn-success" href="{{route('cotizacion.boletear',$cotizacion->id)}}" target="_blank">Boletear</a>
                @endif --}}

                 @if($cotizacion->estado == '1')
                    @if($cotizacion->tipo=='factura')
                        <a class="btn btn-default procesado" style="color: inherit !important; width: 100px; transition: 1s"  href="{{route('facturacion.show',$factura->id)}}" >Ver Factura</a>
                    @else
                        <a class="btn btn-default procesado" style="color: inherit !important; width: 100px; transition: 1s"  href="{{route('boleta.show',$boleta->id)}}" >Ver Boleta</a>
                    @endif
                @else
                {{-- SIN PROCESAR --}}
                    @if($cotizacion->tipo=='factura')
                        <form action="{{route('cotizacion.facturar' , $cotizacion->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="almacen" value="{{$almacen}}" />
                            <button type="submit" class="btn btn-info" href="">Facturar</button>
                        </form>
                    @else
                        <form action="{{route('cotizacion.boletear', $cotizacion->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="almacen" value="{{$almacen}}" />
                            <button type="submit" class="btn btn-info" href="">Boletear</button>
                        </form>
                    @endif
                @endif
            </div>
             <div class="col-sm-6" align="right">
                <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_cotizacion' ,$cotizacion->id)}}">
                <input type="text" name="name" maxlength="50" hidden="" value="Cotizacion_{{$cotizacion->tipo}}"  >
                <input type="text" hidden="" name="firma" value="0">
                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                </form>
                <a class="btn btn-success" href="{{route('cotizacion.print',$cotizacion->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>

                         {{-- </a> --}}
                @if(Auth::user()->email_creado == 0)

                @else
                    <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                        @csrf
                        <input type="text" hidden="hidden"  name="tipo" value="App\Cotizacion"/>
                        <input type="text" hidden="hidden"  name="id" value="{{$cotizacion->id}}"/>
                        <input type="text" hidden="hidden"  name="redict" value="cotizacion_factura"/>
                        <input type="text" hidden="hidden"  name="cliente" value=" {{$cotizacion->cliente->email}}"/>
                       <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
                    </form>
                @endif
                <div id="auto" onclick="divAuto()">
                    <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
                </div>
                <div id="div-mostrar">
                   <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                    @csrf
                     <input type="tel" name="numero"  value="{{$cotizacion->cliente->celular}}"   />
                     <input type="text" name="mensaje" id="texto_orden" hidden="" />
                     <input type="text" hidden="" name="url" value="{{route('pdf_cotizacion' ,$cotizacion->id)}}?archivo=">
                     <input type="text" name="name_sin_cambio" hidden="" value="Cotizacion_{{$cotizacion->tipo}}" />
                    <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-top: -5px;">
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
                <td>{{$cotizacion_registros->producto->nombre}}  <br>{{$cotizacion_registros->producto->descripcion}}</span></td>
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
                Telefono :  {{$empresa->telefono}}<br>
                Celular : {{$cotizacion->user_personal->personal->celular }}<br>
                Email : {{$cotizacion->user_personal->personal->email }}<br>
                Web : {{$empresa->pagina_web}} <br>
            </div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"><br><br>
                @if(empty($firma))

                @else
                <center><img src="{{asset('archivos/imagenes/firma_digital/'.$firma)}}" style="" width="150px" height="100px"></center>
                @endif
                <hr>
                <center>{{$cotizacion->user_personal->personal->nombres }}</center>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<style>
    #auto{
        /*padding: -100px;*/
        /*background: orange;*/
        /*width: 95px;*/
        cursor: pointer;
        /*margin-top: 10px;*/
        /*margin-bottom: 10px;*/
        box-shadow: 0px 0px 1px #000;
        display: inline-block;
    }

    #auto:hover{
        opacity: .8;
    }
    #div-mostrar{
        /*width: 50%;*/
        margin: auto;
        height: 0px;
        /*margin-top: -5px*/
        /*background: #000;*/
        /*box-shadow: 10px 10px 3px #D8D8D8;*/
        transition: height .4s;
        color:white;
        text-align: right;
    }
    #auto:hover{
        opacity: .8;
    }
    #auto:hover + #div-mostrar{
        height: 50px;
}
</style>
<style type="text/css">
    .form-control{border-radius: 10px; padding: 10px }
    .ibox-tools a{color: white !important}
    .a{height: 37px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;}

</style>
<script>
    var clic = 1;
    function divAuto(){
       if(clic==1){
       document.getElementById("div-mostrar").style.height = "50px";
       clic = clic + 1;
       } else{
        document.getElementById("div-mostrar").style.height = "0px";
        clic = 1;
       }
    }
</script>
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