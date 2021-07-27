@extends('layout')

@section('title', 'Ver - Guia de Ingreso')
@section('breadcrumb', 'Ver Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Nueva Guia')

@section('button2', 'Inicio')
@section('config',route('garantia_guia_ingreso.index'))

@section('content')
<div id="modal-form" class="modal fade" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Agregar</h3>

                    <p>Selecciona marca a agregar</p>

                    <form action="{{ route('garantia_guia_ingreso.create') }}"  enctype="multipart/form-data" method="get">
                        <div class="form-group">{{-- <label>Marca</label> --}}
                            <div class="form-group row"><label class="col-sm-2 col-form-label">Marca:</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="familia">
                                    @foreach($marcas as $marca)
                                    <option value="{{$marca->id}}" >{{$marca->nombre_empresa}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Grabar</strong></button>
                    </form>

                        </div>
                </div>

            </div>
    </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row ibox-title" style="padding-right: 3.1%;margin: 0" >
        {{-- <div class="ibox-tools"> --}}
            {{-- <a class="btn btn-success"  href="" >Imprimir --}}
                <div class="col-sm-6">
                    <a href="{{ route('garantia_guia_ingreso.edit', $garantia_guia_ingreso->id) }}"><button type="button" class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                </div>
            <div class="col-sm-6 tooltip-demo "align="right"  >


            <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_ingreso' ,$garantia_guia_ingreso->id)}}">
                <input type="text" name="archivo" id="texto2"  maxlength="50" value="{{$garantia_guia_ingreso->orden_servicio}}" oninput="actualizatext()" />
                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg" ></i>  </button>
            </form>

            @if(Auth::user()->email_creado == 0)
                 <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#config" ><i class="fa fa-envelope fa-lg " ></i>  </button>
            @else
                <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                    @csrf
                    <input type="text" hidden="hidden" name="tipo" value="App\GarantiaGuiaIngreso"/>
                    <input type="text" hidden="hidden" name="id" value="{{$garantia_guia_ingreso->id}}"/>
                    <input type="text" hidden="hidden" name="redict" value="garantia_guia_ingreso">
                    <input type="text" hidden="hidden" name="cliente" value="{{$garantia_guia_ingreso->clientes_i->email}}">
                    <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
                </form>
            @endif
            <a href="{{route('impresiones_ingreso' ,$garantia_guia_ingreso->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i>   </a>
            <div id="auto" onclick="divAuto()">
                <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
            </div>
            <div id="div-mostrar">
               <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                @csrf
                 <input type="tel" name="numero"  value="{{$garantia_guia_ingreso->clientes_i->celular}}"   />
                 <input type="text" name="mensaje" id="texto_orden" hidden="" />
                 <input type="text" hidden="" name="url" value="{{route('pdf_ingreso' ,$garantia_guia_ingreso->id)}}?archivo=">
                 <input type="text" name="name_sin_cambio" hidden="" value="{{$garantia_guia_ingreso->orden_servicio}}" />
                <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
            </form>
            </div>
            </div>
    </div>
    <div class="row" >
        <div class="col-lg-12" style="margin-top: -2px">
            <div class="ibox-content p-xl" style=" margin-bottom: 2px;padding-bottom: 50px;">
                <div class="row" style="height: 120px">
                    <div class="col-sm-4 text-left" align="left">
                        <div class="form-control" align="center" style="height: 79%;" align="left">
                            <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" align="center" style="height: 79%;" align="center"  >
                            <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
                         </div>
                    </div>
                    <div class="col-sm-4" align="right" >
                        <div class="form-control" align="center" style="height: 79%;"align="right">
                            <h3 style="">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">GUIA DE INGRESO</h2>
                            <h5>{{$garantia_guia_ingreso->orden_servicio}}</h5>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3>Contacto Cliente</h3>
                            <div align="left">
                                <strong>Señor(es):</strong> &nbsp;{{$garantia_guia_ingreso->clientes_i->nombre}}<br>
                                <strong>{{$garantia_guia_ingreso->clientes_i->documento_identificacion}} :</strong> &nbsp;{{$garantia_guia_ingreso->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$garantia_guia_ingreso->fecha}}<br>
                                <strong>Telefono:</strong>&nbsp;{{$garantia_guia_ingreso->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Correo:</strong>&nbsp; {{$garantia_guia_ingreso->clientes_i->email}}<br>
                                <strong>Direccion:</strong>&nbsp; {{$garantia_guia_ingreso->clientes_i->direccion}}<br>
                                <strong>Contacto:&nbsp;</strong>
                                @if($garantia_guia_ingreso->contacto_cliente_id == null)
                                <em>Sin Registro</em>
                                @else
                                {{$contacto->where('id','=',$garantia_guia_ingreso->contacto_cliente_id)->pluck('nombre')->first()}} &nbsp;
                                @endif
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                         <div class="form-control" >
                             <h3>Condiciones Generales</h3>
                             <div align="left">
                                <strong>Ing. Asignado:</strong>&nbsp;{{$garantia_guia_ingreso->personal_laborales->nombres}} {{$garantia_guia_ingreso->personal_laborales->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <strong>Motivo:</strong>&nbsp;{{$garantia_guia_ingreso->motivo}}<br>
                                <strong>Marca :</strong>&nbsp;{{$garantia_guia_ingreso->marcas_i->nombre}} &nbsp;<br>

                                <strong>Asunto:</strong>&nbsp;{{$garantia_guia_ingreso->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                            </div>
                        </div>
                    </div>
                    <br>
                   <div class="col-sm-12" align="center" style="padding-top: 15px;">
                        <div class="form-control" style="height: 100%">
                             <h3>Datos del Equipo</h3>
                             <div class="row" style="padding-bottom: 1px">
                                 <div align="left" class="col-sm-6">
                                    <strong>Modelo:</strong> &nbsp;{{$garantia_guia_ingreso->nombre_equipo}}<br>
                                    <strong>Número de serie:</strong> &nbsp;{{$garantia_guia_ingreso->numero_serie}}<br>
                                </div>
                                <div align="left" class="col-sm-6">
                                    <strong>Codigo Interno:</strong>&nbsp; {{$garantia_guia_ingreso->codigo_interno}}<br>
                                    <strong>Fecha de Compra:</strong> &nbsp;{{$garantia_guia_ingreso->fecha_compra}}<br>
                                </div>
                            </div>
                        </div>
                    </div>

            </div><br>
                   <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-4" align="center">
                        <div class="form-control" style="height: 100%"><h3>Descripcion del Problema:</h3>
                            <div align="left" style="font-size: 13px;" >
                                <p>{{$garantia_guia_ingreso->descripcion_problema}}</p>
                           </div>
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Revisión y diagnóstico</h3>
                            <div align="left" style="font-size: 13px;">
                                <p>  {!! nl2br($garantia_guia_ingreso->revision_diagnostico)!!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Estética</h3>
                            <div align="left" style="font-size: 13px">
                                <p> {!! nl2br($garantia_guia_ingreso->estetica)!!}</p>
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
                <strong>Telefonos :</strong>  {{$empresa->telefono}} / {{Auth::user()->celular}} &nbsp;<br>
                <strong>SOPORTE {{$garantia_guia_ingreso->marcas_i->nombre}}:</strong> {{$garantia_guia_ingreso->marcas_i->telefono}}<br>
                <strong>Email:</strong> {{Auth::user()->email}}<br>
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
                                                <select class="form-control" name="encryp" >
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
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

{{-- <script>
function printExternal(url) {
    var printWindow = window.open( url, 'Print', 'left=200, top=200, width=950, height=500, toolbar=0, resizable=0');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}
</script> --}}
<script  type="text/javascript">
    function actualizatext() {
            let action = document.getElementById("texto2").value;
            document.getElementById("texto_orden").value = action;
        }
</script>
@endsection
