@extends('layout')
@section('title', 'Inventario Inicial')
@section('content')


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
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-content">

					<div class="form-group row ">
						<label class="col-sm-1 col-form-label" >Motivos:</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" disabled="" value="Inventario Inicial">
						</div>

						<label class="col-sm-1 col-form-label" >Almacen:</label>
						<div class="col-sm-3">
							<input type="text" disabled="" value="Almacen Principal" class="form-control">
						</select>
					</div>

					<label class="col-sm-1 col-form-label" >Moneda:</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" disabled="" value="{{$moneda_principal->nombre}} ({{$moneda_principal->simbolo}})">
					</div>
				</div>
				<form action="{{ route('kardex-entrada.i_inicial') }}"  enctype="multipart/form-data" method="post">
					@csrf
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
							<tbody id="tbody">
								<tr>
									<td> <button type="button" class='borrar btn btn-danger' disabled="" > <i class="fa fa-trash" aria-hidden="true"></i> </button></td>

									<td>
										<select class="select2_demo_3 select_change" name="articulo[]" required="" id="select_prod1"  onchange="seleccion_options(1)">
											<option></option>
											@foreach($productos as $producto)
											<option value="{{$producto->id}}">{{$producto->nombre}}- {{$producto->codigo_original}}</option>
											@endforeach
										</select>
										<input type="text" style="display:none"  class="celda"  name="articulo[]" id="input_prod1" >
									</td>
									<td><input type='text'  name='cantidad[]' class="monto0 form-control"  onkeyup="multi(0);"  required/></td>
									<td><input type='text' name='precio[]' class="monto0 form-control" onkeyup="multi(0);" required/></td>
									<td><input disabled="disabled" type='text' id='total0' name='total[]' class="form-control" required/></td>
									<span id="spTotal"></span>
								</tr>

							</tbody>
						</table>
						<button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
						<button class="btn btn-primary float-right" type="submit" id="boton"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
.form-control{border-radius: 5px;}
.select2-container--default .select2-selection--single .select2-selection__rendered {
	font-size: 12px;
}
.select2-container--default .select2-selection--single {
	border: none;
}
span.select2.select2-container.select2-container--default{
	width: 100%!important;
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
<!-- Typehead -->
<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
	$(".select2_demo_3").select2({
		placeholder: "Seleccionar Producto"
	});
</script>
<script>
	var i = 2;
	$(".addmore").on('click', function () {
		var data = `
		<tr>
		<td>
		<button type="button" class='borrar btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i>
		</td>;
		<td>
		<select class="select2_demo_3 select_change" name="articulo[]" id="select_prod${i}"    required="" onchange="seleccion_options(${i})"  >
		<option></option>
		@foreach($productos as $producto)
		<option value="{{$producto->id}}">{{$producto->nombre}}- {{$producto->codigo_original}}</option>
		@endforeach
		</select>
		<input type="text" style="display:none"  class="celda"  name="articulo[]" id="input_prod${i}">
		</td>
		<td>
		<input type='text' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i});" required/>
		</td>
		<td>
		<input type='text' name='precio[]' class="monto${i} form-control"  onkeyup="multi(${i});"  required/>
		</td>
		<td>
		<input type='text' id='total${i}' name='total[]' class="form-control" disabled="disabled" required/>
		</td>
		</tr> `;
		$('#tbody').append(data);
		i++;
		$(".select2_demo_3").select2({
			placeholder: "Seleccionar Producto",
		});

		var input_ds = [];
		var number_tot = document.getElementsByName('articulo[]').length;
		for( j = 0; j < number_tot; j++){
			input_ds[j]  = document.getElementsByName('articulo[]')[j].value;
			$('option[value="'+input_ds[j]+'"]').prop("disabled", true);
		};
		$(".addmore").prop("disabled", true);
		$(".borrar").prop("disabled", false);
	});
</script>

	<script>
		function seleccion_options(b){
			var cant_opt = document.getElementById(`select_prod${b}`).length;
			var count_input = document.getElementsByClassName('celda').length;

			var option = document.getElementById(`select_prod${b}`);
			var valor_select = option.value;
			if(valor_select == ""){
				document.getElementById(`input_prod${b}`).value = valor_select;
				$('option[value="'+valor_select+'"]').prop( "disabled", true);
			}else{
				var ant_val = document.getElementById(`input_prod${b}`).value;
				$('option[value="'+ant_val+'"]').prop( "disabled", false);
				$('option[value="'+valor_select+'"]').prop( "disabled", true);
				document.getElementById(`input_prod${b}`).value = valor_select;
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
			var fila = $(this).parents("tr");
			var input_text_opt = fila.find('input[class="celda"]').val();
			$('option[value="'+input_text_opt+'"]').prop("disabled", false);
			$(".select2_demo_3").select2({
				placeholder: "Seleccionar Producto",
			});
			$(this).closest('tr').remove();

			var count_input = document.getElementsByClassName('celda').length;
			console.log(count_input);
			if(count_input == 1){
				$(".borrar").prop("disabled", true);
				$(".addmore").prop("disabled", false);
			}else{
				$(".borrar").prop("disabled", false);
				$(".addmore").prop("disabled", false);


			}
		});
	</script>
	@endsection
