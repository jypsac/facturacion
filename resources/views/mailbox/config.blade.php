@extends('layout')

@section('title', 'Configurar - Email')
@section('breadcrumb', 'configuracion')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('inicio') )
@section('value_accion', 'Atras')
@section('vue_js',  asset('js/app.js') )

@section('content')
<br/>
<div>
	<form action="{{route('guardar')}}" method="POST" >
		<div>
		Email<input type="text" name="">
		Contraseña <input type="password" name="">
		Email backup<input type="text" name="">
		Smtp<input type="text" name="">
		Puerto<input type="text" name="">
		Encryptacion<input type="text" name="">
		<button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" >
                    <i class="fa fa-reply"></i> Enviar
		</div>
	</form>
</div>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@stop	