@extends('layout')

@section('title', 'Ver Informe Tecnico')
@section('breadcrumb', 'Ver informe Tecnico')
@section('breadcrumb2', 'Informe Tecnico')
@section('href_accion', route('garantia_informe_tecnico.index') )
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" align="right" style="padding-right: 3.1%">
        {{-- <div class="ibox-tools"> --}}
            {{-- <a class="btn btn-success"  href="" >Imprimir --}}
            <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_informe' ,$garantias_informe_tecnico->id)}}">
                <input type="text" name="archivo" maxlength="50" value="{{$garantias_informe_tecnico->orden_servicio}}" oninput="actualizatext()" id="texto2">
                <button type="submit" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> PDF </button>
            </form>
            <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                @csrf
                 <input type="tel" name="numero"  value="{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->celular}}" hidden="" />
                 <input type="text" name="mensaje" id="texto_orden" hidden="" />
                 <input type="text" hidden="" name="url" value="{{route('pdf_informe' ,$garantias_informe_tecnico->id)}}?archivo=">
                 <input type="text" name="name_sin_cambio" hidden="" value="{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->orden_servicio}}" />
                <button type="submit" class="btn btn-success" style="background: green;border-color: green;" formtarget="_blank"><i class="fa fa-whatsapp"></i> Whatsapp </button>
            </form>
                     {{-- </a> --}}
            @if(Auth::user()->email_creado == 0)
                 <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#config" ><i class="fa fa-envelope" ></i>  Email</button>
            @else
                <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn">
                    @csrf
                    <input type="text" hidden="hidden" name="tipo" value="App\GarantiaInformeTecnico"/>
                    <input type="text" hidden="hidden" name="id" value="{{$garantias_informe_tecnico->id}}"/>
                    <input type="text" hidden="hidden" name="redict" value="garantias_informe_tecnico">
                    <input type="text" hidden="hidden" name="cliente" value="{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}">
                    <button type="submit" class="btn btn-white"><i class="fa fa-envelope" ></i> Email</button>
                </form>
            @endif
            <a href="{{route('impresiones_informe' ,$garantias_informe_tecnico->id)}}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
        {{-- </div> --}}
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-6 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img align="right" src="{{asset('storage/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="width: 100px;height: 50px;margin-top: 5px">
                            {{-- <img src="{{asset('storage/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" alt="" width="300px" align="left" /> --}}
                            {{-- <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px" align="left"> --}}

                        </address>
                    </div>
                    {{-- <div class="col-sm-6" align="right">
                        <address class="col-sm-4" align="right">
                            <img src="{{asset('storage/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" alt="" width="300px" align="right">
                        </address>
                    </div> --}}
                {{-- </div> --}}
                {{-- <div class="row"> --}}
                    {{-- <div align="right"> --}}
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-4" align="right" style="width: 100%">
                            <div class="form-control" align="center" style="height: auto;" align="right">
                                <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                <h2 style="font-size: 19px">GUIA DE INFORME TECNICO</h2>
                                <h5>{{$garantias_informe_tecnico->orden_servicio}}</h5>
                            </div>
                        </div>
                    {{-- </div> --}}
                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3>Contacto Cliente</h3>
                            <div align="left">
                                <strong>Señor(es):</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}} :</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$garantias_informe_tecnico->fecha}}<br>
                                <strong>Telefono:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Correo:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}<br>
                                <strong>Direccion:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}<br>
                                <strong>Contacto:&nbsp;</strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contactos->nombre}} &nbsp;
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                         <div class="form-control" >
                             <h3>Condiciones Generales</h3>
                             <div align="left">
                                <strong>Ing. Asignado:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <strong>Motivo:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}<br>
                                <strong>Marca :</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}} &nbsp;<br>

                                <strong>Asunto:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            </div>
                        </div>
                    </div>
                    <br>
                   <div class="col-sm-12" align="center" style="padding-top: 15px;">
                        <div class="form-control" style="height: 100%">
                             <h3>Datos del Equipo</h3>
                             <div class="row" style="padding-bottom: 1px">
                                 <div align="left" class="col-sm-6">
                                    <strong>Modelo:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}<br>
                                    <strong>Número de serie:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}<br>
                                    <strong>Descripcion del Problema:&nbsp;</strong><br>
                                    {!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema)!!}
                                </div>
                                <div align="left" class="col-sm-6">
                                    <strong>Codigo Interno:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}<br>
                                    <strong>Fecha de Compra:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra}}<br>
                                    <strong>Revision y Diagnóstico:&nbsp;</strong>{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico)!!}
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Estética</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{!! nl2br($garantias_informe_tecnico->estetica)!!}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%"><h3>Revision y diagnóstico:</h3>
                                <div align="left" style="font-size: 13px;" >
                                    <p>{!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!}</p>
                               </div>
                            </div>
                        </div>

                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Causas del Problema</h3>
                            <div align="left" style="font-size: 13px;">
                                <p> {!! nl2br($garantias_informe_tecnico->causas_del_problema)!!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Solución</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{!! nl2br($garantias_informe_tecnico->solucion)!!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-12" align="center">
                        <div class="form-control" style="height: 100%"><h3>Imagenes</h3>
                            <div align="left" style="font-size: 13px">
                                <div class="row">
                                    @foreach($archivo_informe_tecnico as $archivo)
                                    <div class="col-sm-4">
                                        <img  src="{{asset('archivos/imagenes/informe_tecnico')}}/{{$archivo->archivos}}" style="width: 250px;padding: 5px ;height: 250px;border-radius: 10px">

                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>

                </div>


            <br>
            <!-- Fin Totales de Productos -->
            {{-- <div class="row">
                @foreach($banco as $bancos)
                <div class="col-sm-3 " align="center">
                    <p class="form-control" style="height: 100px">
                      <img  src="" style="width: 100px;height: 30px;">
                      <br>
                      N° S/. :
                      <br>
                      N° $ : <br>

                  </p>
              </div>
              @endforeach

          </div> --}}

          <footer style="padding-top: 10px">
          <br>
          <div class="row">
            <div class="col-sm-4">
                <strong><p><u>Centro de Atencion : </strong></u></p>
                <strong>Direccion:</strong> {{$empresa->calle}}<br>
                <strong>Telefono:</strong> {{$empresa->telefono}}<br>
                <strong>Celular:</strong> {{$empresa->movil}}<br>
                <strong>Email:</strong> {{$empresa->correo}}<br>
                <strong>Web:</strong> {{$empresa->pagina_web}}<br>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-3"></div>
            <div class="col-sm-3"><br><br>
                {{-- <hr>
                <center>adm</center> --}}
            </div>

        </div>
         </footer>
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
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" style="width: 100%;height: 90%;margin-top: 5px; border-radius: 5px" name="email"/>
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10" style="flex-wrap: none">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" name="password" id="txtPassword" required="" style="height: 90%;margin-top: 5px; border-radius: 5px">
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
                                                <input type="text" class="form-control" name="smtp" placeholder="smtp.gmail.com" required="" style="width: 100%;height: 90%;margin-top: 5px; border-radius: 5px">
                                            </div>

                                            <label class="col-sm-2 col-form-label">PORT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="port" value="110 " style="height: 90%;margin-top: 5px; border-radius: 5px" >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Encryption:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="encryp" required="">
                                                    <option value="">Ninguno</option>
                                                    <option value="SSL">SSL</option>
                                                    <option value="TLS">TLS</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Firma (opcional):</label>
                                            <div class="col-sm-10">
                                                <input type="file" id="archivoInput" name="firma" onchange="return validarExt()"  />
                                                <span id="visorArchivo">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <img name="firma"  src="" width="390px" height="200px" />
                                                </span>
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
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script  type="text/javascript">
    function actualizatext() {
            let action = document.getElementById("texto2").value;
            document.getElementById("texto_orden").value = action;
        }
</script>
{{-- <script>
function printExternal(url) {
    var printWindow = window.open( url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}
</script> --}}

@endsection
