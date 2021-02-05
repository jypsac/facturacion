@extends('layout')
@section('title', 'Email')
@section('breadcrumb', 'Email')
@section('breadcrumb2', 'Email')

@if( $user->email_creado==0)
    @section('data-toggle', 'modal')
    @section('href_accion', '#configu')
    @section('value_accion', 'Redactar')
    @section('data-config', 'modal')
    @section('config', '#configu')
    @section('nombre', '')
    @section('class', 'btn btn-primary fa fa-gear')

@elseif( $user->email_creado==1)
    @section('data-toggle', 'modal')
    @section('href_accion', '#redactar')
    @section('value_accion', 'Redactar')

    @section('data-config', 'modal')
    @section('config', '#edits')
    @section('nombre', '')
    @section('class', 'btn btn-primary fa fa-gear')

@endif
@section('content')

@if($errors->any())
<div style="padding-top: 10px">
      <div class="alert alert-danger">
            <a class="alert-link" href="#">
              @foreach ($errors->all() as $error)
              <li style="color: red">{{ $error }}</li>
              @endforeach
            </a>
      </div>
 </div>
@endif
{{-- Modal Configuracion --}}
<div class="modal fade" id="configu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{route('email.configstore')}}"  enctype="multipart/form-data" method="post">
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


{{-- Modal Editar Configuracion --}}
@foreach($config_email as $config_emails)
<div class="modal fade" id="edits" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Editar Correo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{route('email.configupdate',$config_emails->id)}}"  enctype="multipart/form-data" method="post">
                        @csrf

                        <div class="row">
                            <fieldset>
                                <legend> Configuracion </legend>
                                    <div class="panel-body" align="left">
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Email:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" name="email" value="{{$config_emails->email}}">
                                            </div>

                                            <label class="col-sm-2 col-form-label">Contraseña:</label>
                                            <div class="col-sm-10">
                                                <div class="input-group m-b">
                                                    <input type="password" class="form-control" value="{{$config_emails->password}}" name="password" id="txtPassword{{$config_emails->id}}">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
                                                            <i class="fa fa-eye-slash "  id="ojo{{$config_emails->id}}" onclick="mostrarPassword{{$config_emails->id}}()"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">SMPT:</label>
                                            <div class="col-sm-4">

                                                <input type="text" class="form-control" name="smtp" value="{{$config_emails->smtp}}">
                                            </div>

                                            <label class="col-sm-2 col-form-label">PORT:</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="port" value="{{$config_emails->port}} " >
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Encryption:</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="encryp">
                                                    <option value="{{$config_emails->encryption}}">{{$config_emails->encryption}}</option>
                                                    <option value="">Ninguno</option>
                                                    <option value="SSL">SSL</option>
                                                    <option value="TLS">TLS</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Firma (opcional):</label>
                                            <div class="col-sm-10">
                                                <input type="file" style="position:absolute;top:0px;left:0px;right:0px;bottom:0px;width:100%;height:100%;opacity: 0 ;" id="archivoInput{{$config_emails->id}}" name="firma" onchange="return validarExt{{$config_emails->id}}()"  />
                                                <span id="visorArchivo{{$config_emails->id}}">
                                                    <!--Aqui se desplegará el fichero-->
                                                    <img name="firma" src="{{asset('/archivos/imagenes/firmas/')}}/{{$config_emails->firma}}" width="390px" height="200px" />
                                                    <input type="text" name="firma_nombre" hidden="hidden" value="{{$config_emails->firma}}">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2 col-form-label">Ancho(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="ancho_firma" value="{{$config_emails->ancho_firma}}">
                                                </div>
                                            <label class="col-sm-2 col-form-label" >Alto(px)</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="alto_firma" value="{{$config_emails->alto_firma}}">
                                                </div>
                                        </div>
                                    <br>
                                </div>
                            </fieldset>
                        </div>
                        <button class="btn btn-primary" type="submit">Grabar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <script type="text/javascript">
                        function validarExt{{$config_emails->id}}()
                        {
                        var archivoInput{{$config_emails->id}} = document.getElementById('archivoInput{{$config_emails->id}}');
                        var archivoRuta = archivoInput{{$config_emails->id}}.value;
                        var extPermitidas = /(.jpg|.png|.jfif)$/i;
                        if(!extPermitidas.exec(archivoRuta)){
                            alert('Asegurese de haber seleccionado una Imagen');
                            archivoInput{{$config_emails->id}}.value = '';
                            return false;
                        }

                        else
                        {
                        //PRevio del PDF
                        if (archivoInput{{$config_emails->id}}.files && archivoInput{{$config_emails->id}}.files[0])
                        {
                            var visor = new FileReader();
                            visor.onload = function(e)
                            {
                                document.getElementById('visorArchivo{{$config_emails->id}}').innerHTML =
                                '<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
                            };
                            visor.readAsDataURL(archivoInput{{$config_emails->id}}.files[0]);
                        }
                        }
                        }
                        </script>
                        <script type="text/javascript">
                        {{-- scrpti de ver y ocultar contraseña del Foreach --}}
                        function mostrarPassword{{$config_emails->id}}(){
                        var cambio = document.getElementById("txtPassword{{$config_emails->id}}");
                        if(cambio.type == "password"){
                            cambio.type = "text";
                            $('#ojo{{$config_emails->id}}').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
                        }else{
                            cambio.type = "password";
                            $('#ojo{{$config_emails->id}}').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
                        }
                        }

                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- Modal Editar Confg¿figuracion Fin --}}


<!-- Modal Create Redactar  -->
<div class="modal fade" id="redactar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 700px;margin-left: 400px;">
        <div class="modal-content" style="width: 702px;">
            <div class="modal-header" style="width: 700px;padding-left: 0px;padding-right: 0px;">
                {{--  --}}
                <div class="col-lg-10 container animated fadeInRight" style="width: 600px;padding-left: 0px;padding-right: 0px;margin-right: 30px;margin-left: 60px;">
                    <div class="mail-box">
                        @foreach($config_email as $config_emails)
                        <form action ="{{route('email.store')}}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <div class="mail-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Para:</label>
                                    <div class="col-sm-10">
                                        <input type="email" required="" class="form-control" name="remitente" list="browsers" autocomplete="off" >
                                        <datalist id="browsers">
                                            @foreach($clientes as $cliente )
                                            <option value="{{$cliente->email}}">
                                                @endforeach
                                            </option>
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Asunto:</label>
                                        <div class="col-sm-10"><input type="text" required="" class="form-control" name="asunto" ></div>
                                    </div>
                                </div>
                                <div class="mail-text h-200">
                                    <textarea name="mensaje" required="" class="summernote" id="contents" >
                                    </textarea>
                                </div>
                                <br/>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-default btn-file" style="left: 20px !important;">
                                        <span class="fileinput-new">Seleccionar</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input  type="file" name="archivos[]" multiple="" />
                                        {{-- <input type="file" name="archivo"> --}}
                                    </span>
                                    <span class="fileinput-filename" style="padding-left: 30px"></span>
                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                </div>
                                <div class="mail-body text-right tooltip-demo">
                                    <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top"   onclick="doAction(this, 'i', 'Loading')">
                                        <i class="fa fa-reply"></i> Enviar
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <span id="i" hidden="" ><i  class="fa fa-spinner fa-pulse fa-2x fa-fw"  ></i></span>
                                    <span id="Loading" hidden=""><span style="width: 20px" class="sr-only">Loading...</span></span>

                                </div>
                            </form>
                        </div>
                    </div>
                    {{--  --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- / Modal Create  -->




    <div class="fh-breadcrumb">
        <div class="fh-column">
            <div class="full-height-scroll">
                <ul class="list-group elements-list">
                    @foreach($mailbox as $row)
                    <li class="list-group-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-{{$row->id}}" style="padding-top: 5px;padding-bottom: 5px;">
                            <span hidden="hidden">{{$mensaje_limitado=$row->mensaje_sin_html}}
                            {{$cate = substr($mensaje_limitado, 0, 10)}}</span>
                            <strong style="font-size: 10px">{{$row->remitente}}</strong>
                            <div class="small m-t-xs">
                                <p class="m-b-xs">
                                  {{$cate}}...
                              </p>
                              <p class="m-b-none">
                                <i class="fa fa-map-marker"></i> Lima,Perú <span class="float-right text-muted">{{$row->fecha_hora}}</span>
                            </p>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="full-height">
        <div class="full-height-scroll white-bg border-left">

            <div class="element-detail-box">

                <div class="tab-content">
                    @foreach($mailbox as $row)
                    <div id="tab-{{$row->id}}" class="tab-pane">

                        <div class="float-right">
                            <div class="tooltip-demo">
                            {{-- <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="left" title="Plug this message"><i class="fa fa-plug"></i> Plug it</button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as important"><i class="fa fa-exclamation"></i> </button> --}}
                            <form action="{{route('email.delete')}}" method="post">
                                @csrf
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to trash"><i class="fa fa-trash-o"></i> </button>
                            <input type="hidden" name="id" value="{{$row->id}}" />

                            </form>
                        </div>
                    </div>
                    <div class="small text-muted">
                        <i class="fa fa-clock-o"></i> {{$row->fecha_hora}}
                    </div>
                    <span hidden="hidden">{{$remitente_limi=$row->remitente}}
                    {{$remi = substr($remitente_limi, 0, 1)}}</span>
                    <h1><div class="row">
                        <div class="col-sm-1" style=" padding-right: 0px;">
                            <div  class="rounded-circle" style="background: #8D8D8D; width: 50px; height: 50px ;color: white" align="center">{{$str = strtoupper($remi)}}</div>
                        </div>
                        <div class="col-sm-3" style="padding-left: 0px">
                           {{$row->asunto}}
                       </div>

                   </div></h1>
                   {{-- <img alt="image" class="rounded-circle" src=" {{ asset('/profile/images/')}}/@yield('foto', auth()->user()->personal->foto)" style="width: 50px" /> --}}
                   <h5>De: {{$row->remitente}}</h5>
                   <hr>
                   {!!$row->mensaje!!}
                   {{-- <p class="small"> --}}
                    {{-- Firma --}}
                    {{-- <strong>Best regards, Anthony Smith </strong>
                </p> --}}

                <div class="m-t-lg">
                    <p>
                        <span><i class="fa fa-paperclip"></i> Archivos </span>
                        </p>
                        <div class="attachment">
                            @foreach($mailbox_file as $mailbox_files)
                                @if($mailbox_files->id_bandeja_envios ==  $row->id)
                                    @if( isset($mailbox_files->archivo) )
                                    <div class="file-box" style="width: 170px">
                                        <div class="file" style="width: 150px;margin: 0px 0px 0px 0px">
                                            {{-- {{storage_path('app/public/'.$mailbox_files->archivo)}} --}}
                                            <a href="{{asset('/archivos/'.$mailbox_files->fecha_hora.$mailbox_files->archivo)}}"
                                            download="{{$mailbox_files->archivo}}" >
                                            {{-- <a href="{{route('descarga')}}" target="_blank"> --}}
                                                {{-- <span class="corner"></span> --}}
                                                {{-- <div class="icon">
                                                    <p><i class="fa fa-file"></i></p>
                                                </div> --}}
                                                <div class="file-name" style="background-color: white">
                                                    <center>
                                                        <i class="fa fa-file" style="font-size:  60px"></i>
                                                    </center>
                                                </div>
                                                <div class="file-name">
                                                    {{$mailbox_files->archivo}}
                                                    <br>
                                                    <small>{{$mailbox_files->fecha_hora}}</small>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                @endif
                            @endforeach

                           {{--  @foreach($mailbox_file as $mailbox_files)
                                @if($mailbox_files->id_bandeja_envios ==  $row->id)
                                    @if( isset($mailbox_files->imagen) )
                                    <div class="file-box">
                                        <div class="file">
                                            <a href="#">
                                                <span class="corner"></span>

                                                <div class="icon">
                                                    <i class="fa fa-file-pdf-o"></i>
                                                </div>
                                                <div class="file-name">
                                                   {{$mailbox_files->imagen}}
                                                    <br>
                                                        <small>Añadido: {{$mailbox_files->fecha_hora}}</small>
                                                </div>
                                            </a>
                                        </div>

                                    </div>
                                    @endif
                                @endif
                            @endforeach --}}
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

        </div>

    </div>
</div>

</div>
<!-- Mainly scripts -->
</br>
<style>
    #actualizar{
        height: 33px; padding-top: 10px;
    }
/*#page-wrapper{height: 500px;}*/
.note-toolbar-wrapper{
    height: 0% !important;
}
div.note-editable.card-block{
    max-height: 2% !important;
}
 table.table.table-bordered, td, th {
  border: 1px solid black !important;
}
div.form-group.note-form-group.note-group-select-from-files{
    display: none !important;
}
div.fileinput.fileinput-exists{
    left: 25px !important;
}
span.fileinput-filename{
    left: 25px !importants;
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

<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<script>
    function doAction(ele, param1, param2) {
      var a = document.getElementById(param1).innerHTML;
      var b = document.getElementById(param2).innerHTML;
      ele.innerHTML = a + " " + b;
  }</script>
  <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,

    });

  });

</script>
<script type="text/javascript">
        // <div class="col-sm-10">
        // <div class="input-group m-b">
        // <input type="password" class="form-control" name="password" id="txtPassword">
        // <div class="input-group-prepend">
        // <span class="input-group-addon" style="height: 35.22222px;margin-top: 5px;">
        // <i class="fa fa-eye " id="ojo" onclick="mostrarPassword()"></i></span>
        // </div>
        // </div>
        // </div>
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
function validarExt(){
    var archivoInput = document.getElementById('archivoInput');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
        alert('Asegurese de haber seleccionado una Imagen');
        archivoInput.value = '';
        return false;
    }else{
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
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
@endsection
