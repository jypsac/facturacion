@extends('layouts.app')
@section('content')
<head>
	<title>asdadsd</title>
</head>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
	<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
	<script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
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
				<span style="text-decoration: underline;">Titular:</span> '{{$nombre_personal}}'<br><br>
				<span style="font-weight: bold;">'{{$codigo_unidos}}</span>' es tu código de Validación para confirmar el usuario al sistema. Esta clave es confidencial, no la compartas con nadie. Solo ingrésala en el Sistema para continuar con tu confirmacion.<br><br>
            	<span style="text-decoration: underline;">Fecha y hora:</span>  '{{$usuario_hora}}'<br><br>
            	Si no has realizado esta operación o tienes cualquier duda respecto al Código de Validación, puedes comunicarte con nuestro correo de soporte <a href="mailto:desarrollo@jypsac.com">desarrollo@jypsac.com</a>.
			</div>
		</div>
	</div>
	<div align="center" style="padding-top: 10px">
		<a href="https://jypsac.com" target="_blank"><img src="https://www.jypsac.com/wp-content/uploads/2020/04/logo_jypsac_png.png"  width="70px"></a>
	</div>
</body>
@endsection
