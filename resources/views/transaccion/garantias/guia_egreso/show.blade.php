@extends('layout')

@section('title', 'Ver - Guia de Egreso')
@section('breadcrumb', 'Ver Guia de Egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.guias'))
@section('value_accion', 'Nueva Guia')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox-title" align="right" style="padding-right: 3.1%">
        {{-- <div class="ibox-tools"> --}}
            {{-- <a class="btn btn-success"  href="" >Imprimir --}}
            <div class="tooltip-demo">
            <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_egreso' ,$garantias_guias_egreso->id)}}">
                <input type="text" name="archivo" maxlength="50" value="{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}" oninput="actualizatext()" id="texto2">
                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
            </form>
            @if(Auth::user()->email_creado == 0)
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#config" ><i class="fa fa-envelope fa-lg " ></i>  </button>
            @else
                <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
                    @csrf
                    <input type="text" hidden="hidden"  name="tipo" value="App\GarantiaGuiaEgreso"/>
            <input type="text" hidden="hidden"  name="id" value="{{$garantias_guias_egreso->id}}"/>
            <input type="text" hidden="hidden"  name="redict" value="garantias_guias_egreso"/>
            <input type="text" hidden="hidden"  name="cliente" value="{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}"/>
           <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
                </form>
            @endif
            <a href="{{route('impresiones_egreso' ,$garantias_guias_egreso->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i>   </a>
            <div id="auto" onclick="divAuto()">
                <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
            </div>
            <div id="div-mostrar">
                {{-- <br style="width: -1px"> --}}
               <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                @csrf
                 <input type="tel" name="numero"  value="{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->celular}}"  />
                 <input type="text" name="mensaje" id="texto_orden" hidden="" />
                 <input type="text" hidden="" name="url" value="{{route('pdf_ingreso' ,$garantias_guias_egreso->id)}}?archivo=">
                 <input type="text" name="name_sin_cambio" hidden="" value="{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}" />
                <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
            </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="margin-top: -2px">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row" style="height: 120px">
                    <div class="col-sm-4 text-left" align="left">
                        <div class="form-control" align="center" style="height: 79%;" align="left">
                            <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 320px;margin-top: 5px">
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" align="center" style="height: 79%;" align="center">
                            <img align="center" src="{{asset('storage/marcas/'.$garantias_guias_egreso->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 70px;width: 320px;margin-top: 5px">
                         </div>
                    </div>
                    <div class="col-sm-4" align="right" >
                        <div class="form-control" align="center" style="height: 79%;" align="right">
                            <h3 style="">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">GUIA DE EGRESO</h2>
                            <h5>{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}</h5>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3>Contacto Cliente</h3>
                            <div align="left">
                                <strong>Señor(es):</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br>
                                <strong>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}} :</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$garantias_guias_egreso->fecha}}<br>
                                <strong>Telefono:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Correo:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}<br>
                                <strong>Direccion:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->direccion}}<br>
                                <strong>Contacto:&nbsp;</strong>
                                @if($garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id == null)
                                <em>Sin Registro</em>
                                @else
                                {{$contacto->where('id','=',$garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id)->pluck('nombre')->first()}} &nbsp;
                                @endif
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                         <div class="form-control" >
                             <h3>Condiciones Generales</h3>
                             <div align="left">
                                <strong>Ing. Asignado:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <strong>Motivo:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}<br>
                                <strong>Marca :</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}} &nbsp;<br>

                                <strong>Asunto:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <br>
                            </div>
                        </div>
                    </div>
                    <br>
                   <div class="col-sm-12" align="center" style="padding-top: 15px;">
                        <div class="form-control" style="height: 100%">
                             <h3>Datos del Equipo</h3>
                             <div class="row" style="padding-bottom: 1px">
                                 <div align="left" class="col-sm-6">
                                    <strong>Modelo:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->nombre_equipo}}<br>
                                    <strong>Número de serie:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->numero_serie}}<br>
                                </div>
                                <div align="left" class="col-sm-6">
                                    <strong>Codigo Interno:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->codigo_interno}}<br>
                                    <strong>Fecha de Compra:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->fecha_compra}}<br>
                                </div>
                            </div>
                        </div>
                    </div>

            </div><br>
                   <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-4" align="center">
                        <div class="form-control" style="height: 100%"><h3>Descripcion del Problema:</h3>
                            <div align="left" style="font-size: 13px;" >
                                <p>{!! nl2br($garantias_guias_egreso->descripcion_problema)!!}</p>
                           </div>
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Revisión y diagnóstico</h3>
                            <div align="left" style="font-size: 13px;">
                                <p>   {!! nl2br($garantias_guias_egreso->diagnostico_solucion)!!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Recomendaciones</h3>
                            <div align="left" style="font-size: 13px">
                                <p> {!! nl2br($garantias_guias_egreso->recomendaciones)!!}</p>
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
                <strong>Telefono:</strong> {{Auth::user()->celular}} &nbsp;<br>
                <strong>Celular-Soporte:</strong> {{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->telefono}}<br>
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
                                            <div class="col-sm-10"><input type="text" class="form-control" name="email">
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" name="password" id="txtPassword" required="">
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
                                                <input type="text" class="form-control" name="smtp" placeholder="smtp.gmail.com" required="">
                                            </div>

                                            <label class="col-sm-2 col-form-label">PORT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="port" value="110 " >
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
<script  type="text/javascript">
    function actualizatext() {
            let action = document.getElementById("texto2").value;
            document.getElementById("texto_orden").value = action;
        }
</script>

@endsection
