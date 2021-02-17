 @extends('layout')

 @section('title', 'Facturacion Ver')
 @section('breadcrumb', 'Facturacion')
 @section('breadcrumb2', 'Facturacion')
 @section('href_accion', route('facturacion.index'))
 @section('value_accion', 'Atras')

@section('button2', 'Nueva Facturacion')
@section('onclick',"event.preventDefault();document.getElementById('nueva_cot').submit();")

@section('content')

<form action="{{ route('facturacion.create')}}"enctype="multipart/form-data" method="post" id="nueva_cot">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$facturacion->almacen_id}}">
    <input  hidden="hidden" type="submit"  >
</form>
<style type="text/css">
    .procesado:before {
        content: "Procesado";
    }
    .procesado:hover:before {
        content: "Ver";
    }
</style>
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" style="padding-right: 3.1%">
        <div class="row tooltip-demo">
            <div class="col-sm-6">
            </div>
             <div class="col-sm-6" align="right">
                <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_fac' ,$facturacion->id)}}">
                    <input type="text" name="name" maxlength="50" hidden="" value="{{$facturacion->codigo_fac}}"  >
                    <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
                </form>
                <a class="btn btn-success" href="{{route('facturacion.print' , $facturacion->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                @if(Auth::user()->email_creado == 0)
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#config" ><i class="fa fa-envelope fa-lg " ></i>  </button>
                @else
                    <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                        @csrf
                        <input type="text" hidden="hidden"  name="tipo" value="App\Facturacion"/>
                        <input type="text" hidden="hidden"  name="id" value="{{$facturacion->id}}"/>
                        <input type="text" hidden="hidden"  name="redict" value="cotizacion_factura"/>
                        <input type="text" hidden="hidden"  name="cliente" value=" {{$facturacion->cliente->email}}"/>
                       <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title=""  formtarget="_blank"  data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
                    </form>
                @endif
                <div id="auto" onclick="divAuto()">
                    <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
                </div>
                <div id="div-mostrar">
                   <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                        @csrf
                         <input type="tel" name="numero"  value="{{$facturacion->cliente->celular}}"   />
                         <input type="text" name="mensaje" id="texto_orden" hidden="" />
                         <input type="text" hidden="" name="url" value="{{route('pdf_fac' ,$facturacion->id)}}?archivo=">
                         <input type="text" name="name_sin_cambio" hidden="" value="Facturacion_{{$facturacion->codigo_fac}}" />
                        <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
            {{-- <div class="ibox-tools">
                <a class="btn btn-success"  href="{{route('facturacion.print' , $facturacion->id)}}" target="_blank">Imprimir</a>
            </div>
        </div> --}}

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
                <div class="col-sm-4 ">
                    <div class="form-control ruc" style="height: 125px">
                        <center>
                            <h3 style="padding-top:10px ">RUC : {{$empresa->ruc}}</h3>
                            <h2>FACTURA ELECTRONICA</h2>
                            <h5> {{$facturacion->codigo_fac}}</h5>
                        </center>
                    </div>
                </div>
            </div><br>
            <table class="table ">
                <thead>
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
                </thead>
            </table>
            <br>
            <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>Codigo Producto</th>
                            <th>Cantidad</th>
                            <th>Unid.Medida</th>
                            <th>Descripción</th>
                            <th>Valor Unitario</th>
                            <th>Dscto.%</th>
                            <th>Precio Unitario</th>
                            <th>Valor Venta </th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            @foreach($facturacion_registro as $facturacion_registros)
                            <span hidden="hidden">{{$i=1}} </span>
                            <tr>
                                <td>{{$i}} </td>
                                <td>{{$facturacion_registros->producto->codigo_producto}}</td>
                                <td>{{$facturacion_registros->cantidad}}</td>
                                <td>{{$facturacion_registros->producto->unidad_i_producto->medida}}</td>
                                <td>{{$facturacion_registros->producto->nombre}} <br><strong>N/S:</strong> {{$facturacion_registros->numero_serie}}</td>
                                <td>{{$facturacion_registros->precio}}</td>
                                <td>{{$facturacion_registros->descuento}}%</td>
                                <td>{{$facturacion_registros->precio_unitario_comi}}</td>
                                <td>{{$facturacion_registros->precio_unitario_comi* $facturacion_registros->cantidad }}</td>
                                <td style="display: none">
                                    {{$sub_total=($facturacion_registros->cantidad*$facturacion_registros->precio_unitario_comi)+$sub_total}}
                                    {{$igv_p=round($sub_total, 2)*$igv->igv_total/100}}
                                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                </td>
                            </tr>
                            <span hidden="hidden">{{$i++}}</span>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div><br><br><br><br>
            <div class="row">
                <div class="col-sm-3 ">
                    <p class="form-control a"> Sub Total</p>
                    <p class="form-control a"> S/.{{round($sub_total, 2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Op. Agravada</p>
                    <p class="form-control a"> S/.00</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> IGV</p>
                    <p class="form-control a"> S/.{{round($igv_p, 2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Importe Total</p>
                    <p class="form-control a"> S/.{{$end}}</p>
                </div>
            </div><br>
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
                            Telefono : {{$facturacion->user->personal->nombres }}<br>
                            Telefono : {{$facturacion->user->personal->telefono }}<br>
                            Celular : {{$facturacion->user->personal->celular }}<br>
                            Email : {{$facturacion->user->personal->email }}<br>
                            Web :
                            <a href="{{$empresa->pagina_web}}" target="blank_">{{$empresa->pagina_web}}</a><br>
                        </div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>
                        <div class="col-sm-3"></div>

                    </div>



      </div>
  </div>



<style type="text/css">
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}

</style>
{{-- Modal Configuracion --}}
<div class="modal fade" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{route('email.config')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="row">
                            <fieldset >
                                <legend> Agregar Configuracion </legend>
                                {{-- <div> --}}
                                    <div class="panel-body" align="left">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" name="email" style="height: 75%;border-radius: 2px ">
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" name="password" id="txtPassword" required="" style="height: 35.2px;border-radius: 2px ">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
                                                            <i class="fa fa-eye-slash " id="ojo" onclick="mostrarPassword()"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">SMPT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="smtp" placeholder="smtp.gmail.com" required="" style="border-radius: 2px">
                                            </div>

                                            <label class="col-sm-2 col-form-label">PORT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="port" value="110 " style="border-radius: 2px">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Encryption:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="encryp" required="" style="height: 85%;border-radius: 2px;padding-top: 4px">
                                                    <option value="">Ninguno</option>
                                                    <option value="SSL">SSL</option>
                                                    <option value="TLS">TLS</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Firma (opcional):</label>
                                            <div class="col-sm-10">
                                                <input type="file" id="archivoInput" name="firma" onchange="return validarExt()" style="border-radius: 2px" />
                                                <span id="visorArchivo">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <img name="firma"  src="" width="390px" height="200px" />
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Ancho(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="ancho_firma">
                                                </div>
                                            <label class="col-sm-2 col-form-label" >Alto(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" name="alto_firma">
                                                </div>
                                        </div>
                                        <br>
                                    </div>
                                </fieldset>
                            </div>
                            <button class="btn btn-primary" type="submit">Grabar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Fin de modal configuracion --}}
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
