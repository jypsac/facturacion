@extends('layout')
@section('title', 'Inventario Inicial')
@section('content')
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">

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
					<form action="{{ route('kardex-entrada.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
						@csrf
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
							<input type="text" class="form-control" disabled="" value="Soles (PEN)">
						</div>
					</div>
					<table cellspacing="0" class="table table-striped " width="100%">
						<thead>
							<tr>
								<th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()"  /></th>
								<th style="width: 600px">Producto  <a href="{{route('productos.create')}}" class="btn btn-warning" target="blanck" style="padding-top: 0px;padding-bottom: 0px; padding-left: 4px;padding-right: 4px;" ><i class="fa fa-plus-square" aria-hidden="true" ></a></th>
									<th style="width: 100px">Cantidad</th>
									<th style="width: 100px">Precio</th>
									<th style="width: 100px">Total</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input type='checkbox' class="case">
									</td>
									<td>
										<select class="select2_demo_3 form-control" name="articulo[]" >
											<option></option>
											@foreach($productos as $producto)
											<option value="{{$producto->id}}">{{$producto->nombre}}- {{$producto->codigo_original}}</option>
											@endforeach
										</select>
									</td>
									<td><input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control"  onkeyup="multi(0);"  required/></td>
									<td><input type='text' id='precio' name='precio[]' class="monto0 form-control" onkeyup="multi(0);" required/></td>
									<td><input type='text' id='total0' name='total[]' class="form-control" required/></td>
									<span id="spTotal"></span>
								</tr>

							</tbody>
						</table>


						<button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
						<button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
						<button class="btn btn-primary float-right" type="submit" id="boton"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>

					</form>

					<tr>
						<style type="text/css">
						.form-control{
							border-radius: 5px;
						}
					</style>
				</tr>

			</div>
		</div>
	</div>
</div>
</div>

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
		<select class="select2_demo_1 form-control">
		<option value="1">Option 1</option>
		<option value="2">Option 2</option>
		<option value="3">Option 3</option>
		<option value="4">Option 4</option>
		<option value="5">Option 5</option>
		</select>
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
		</tr> `;
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

	<!-- Select2 -->
	<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
	<script>
		$(".select2_demo_1").select2();
		$(".select2_demo_2").select2();
		$(".select2_demo_3").select2({
			placeholder: "Select a state",
			allowClear: true
		});
	</script>
	@endsection
