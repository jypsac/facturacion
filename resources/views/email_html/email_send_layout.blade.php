@extends('layouts.app')
@section('content')
<head>
	<title>asdadsd</title>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
	<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
	<script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 	<script>
      	$(document).ready(function(){
        	$("table").removeClass("table table-bordered").addClass("css");
      	});
	</script>
	<style>
	    .css,table,tr,td{
	      padding: 15px;
	      border: 1px solid black;
	      border-collapse: collapse;
	        }
	    table{
	      width:100%;
	    }
      </style>
</head>
<body class="row" style="text-align: justify;">
	<div class="col-sm-4" align="center">
		<br>
		<center >
      		<img src="{{asset('img/logos/'.$empresa->foto)}}" style="width: 300px;margin-bottom: 15px;">
      	</center>
	</div>
	<div class="col-sm-12">
		<div class="card" style="padding: 7px 10px 7px 7px;border-radius: 10px">
			<div>
				<h2 align="center"></h2>
					{!!$mensaje_html!!}
            	@if($firma != null)
	          	<footer>
	          		<img name="firma" src=" '.url('/').'/archivos/imagenes/firmas/'.$firma.'" width="{{$ancho}}px" height=" '{{$alto}}px" />
	          	</footer>
            	@endif
			</div>
		</div>
	</div>

	<div align="center" style="padding-top: 10px">
		<a href="https://jypsac.com" target="_blank"><img src="https://www.jypsac.com/wp-content/uploads/2020/04/logo_jypsac_png.png"  width="70px"></a>
	</div>
</body>
@endsection
