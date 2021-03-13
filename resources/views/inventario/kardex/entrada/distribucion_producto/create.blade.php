@extends('layout')
@section('title', 'kardex Distribucion')
@section('href_accion', route('kardex-entrada-Distribucion.index'))
@section('value_accion', 'Atras')
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
					<form action="{{ route('kardex-entrada-Distribucion.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
						@csrf
						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Motivo:</label>
							<div class="col-sm-4">
								<input type="text" value="Distribucion a Sucursales" readonly="" class="form-control" name="motivo" required="required">
							</div>
							<label class="col-sm-2 col-form-label" >Almacen:</label>
							<div class="col-sm-4">
								<select class="form-control" name="almacen">
									@foreach($almacenes as $almacen)
									<option value="{{$almacen->id}}">{{$almacen->abreviatura}} / {{$almacen->descripcion}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Categoria:</label>
							<div class="col-sm-4">
								<input class="form-control" name="clasificacion" disabled="direccion" value="PRODUCTOS">
							</div>
						</div>
						<table cellspacing="0" class="table table-striped " width="100%">
							<thead>
								<tr>
									<th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()"  /></th>
									<th style="width: auto">Producto</th>
									<th style="width: auto">Stock</th>
									<th style="width: 100px">Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type='checkbox' class="case"></td>
									<td>
										<input list="browsers2" class="form-control " name="articulo[]" required id='articulo' onclick="Clear(this);" autocomplete="off">
										<datalist id="browsers2" >
											@foreach($productos as $producto)
											<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
												@endforeach
											</datalist>
										</td>
										<td>
											<input type='text' id='stock0' name='stock[]' class="stock0 form-control" required/>
										</td>
										<td><input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control"  onkeyup="multi(0);"  required/>
										</td>
									</tr>
								</tbody>
							</table>
							<button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
							<button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
							<button class="btn btn-primary float-right" type="submit" id="boton"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<style type="text/css">
		.form-control{border-radius: 5px;}
	</style>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ asset('js/popper.min.js') }}"></script>
	<script src="{{ asset('js/bootstrap.js') }}"></script>
	<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
	<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

	<script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

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
			<input type='checkbox' class='case'/>
			</td>";
			<td>
			<input list="browsers" class="form-control " name="articulo[]" required id='articulo' onclick="Clear(this);" autocomplete="off">
			<datalist id="browsers" >
			@foreach($productos as $producto)
			<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
			@endforeach
			</datalist>
			</td>
			<td><input type='text' id='stock${i}' name='stock[]' class="stock${i} form-control"  required/></td>
			<td>
			<input type='text' id='cantidad" + i + "' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i});" required/>
			</td>
			</tr>`;
			$('table').append(data);
			i++;
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
		$(".delete").on('click', function () {
			$('.case:checkbox:checked').parents("tr").remove();

		});
	</script>

	<script>
		function select_all() {
			$('input[class=case]:checkbox').each(function () {
				if ($('input[class=check_all]:checkbox:checked').length == 0) {
					$(this).prop("checked", false);
				} else {
					$(this).prop("checked", true);
				}
			});
		}
	</script>

	<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

	<script>
		$(document).ready(function () {
			$('.i-checks').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});
		});
	</script>

	<script src="{{ asset('js/plugins/typehead/bootstrap3-typeahead.min.js') }}"></script>

	<script>
		$(document).ready(function(){

			$('.typeahead_1').typeahead({
				source: ["item 1","item 2","item 3"]
			});
		});
		function Clear(elem)
		{
			elem.value='';
		}

		$('#articulo').change(function(e){
			e.preventDefault();

			var articulo = $('[id="articulo"]').val();

			// var data={articulo:articulo,_token:token};
				$.ajax({
					type: "post",
					url: "{{ route('stock_ajax_distribucion') }}",
					data: {
						'_token': $('input[name=_token]').val(),
						'articulo': articulo
						},
					success: function (msg) {
						// console.log(msg);
						$('#stock0').val(msg);
					}
				});
			});


		function ajax (a){
			var articulo2 = $(`[id='articulo${a}']`).val();
			$.ajax({
				type: "post",
				url: "{{ route('stock_ajax_distribucion') }}",
				data: {
					'_token': $('input[name=_token]').val(),
					'articulo': articulo2
					},
				success: function (msg) {
					// console.log(msg);
					$(`#stock${a}`).val(msg);
				}
			});
		}
	</script>

	@endsection
