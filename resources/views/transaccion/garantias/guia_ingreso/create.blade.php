@extends('layout')

@section('title', 'Crear - Guia de Ingreso')
@section('breadcrumb', 'Crear Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Inicio / Guia Ingreso')
@section('atributo_actu', 'hidden="hidden"')
@extends('layout_agregado_rapido')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
<script type="text/javascript">
	$(document).ready(function() {
		$("form").keypress(function(e) {
			if (e.which == 13) {
				setTimeout(function() {
					e.target.value += '';
				}, 4);
				e.preventDefault();
			}
		});


	});
</script>

@section('form_action_modal_cliente',  route('agregado_rapido.cliente_cotizado'))
@section('ruta_retorno', 'garantia_guia_ingreso')
<div class="social-bar">
	<a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	@if($errors->any())
	<div class="alert alert-danger">
		<a class="alert-link" href="#">
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</a>
	</div>
	@endif
	<div class="ibox">
		<div class="ibox-content" style=" margin-bottom: 2px;padding-bottom: 50px;padding: 30px;">
			<div class="row" style="height: 120px">
				<div class="col-sm-4 text-left" align="left">
					<div class="form-control for" align="center" style="height: 79%;" align="left">
						<img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
					</div>
				</div>
				<div class="col-sm-4" align="center">
					<div class="form-control for" align="center" style="height: 79%;" align="center"  >
						<img align="center" src="{{asset('archivos/imagenes/marcas/'.$marca_t->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
					</div>
				</div>
				<div class="col-sm-4" align="right" >
					<div class="form-control for" align="center" style="height: 79%;"align="right">
						<h3 style="">R.U.C {{$empresa->ruc}}</h3>
						<h2 style="font-size: 19px">GUIA DE INGRESO</h2>
						<h5>{{$orden_servicio}}</h5>
					</div>
				</div>
			</div>
			<br>
			<form action="{{route('garantia_guia_ingreso.store')}}"  enctype="multipart/form-data" 	method="post" onsubmit="return valida(this)">
				@csrf
				<input type="hidden" name="marca_id" value="{{$marca_id}}">
				<div class="row" >
					<div class="col-sm-6" align="center" >
						<div class="form-control for">
							<h3>Datos Generales </h3>
							<br>
							<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
								<label class="col-sm-2 col-form-label">Asunto:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for" name="asunto" value="Ingreso de Equipo" required/>
								</div>
								<label class="col-sm-2 col-form-label">Ing. Asignado:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for m-b" value="{{Auth::user()->personal->nombres}}" id="" readonly="">
								</div>
								<label class="col-sm-2 col-form-label">Motivo:</label>
								<div class="col-sm-4">
									<select class="form-control for m-b" name="motivo">
										<option value="Garantia">Garantia</option>
										<option value="Servicio">Servicio</option>
										<option value="Informativo">Informativo</option>
										<option value="Reingreso">Reingreso</option>
									</select>
								</div>
								<label class="col-sm-2 col-form-label">Fecha:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for" value="{{$tiempo_actual}}" readonly>
								</div>

								<label class="col-sm-2 col-form-label">Cliente:</label>
								<div class="col-sm-10">
									<select class="select2_demo_3 form-control" onchange="buscador_contac();" name="cliente_id" id="cliente_id" required  >
										<option></option>
										@foreach($clientes as $cliente)
										<option value="{{$cliente->id}}">{{$cliente->numero_documento}}- {{$cliente->nombre}}</option>
										@endforeach
									</select>
								</div>
								<label class="col-sm-2 col-form-label">Contacto:</label>
								<div class="col-sm-10">
									<select name="contacto_cliente" id="contacto_cliente" class="form-control">
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6" align="center">
						<div class="form-control for">
							<h3>Datos del Equipo</h3>
							<br>
							<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">

								<label class="col-sm-2 col-form-label">Modelo:</label>
								<div class="col-sm-10">
									<select class="select2_demo_3 form-control"  name="nombre_equipos" required  >
										@foreach($productos as $producto)
										<option  value="{{$producto->nombre}}">{{$producto->nombre}}</option>
										@endforeach
									</select>
								</div>
								<label class="col-sm-2 col-form-label">Nr Serie:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control for" name="numero_serie"  value="0" required>
								</div>
								<label class="col-sm-2 col-form-label">Codigo Interno:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control for" name="codigo_interno" value="000000" required>
								</div>
								<label class="col-sm-2 col-form-label">Fecha de Compra:</label>
								<div class="col-sm-10">
									<input type="date" class="form-control for" name="fecha_compra" max="{{date('Y-m-d')}}" value="{{date('Y-m-d')}}" required>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12" align="center" style="margin-top: 10px">
						<div class="form-control for">
							<center><h3>Informe del Problema</h3></center>
							<br>
							<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
								<div class="col-sm-4">
									<center><h4>Descripcion del Problema</h4></center>
									<div class="input-group m-b">
										<textarea class="form-control for" rows="5" id="comment" name="descripcion_problema" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
									</div>
								</div>
								<div class="col-sm-4">
									<center><h4>Revisión y diganostico</h4></center>
									<div class="input-group m-b">
										<textarea class="form-control for" rows="5" id="comment" name="revision_diagnostico" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
									</div>
								</div>
								<div class="col-sm-4">
									<center><h4>Estética</h4></center>
									<div class="input-group m-b">
										<textarea class="form-control for" rows="5" id="comment" name="estetica" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
									</div>
								</div>
							</div>
						</div>
						{{-- <div align="ibox" align="right"> --}}
							<button style="align: left" class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" ><strong>Grabar</strong></button>
						{{-- </div> --}}
					</div>
				</div>
			</form>
		</div>
	</div>

</div>
<style>
.form-control{ margin-top: 5px;}
</style>


<style>
span.select2-selection.select2-selection--single{border: 1px solid #5f232326;height: 36px; color: gray}
span .select2-selection__rendered{color:#000000c7;}
</style>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"><9/script> --}}
	<script>
		function buscador_contac()
		{
			$value=$('#cliente_id').val();
			$.ajax({
				type: 'get',
				url: '{{URL::to('contacto_cliente')}}',
				data: {'cliente_id':$value},
				success:function(data){
					$('#contacto_cliente').html(data);
				}
			})
		}

	</script>

	<!-- Mainly scripts -->
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
	<!-- Jquery Validate -->
	<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

	<!-- Steps -->
	<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>

	<!-- Select2 -->
	<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
	<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
	<script>
		$(".select2_demo_2").select2();
		$(".select2_demo_3").select2({
			placeholder: "Seleccionar Cliente",
			allowClear: false
		});
	</script>

		@stop