@extends('layout')

@section('title', 'Enviar - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
@section('vue_js',  asset('js/app.js') )

@section('content')
<br/>
<style type="text/css">
    .note-toolbar-wrapper{
        height: 0% !important;
    }
    div.note-editable.card-block{
        max-height: 2% !important;
    }
    table.table.table-bordered{
        border: currentColor; !important;
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
<div class="col-lg-10 container animated fadeInRight">
  
  <div class="mail-box">
    
      <form action ="{{route('garantia_ingreso.enviar')}}" method="POST" enctype="multipart/form-data" >
                @csrf
                <input type="hidden" value="{{$id}}" name="id">
                <div class="mail-body">
          <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Para:</label>
                   <div class="col-sm-10">
                            <input type="email" required="" class="form-control" name="sendto">
                        </div>
          </div>
          <div class="form-group row"><label class="col-sm-2 col-form-label">Tema:</label>
              <div class="col-sm-10"><input type="text" required="" class="form-control" name="titulo" ></div>
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
                        <input  type="file" name="archivo[]" multiple="" />
                    </span>
                    <span class="fileinput-filename" style="padding-left: 30px"></span>
                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                </div>  
      <div class="mail-body text-right tooltip-demo">
          <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" >
                    <i class="fa fa-reply"></i> Enviar
                </button>
          <a href="/index" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" >
                    <i class="fa fa-times"></i> Descartar
                </a>
      </div>
        </form>
  </div>
</div>
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

    <!-- SUMMERNOTE -->
    <script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
     <!-- Jasny -->
    <script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>

    <script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,
      });

    });
  </script>
    <!--<link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet"> -->
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    @stop