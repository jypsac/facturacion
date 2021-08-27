@extends('layout')

@section('title', 'Editar - Guia de Ingreso')
@section('breadcrumb', 'Editar Guia de Ingreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_ingreso.index') )
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
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
						<img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantia_guia_ingreso->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
					</div>
				</div>
				<div class="col-sm-4" align="right" >
					<div class="form-control for" align="center" style="height: 79%;"align="right">
						<h3 style="">R.U.C {{$empresa->ruc}}</h3>
						<h2 style="font-size: 19px">GUIA DE INGRESO</h2>
						<h5>{{$garantia_guia_ingreso->orden_servicio}}</h5>
					</div>
				</div>
			</div>
			<br>

			<form action="{{ route('garantia_guia_ingreso.actualizar',$garantia_guia_ingreso->id) }}"  enctype="multipart/form-data" method="post">
				@csrf
				@method('put')

				<div class="row" >
					<div class="col-sm-6" align="center" >
						<div class="form-control for">
							<h3>Datos Generales </h3>
							<br>
							<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
								<label class="col-sm-2 col-form-label">Asunto:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" value="{{$garantia_guia_ingreso->asunto}}" disabled="disabled">
								</div>
								<label class="col-sm-2 col-form-label">Ing. Asignado:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for m-b"value="{{$garantia_guia_ingreso->personal_laborales->nombres}}" disabled="disabled" >
								</div>
								<label class="col-sm-2 col-form-label">Motivo:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control for m-b" value="{{$garantia_guia_ingreso->motivo}}" disabled="disabled">
								</div>
								<label class="col-sm-2 col-form-label">Fecha:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" value="{{$garantia_guia_ingreso->fecha}}" disabled="disabled">
								</div>

								<label class="col-sm-2 col-form-label">Cliente:</label>
								<div class="col-sm-10">
									<input class="form-control for m-b" value="{{$garantia_guia_ingreso->clientes_i->nombre}}" disabled="disabled">
								</div>
								<label class="col-sm-2 col-form-label">Contacto:</label>
								<div class="col-sm-10">
									@if(isset($garantia_guia_ingreso->contacto_cliente_id))
									<input type="text" class="form-control for m-b" disabled="disabled" value="{{$garantia_guia_ingreso->contactos->nombre}}" >
									@else
									<select name="contacto" class="form-control for m-b" >
										<option  value=""> Selecciona un Contacto</option>
										@foreach($contactos_cli as $cliente_contac)
										<option value="{{$cliente_contac->id}}">{{$cliente_contac->nombre}}</option>
										@endforeach
									</select>
									@endif
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
									<input disabled="disabled"  type="text" class="form-control for m-b" value="{{$garantia_guia_ingreso->nombre_equipo}}"  >
								</div>
								<label class="col-sm-2 col-form-label">Nr Serie:</label>
								<div class="col-sm-10">
									<input  type="text" class="form-control for m-b" name="numero_serie" value="{{$garantia_guia_ingreso->numero_serie}}"  autocomplete="off"  >
								</div>
								<label class="col-sm-2 col-form-label">Codigo Interno:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control for m-b" name="codigo_interno" value="{{$garantia_guia_ingreso->codigo_interno}}"  autocomplete="off"  >
								</div>
								<label class="col-sm-2 col-form-label">Fecha de Compra:</label>
								<div class="col-sm-10">
									<input type="date" class="form-control for"  disabled="disabled"  value="{{$garantia_guia_ingreso->fecha_compra}}">
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12" align="center" style="margin-top: 10px;">
						<div class="form-control for">
							<center><h3>Informe del Problema</h3></center>
							<br>
							<div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
								<div class="col-sm-4">
									<center><h4>Descripcion del Problema</h4></center>
									<div class="input-group m-b">
										<textarea class="form-control for" rows="5" name="descripcion_problema" maxlength="1230" required style="resize: none;height: 300px;">{{$garantia_guia_ingreso->descripcion_problema}}</textarea>
									</div>
								</div>
								<div class="col-sm-4">
									<center><h4>Revisión y diganostico</h4></center>
									<div class="input-group m-b">
										<textarea class="form-control for" rows="5"  name="revision_diagnostico" maxlength="1230" required style="resize: none;height: 300px;">{{$garantia_guia_ingreso->revision_diagnostico}}</textarea>
									</div>
								</div>
								<div class="col-sm-4">
									<center><h4>Estética</h4></center>
									<div class="input-group m-b">
										<textarea class="form-control for" rows="5" name="estetica" maxlength="1230" required style="resize: none;height: 300px;">{{$garantia_guia_ingreso->estetica}}</textarea>
									</div>
								</div>
								<div class="col-sm-12">
									<button class="ladda-button btn btn-primary" data-style="zoom-in">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</div>

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

<!-- Ladda -->
<script src="{{asset('js/plugins/ladda/spin.min.js')}}"></script>
<script src="{{asset('js/plugins/ladda/ladda.min.js')}}"></script>
<script src="{{asset('js/plugins/ladda/ladda.jquery.min.js')}}"></script>
<!-- Ladda style -->
<link href="{{asset('css/plugins/ladda/ladda-themeless.min.css')}}" rel="stylesheet">

<script>

	$(document).ready(function (){

        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 9000 });


    });

</script>


@stop