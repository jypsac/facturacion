
@extends('layout')

@section('title','Enviar - '.$archivo )
@section('breadcrumb', 'Ver Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index'))
@section('value_accion', 'Atras')

@section('content')
<br/>
    <div class="col-lg-10 container animated fadeInRight" >
        <div class="mail-box">
            <form action ="{{route('email.send')}}" method="POST" enctype="multipart/form-data" >
                <input type="text" hidden=""  name="dates" value="{{$date}}" id="">
                <input type="text" hidden="" name="redict" value="{{$redic}}">
                @csrf
                <div class="mail-body">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Para:</label>
                        <div class="col-sm-10">
                            <input type="email" required="" value="{{$clientes}}" class="form-control" name="remitente" >
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
                <div class="form-group row container">
                    <div class="col-lg-2">
                        <div class="file" style="width: 150px">
                            <a href="{{asset('/archivos/'.$date.$archivo)}}"
                                            download="{{$archivo}}" >
                            <div class="file-name" style="background-color: white">

                                <center>
                                    <i class="fa fa-file" style="font-size:  60px"></i>
                                </center>

                            </div>
                            <div class="file-name">
                                <input type="text" name="redict" hidden="hidden" value="{{$redic}}">
                                <input type="text" name="pdf" hidden="" value="{{$archivo}}">
                                {{$archivo}}
                                <br/>
                                <small>{{ date('Y-m-d H:i:s') }} </small>
                            </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <span class="btn btn-default btn-file" style="left: 20px !important;">
                                <span class="fileinput-new">Seleccionar</span>
                                <span class="fileinput-exists">Cambiar</span>
                                <input  type="file" name="archivos[]" multiple="" />

                            </span>
                            <span class="fileinput-filename" style="padding-left: 30px"></span>
                            <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                        </div>
                    </div>
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
        <br/>
    </div>
<br/>
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
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
@endsection