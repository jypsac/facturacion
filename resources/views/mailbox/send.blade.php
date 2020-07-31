@extends('layout')

@section('title', 'Enviar - Email')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')
@section('vue_js',  asset('js/app.js') )

@section('content')
<br/>
<div class="col-lg-9 container animated fadeInRight">
	
	<div class="mail-box">
		<div class="mail-body">
			<form action ="{{route('enviarmail')}}" method="POST" enctype="multipart/form-data">
    			<div class="form-group row"><label class="col-sm-2 col-form-label">Para:</label>
        			<div class="col-sm-10"><input type="text" class="form-control" name="enviara"></div>
    			</div>
    			<div class="form-group row"><label class="col-sm-2 col-form-label">Tema:</label>
       		 		<div class="col-sm-10"><input type="text" class="form-control" name="titulo" ></div>
    			</div>
			</div>
			<div class="mail-text h-200">
		    	<div class="summernote" name="mensaje">
	       		 	<h3>Hello Jonathan! </h3>
				        dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
				        when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
				        typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
	        		<br/>
	        		<br/>
	    		</div>
	    		<br/>	
	    		<div class="fileinput fileinput-new container" data-provides="fileinput" >
    				<span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span>
    				<span class="fileinput-exists">Change</span><input type="file" multiple name="..."/></span>
    				<span class="fileinput-filename"></span>
    				<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
				</div> 
	    	</div>
	    		
			<div class="mail-body text-right tooltip-demo">
	    		<button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" ><i class="fa fa-reply"></i> Enviar</button>
	    		<a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Descartar</a>
			</div>
    		</form>
		<div class="clearfix"></div>
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

    <!-- DROPZONE -->
    <script src="{{asset('js/plugins/dropzone/dropzone.js')}}"></script>

    <!-- CodeMirror -->
    <script src="{{asset('js/plugins/codemirror/codemirror.js')}}"></script>
    <script src="{{asset('js/plugins/codemirror/mode/xml/xml.js')}}"></script>
    <script>
        $(document).ready(function(){

            $('.summernote').summernote();

        });

    </script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/plugins/summernote/summernote-bs4.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/plugins/dropzone/basic.css" rel="stylesheet">
    <link href="css/plugins/dropzone/dropzone.css" rel="stylesheet">
    <link href="css/plugins/jasny/jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css/plugins/codemirror/codemirror.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
@stop