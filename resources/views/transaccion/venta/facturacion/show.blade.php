 @extends('layout')

 @section('title', 'Facturacion Ver')
 @section('breadcrumb', 'Facturacion')
 @section('breadcrumb2', 'Facturacion')
 @section('href_accion', route('facturacion.index'))
 @section('value_accion', 'Atras')

@section('button2', 'Nueva Facturacion')
@section('onclick',"event.preventDefault();document.getElementById('nueva_cots').submit();")

@section('content')

<form action="{{ route('facturacion.create')}}"enctype="multipart/form-data" method="post" id="nueva_cots">
    @csrf
    <input type="text"  hidden="hidden" name="almacen"  value="{{$facturacion->almacen_id}}">
    <input  hidden="hidden" type="submit"  />
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
                <button id="btn_ticket" class="btn btn-info"><i class="fa fa-ticket fa-lg"></i></button>
                <input type="text" value="{{$facturacion->id}}" name="id" id="id" hidden="">
                <a class="btn btn-success" href="{{route('facturacion.print', $facturacion->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i></a>
                @if(Auth::user()->email_creado == 1)
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
                            <h3 style="padding-top:10px ">R.U.C : {{$empresa->ruc}}</h3>
                            <h2>FACTURA ELECTRONICA</h2>
                            <h5> {{$facturacion->codigo_fac}}</h5>
                        </center>
                    </div>
                </div>
            </div><br>
            <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3> Datos Generales</h3>
                            <div align="left">
                                <strong>Cliente:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->nombre}}
                                    @else{{$facturacion->cotizacion->cliente->nombre}}
                                    @endif <br>
                                <strong>R.U.C:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->numero_documento}}
                                    @else{{$facturacion->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                <strong>Direccion:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->cliente->direccion}}
                                    @else{{$facturacion->cotizacion->cliente->direccion}}
                                    @endif <br>
                                <strong>Condiciones de Pago:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->forma_pago->nombre }}
                                    @else{{$facturacion->cotizacion->forma_pago->nombre }}
                                    @endif  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($facturacion->cliente_id)){{$facturacion->moneda->nombre }}
                                    @else{{$facturacion->cotizacion->moneda->nombre }}
                                    @endif <br>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                     <div class="form-control" >
                         <h3>Condiciones Generales</h3>
                         <div align="left">
                            <strong>Orden de Compra:</strong>
                                {{$facturacion->orden_compra}} <br>
                            <strong>Guia de Remision:</strong>
                                {{$facturacion->guia_remision}} <br>
                            <strong>Fecha Emision:</strong>
                                {{$facturacion->fecha_emision}} <br>
                            <strong>Fecha de Vencimiento:</strong>
                                {{$facturacion->fecha_vencimiento }} <br>

                        </div>
                    </div>
                </div>
                <div class="col-sm-12" align="center">
                 <div class="form-control" style="border: none;height: auto" >
                     <div align="left">

                    </div>
                </div>
            </div>

        </div>
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
                            <th>P. Unitario Desc</th>
                            <th>Comision</th>
                            <th>P. Unitario Com.</th>
                            <th>Valor Venta</th>
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
                                <td>{{$facturacion_registros->precio_unitario_desc}}</td>
                                <td>{{$facturacion_registros->comision}}%</td>
                                <td>{{$facturacion_registros->precio_unitario_comi}}</td>
                                <td>{{$facturacion_registros->precio_unitario_comi* $facturacion_registros->cantidad }}</td>

                                <td style="display: none">
                                    {{$sub_total=($facturacion_registros->factura_ids->op_gravada)+($facturacion_registros->factura_ids->op_inafecta)+($facturacion_registros->factura_ids->op_exonerada)}}
                                    {{$sub_total_gravado=($facturacion_registros->factura_ids->op_gravada)}}
                                     {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                    {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                </td>
                            </tr>
                            <span hidden="hidden">{{$i++}}</span>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div><br><br><br><br>
            <h3 align="left">
                <?php $v=new CifrasEnLetras() ;
                $letra=($v->convertirEurosEnLetras($end));
                $letra_final = strstr($letra, 'soles',true);
                $end_final=strstr($end, '.');
                ?>
                Son : {{$letra_final}} {{$end_final}}/100 {{$facturacion->moneda->nombre }}
            </h3>
            <div class="row">
                {{-- <div class="col-sm-3 ">
                    <p class="form-control a"> Sub Total</p>
                    <p class="form-control a">{{$facturacion->moneda->simbolo}}.{{round($sub_total, 2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Op. Agravada</p>
                    <p class="form-control a"> {{$facturacion->moneda->simbolo}}.00</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> IGV</p>
                    <p class="form-control a"> {{$facturacion->moneda->simbolo}}.{{round($igv_p, 2)}}</p>
                </div>
                <div class="col-sm-3 ">
                    <p class="form-control a"> Importe Total</p>
                    <p class="form-control a"> {{$facturacion->moneda->simbolo}}.{{$end}}</p>
                </div> --}}
                <div class="col-sm-8">

                </div>
                <div class="col-sm-4 form-control">
                    {{-- <div class="col-sm-4 form-control" > --}}
                <span style="display: block;float: left"> Sub Total:</span>
                <span style="display: block;float: right;"> {{$simbologia=$facturacion->moneda->simbolo}}. {{number_format($sub_total, 2)}}</span>
                <br>
                <span style="display: block;float: left"> Op. Agravada: </span>
                <span style="display: block;float: right">{{$simbologia}}. {{number_format($facturacion->op_gravada,2)}}</span><br>
                <span style="display: block;float: left"> Op. Inafecta: </span>
                <span style="display: block;float: right">{{$simbologia}} {{ number_format($facturacion->op_inafecta,2)}}</span><br>
                <span style="display: block;float: left"> Op. Exonerada: </span>
                <span style="display: block;float: right">{{$simbologia}}. {{number_format($facturacion->op_exonerada,2)}} </span><br>
                <span style="display: block;float: left"> I.G.V.: </span>
                <span style="display: block;float: right">{{$facturacion->moneda->simbolo}}.{{number_format(round($igv_p, 2),2)}}</span><br>
                <span style="display: block;float: left"> Importe Total: </span>
                 <span style="display: block;float: right">{{$facturacion->moneda->simbolo}}.{{$end}}</span>

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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#btn_ticket').click(function(){
            var id_fac =  $(`[id='id']`).val();
           $.ajax({
               type: "post",
                url: "{{ route('ticket_ajax_ingreso') }}",
                 data: {
                    '_token': $('input[name=_token]').val(),
                    'id' : id_fac
                    },
               success: function(response){
                   if(response==1){
                       // alert('Imprimiendo Ticket');
                   }else{
                       alert('Error');
                   }
               }
           });
        });
    });
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
