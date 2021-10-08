@extends('layout')
@section('title', 'kardex Entrada')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')

@section('content')
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">

@if (session('repite'))
<div class="alert alert-danger">
	{{ session('repite') }}
</div>
@endif
@if (session('campo'))
<div class="alert alert-success">
	{{ session('campo') }}
</div>
@endif
@if($errors->any())
<div style="padding-top: 20px;">
	<div class="alert alert-danger">
		<a class="alert-link" href="#">
			@foreach ($errors->all() as $error)
			<li style="color: red">{{ $error }}</li>
			@endforeach
		</a>
	</div>
</div>
@endif
{{-- <div class="social-bar">
	<a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1">
		<i class="fa fa-user-o" aria-hidden="true"></i>
		<span> Provedor</span>
	</a>
</div> --}}

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-content">
					<form action="{{ route('kardex-entrada.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
						@csrf
						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Motivos:</label>
							<div class="col-sm-4">
								<select class="form-control" name="motivo" id="motivo" required="required">
									<option value="">Selccionar Motivo</option>
									@foreach($motivos as $motivo)
									<option value="{{$motivo->nombre}}" >{{$motivo->nombre}}</option>
									@endforeach
								</select>
							</div>

							<label class="col-sm-2 col-form-label">G Remision:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="guia_remision" id="guia_remision" required="required" value="0">
							</div>
						</div>

						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Factura:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="factura" id="factura" required="required" value="0">
							</div>

							<label class="col-sm-2 col-form-label"> Provedor:</label>
							<div class="col-sm-4">
								<select class="form-control" name="provedor" required="required">
									@foreach($provedores as $provedor)
									<option value="{{$provedor->empresa}}" >{{$provedor->empresa}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Almacen:</label>
							<div class="col-sm-4">
								@foreach($almacenes as $almacen)
								<input class="form-control" type="text" readonly="" value="{{$almacen->abreviatura}} - {{$almacen->descripcion}}">
								<input class="form-control" name="almacen" type="text" hidden="" value="1">
								@endforeach
							</select>
						</div>

						<label class="col-sm-2 col-form-label"> Informaciones:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" name="informacion" value="Ingreso de productos al almacen">
						</div>
					</div>


					<div class="form-group row ">
						<label class="col-sm-2 col-form-label" >Categoria:</label>
						<div class="col-sm-4">
							<input class="form-control" name="clasificacion" disabled="direccion" value="PRODUCTOS">
						</div>
						<label class="col-sm-2 col-form-label" >Moneda:</label>
						<div class="col-sm-4">
							<select class="form-control" name="moneda" required="">
								<option value="" >Seleccionar Moneda</option>
								@foreach($moneda as $monedas)
								<option value="{{$monedas->nombre}}">{{$monedas->nombre}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 col-form-label">Fecha de compra:</label>
						<div class="col-sm-4">
							<input type="date" name="fecha_compra" id="" required="" class="form-control">
						</div>
					</div>

					<table cellspacing="0" class="table table-striped " width="100%">
						<thead>
							<tr>
								<th style="width: 10px"></th>
								<th style="width: 600px">Producto  <a href="{{route('productos.create')}}" class="btn btn-warning" target="blanck" style="padding-top: 0px;padding-bottom: 0px; padding-left: 4px;padding-right: 4px;" ><i class="fa fa-plus-square" aria-hidden="true" ></a></th>
									<th style="width: 100px">Cantidad</th>
									<th style="width: 100px">Precio</th>
									<th style="width: 100px">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<button type="button" class='delete borrar e btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
									</td>
									<td>
										<select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo1" onchange="select_opt(1)">
											<option></option>
											@foreach($productos as $producto)
											<option value="{{$producto->id}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
											@endforeach
										</select>
										<input type="hidden" value="" id="registro_opt1" name="registro_opt[]" class="registro_opt">
									</td>

									<td><input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control"  onkeyup="multi(0);"  required/></td>
									<td><input type='text' id='precio' name='precio[]' class="monto0 form-control" onkeyup="multi(0);" required/></td>
									<td><input type='text' id='total0' name='total[]' class="form-control" required/></td>
									<span id="spTotal"></span>
								</tr>
							</tbody>
						</table>

						<button type="button" class='addmore btn btn-success' disabled="" > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
						<button class="btn btn-primary float-right" type="submit" id="boton"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>
					</form>
					<tr>
						<style type="text/css">
						.form-control{border-radius: 5px;}
					</style>
				</tr>
			</div>
		</div>
	</div>
</div>
</div>
<style type="text/css">
.select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 12px;text-align: left;}
.select2-container--default .select2-selection--single { border: none;}
.select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 0.9rem;padding-left: 0px;color: inherit;}
span.select2.select2-container.select2-container--default{
	width: 100% !important;
	background-color: #FFFFFF;
	background-image: none;
	border-radius: 1px;
	display: block;
	padding: 3px 12px;
	border: 1px solid #e5e6e7;
}
</style>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script type="text/javascript">
	$(".select2_demo_3").select2({
		placeholder: "Seleccionar Producto",
	});
</script>
{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
	function valida(f) {
		var boton=document.getElementById("boton");
		var completo = true;
		var incompleto = false;
		if( f.elements[0].value == "" )
			{ alert(incompleto); }
		else{boton.type = 'button';}
	}
</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<!-- Typehead -->
<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>

<script>
	var i = 2;
	$(".addmore").on('click', function () {
		var data = `[
		<tr>
		<td>
		<button type="button" class='delete e borrar btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
		</td>
		<td>
		<select class="select2_demo_3 asf" name="articulo[]" required="" id="articulo${i}" onchange="select_opt(${i})" >
		<option></option>
		@foreach($productos as $producto)
		<option value="{{$producto->id}}"> {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}</option>
		@endforeach
		</select>
		<input type="hidden"  name='registro_opt[]' id="registro_opt${i}" readonly="readonly" value="" required  class="registro_opt" />
		</td>
		<td>
		<input type='text' id='cantidad" + i + "' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i});" required/>
		</td>
		<td>
		<input type='text' id='precio" + i + "' name='precio[]' class="monto${i} form-control"  onkeyup="multi(${i});" required/>
		</td>
		<td>
		<input type='text' id='total${i}' name='total[]' class="form-control" required/>
		</td>
		</tr>`;
		$('table').append(data);
		i++;
		var input_ds = [];
		var number_tot = document.getElementsByName('articulo[]').length;
		for( j = 0; j < number_tot; j++){
			input_ds[j]  = document.getElementsByName('articulo[]')[j].value;
			$('option[value="'+input_ds[j]+'"]').prop("disabled", true);
		};
		$(".addmore").prop("disabled", true);
		$(".borrar").prop("disabled", false);

		$(".select2_demo_3").select2({
			placeholder: "Seleccionar Producto",
		});
	});
</script>

<script>
	function multi(a){
		console.log(a);
		var total = 1;
			var change= false; //
			$(`.monto${a}`).each(function(){
				if (!isNaN(parseFloat($(this).val()))) {
					change= true;
					total *= parseFloat($(this).val());
				}
			});
			total = (change)? total:0;
			document.getElementById(`total${a}`).value = total;
		}
	</script>
	<script>
		$(document).on('click', '.borrar', function (event) {
			event.preventDefault();
			var e = document.getElementsByClassName("e").length;
        // alert(e);
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="registro_opt"]').val();
        console.log(input_text_opt);
		$('option[value="'+input_text_opt+'"]').prop("disabled", false);
		if (e>1) {
        	fila.closest('tr').remove();
        	$(".borrar").prop("disabled", true);
        	$(".addmore").prop("disabled", false);
        }else{
        	$(".borrar").prop("disabled", false);
			$(".addmore").prop("disabled", false);
        }
    });
</script>
<script >
	function select_opt(b){
		var cant_opt = document.getElementById(`articulo${b}`).length;
		var count_input = document.getElementsByClassName('registro_opt').length;

		var option = document.getElementById(`articulo${b}`);

		var valor_select = option.value;
		console.log(valor_select);
		if(valor_select == ""){
			document.getElementById(`registro_opt${b}`).value = valor_select;
			$('option[value="'+valor_select+'"]').prop( "disabled", true);
		}else{
			var ant_val = document.getElementById(`registro_opt${b}`).value;
			$('option[value="'+ant_val+'"]').prop( "disabled", false);
			$('option[value="'+valor_select+'"]').prop( "disabled", true);
			document.getElementById(`registro_opt${b}`).value = valor_select;
			if(cant_opt-1 == count_input ){
				$(".addmore").prop("disabled", true);
			}
			else{
				$(".addmore").prop("disabled", false);
			}
		}
		$(".select2_demo_3").select2({
			placeholder: "Seleccionar Producto",
		});

	}
</script>
@endsection
