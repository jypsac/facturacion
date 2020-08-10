@extends('layout')

@section('title', 'Configuracion Email')
@section('breadcrumb', '#')
@section('breadcrumb2', '#')
{{-- @section('href_accion', route('usuario.lista')) --}}
@section('value_accion', 'Atras')

@section('content')
<br/>
	<div>
		<form action="" method="">
			<div class="form-group  row">
		 		<label class="col-sm-2 col-form-label">Correo Electronico</label>
	    		<div class="col-sm-10"><input type="email" name="email" class="form-control"></div>
			</div>
			<div class="form-group  row">
		 		<label class="col-sm-2 col-form-label">Contraseña</label>
	    		<div class="col-sm-10"><input type="password" name="password" class="form-control"></div>
			</div>
			<div class="form-group  row">
		 		<label class="col-sm-2 col-form-label">Email Bakcup</label>
	    		<div class="col-sm-10"><input type="email" name="backup" class="form-control"></div>
			</div>
			<div class="form-group  row">
		 		<label class="col-sm-2 col-form-label">Smtp</label>
	    		<div class="col-sm-10"><input type="text" name="smtp" class="form-control"></div>
			</div>
			<div class="form-group  row">
		 		<label class="col-sm-2 col-form-label">Puerto</label>
	    		<div class="col-sm-10"><input type="text" name="port" class="form-control"></div>
			</div>
			<div class="form-group  row">
		 		<label class="col-sm-2 col-form-label">Encriptacion</label>
	    		<div class="col-sm-10"><input type="text" name="encrypt" class="form-control"></div>
			</div>
		</form>
	</div>



<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@endsection