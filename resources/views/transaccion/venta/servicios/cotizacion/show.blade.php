@extends('layout')

@section('title', 'Cotizacion Servicio Ver')
@section('breadcrumb', 'Cotizacion Servicio')
@section('breadcrumb2', 'Cotizacion Servicio')
@section('href_accion', route('cotizacion_servicio.index'))
@section('value_accion', 'Atras')

@section('button2', 'Nueva cotizacion')
@section('onclick',"event.preventDefault();document.getElementById('nueva_cot').submit();")

@section('content')

<form action="{{ route($nueva_cot)}}"enctype="multipart/form-data" method="post" id="nueva_cot">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$cotizacion->almacen_id}}">
    <input  hidden="hidden" type="submit"  >
</form>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" style="padding-right: 3.1%;padding-left: 3.1%">
        <div class="row tooltip-demo" >
             <div class="col-sm-6"  >
                @if($cotizacion->estado == '1')
                    @if($cotizacion->tipo=='factura')
                        <a class="btn btn-default procesado" style="color: inherit !important; width: 100px; transition: 1s"  href="{{route('facturacion_servicio.show',$facturacion->id)}}" >Ver Factura</a>
                    @else
                        <a class="btn btn-default procesado" style="color: inherit !important; width: 100px; transition: 1s"  href="{{route('boleta_servicio.show',$boleta->id)}}" >Ver Boleta</a>
                    @endif
                @else
                {{-- SIN PROCESAR --}}
                    @if($cotizacion->tipo=='factura')
                        <a class="btn btn-info" href="{{route('cotizacion_servicio.facturar' , $cotizacion->id)}}">Facturar</a>
                    @else
                        <a class="btn btn-success"  href="{{route('cotizacion_servicio.boletear', $cotizacion->id)}}">Boletear</a>
                    @endif
                @endif
            </div>
             <div class="col-sm-6" align="right">
                <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_cotizacion_servicio' ,$cotizacion->id)}}">
                <input type="text" name="name" maxlength="50" hidden="" value="{{$cotizacion->cod_cotizacion}}"  >
                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                </form>
                <a class="btn btn-success" href="{{route('cotizacion_servicio.print' , $cotizacion->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                         {{-- </a> --}}
                @if(Auth::user()->email_creado == 1)
                    <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                        @csrf
                        <input type="text" hidden="hidden" name="tipo" value="App\Cotizacion_Servicios"/>
                        <input type="text" hidden="hidden" name="id" value="{{$cotizacion->id}}"/>
                        <input type="text" hidden="hidden" name="redict" value="ventas_cotizacion"/>
                        <input type="text" hidden="hidden" name="cliente" value="{{$cotizacion->cliente->email}}"/>
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
                 <input type="text" hidden="" name="url" value="{{route('pdf_cotizacion_servicio' ,$cotizacion->id)}}?archivo=">
                 <input type="text" name="name_sin_cambio" hidden="" value="Cotizacion_Servicio_{{$cotizacion->tipo}}" />
                <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
            </form>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-top: -4px">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">COTIZACION ELECTRONICA</h2>
                            <h5>{{$cotizacion->cod_cotizacion}} </h5>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-7" align="center">
                        <div class="form-control"><h3>Contacto Cliente</h3>
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
                    <div class="col-sm-5" align="center">
                        <div class="form-control" ><h3>Condiciones Generales</h3>
                            <div align="left">
                                <strong>Forma De Pago:</strong> &nbsp;{{$cotizacion->forma_pago->nombre }}<br>
                                <strong>Validez :</strong> &nbsp;{{$cotizacion->validez}}<br>
                                <strong>Garantia:</strong> &nbsp;{{$cotizacion->garantia }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <strong>Tipo de Moneda:</strong> &nbsp;{{$cotizacion->moneda->nombre }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12" >
                        <h4>Observacion:</h4>
                        {{$cotizacion->observacion }}
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 100px">Item</th>
                                <th style="width: 100px">Codigo </th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th style="width: 86px">P.Unitario</th>
                                <th>Total</th>
                                <th style="display: none">S/.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($regla=="factura")
                                @foreach($cotizacion_registro as $cotizacion_registros)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$cotizacion_registros->servicio->codigo_servicio}}</td>
                                    <td>{{$cotizacion_registros->servicio->nombre}} / {{$cotizacion_registros->servicio->descripcion}}</td>
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
                            @else
                                @foreach($cotizacion_registro as $cotizacion_registros)
                                <tr>
                                    <td>{{$i}} </td>
                                    <td>{{$cotizacion_registros->servicio->codigo_servicio}}</td>
                                    <td>{{$cotizacion_registros->servicio->nombre}}/{{$cotizacion_registros->servicio->descripcion}}</td>
                                    <td>{{$cotizacion_registros->cantidad}}</td>
                                    <td>{{$cotizacion_registros->precio_unitario_comi}}</td>
                                    <td>{{$cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi}} </td>
                                    <td style="display: none"> {{$sub_total=($cotizacion_registros->cantidad*$cotizacion_registros->precio_unitario_comi)+$sub_total}}
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
                </div>

                <footer style="padding-top: 100px"></footer>

                @if ($regla=="factura")
                    <h3 align="left">
                            <?php $v=new CifrasEnLetras() ;
                            $letra=($v->convertirEurosEnLetras($end));
                            $letra_final = strstr($letra, 'soles',true);
                            $end_final=strstr($end, '.');
                            ?>
                            Son : {{$letra_final}} {{$end_final}}/100 {{$moneda->nombre}}
                    </h3>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <p class="form-control a"> Sub Total</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.{{round($sub_total, 2)}}</p>
                        </div>
                        <div class="col-sm-3 ">
                            <p class="form-control a"> Op. Agravada</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.00</p>
                        </div>
                        <div class="col-sm-3 ">
                            <p class="form-control a"> IGV</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.{{round($igv_p, 2)}}</p>
                        </div>
                        <div class="col-sm-3 ">
                            <p class="form-control a"> Importe Total</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.{{$end}}</p>
                        </div>
                    </div>
                @else

                    <div class="row">
                        <div class="col-sm-3 ">
                            <p class="form-control a"> Sub Total</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}}</p>
                        </div>
                        <div class="col-sm-3 ">
                            <p class="form-control a"> Op. Agravada</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.00</p>
                        </div>
                        <div class="col-sm-3 ">
                            <p class="form-control a"> IGV</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.00</p>
                        </div>
                        <div class="col-sm-3 ">
                            <p class="form-control a"> Importe Total</p>
                            <p class="form-control a"> {{$simbologia=$cotizacion->moneda->simbolo}}.{{$end=round($sub_total, 2)}}</p>
                        </div>
                    </div>
                @endif
                <br>
                <div class="row">
                    @foreach($banco as $bancos)
                        <div class="col-sm-3" align="center">
                            <p class="form-control" style="height: 100px">
                                <img src="{{asset('img/logos/'.$bancos->foto)}}" style="width:100px;height:30px;"><br>
                                N° S/. : {{$bancos->numero_soles}}<br>
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
                    <div class="col-sm-3">
                        <br><br>
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
<script type="text/javascript">
    function mostrarPassword(){
        var cambio = document.getElementById("txtPassword");
        if(cambio.type == "password"){
            cambio.type = "text";
            $('#ojo').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
        }else{
            cambio.type = "password";
            $('#ojo').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
        }
    }

</script>
<script type="text/javascript">
    {{-- Fotooos --}}
    function validarExt()
    {
        var archivoInput = document.getElementById('archivoInput');
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpg|.png|.jfif)$/i;
        if(!extPermitidas.exec(archivoRuta)){
            alert('Asegurese de haber seleccionado una Imagen');
            archivoInput.value = '';
            return false;
        }

        else
                                        {
        //PRevio del PDF
        if (archivoInput.files && archivoInput.files[0])
        {
            var visor = new FileReader();
            visor.onload = function(e)
            {
                document.getElementById('visorArchivo').innerHTML =
                '<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
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
    @endsection
