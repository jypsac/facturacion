@extends('layout')
@section('title', 'kardex_entrada-Distribucion')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')

@section('content')

@if (session('repite'))
<div class="alert alert-success">
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
<div class="social-bar">
	<a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1">
		<i class="fa fa-user-o" aria-hidden="true"></i>
		<span> Provedor</span>
	</a>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Nueva Entrada</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="#" class="dropdown-item">Config option 1</a>
							</li>
							<li><a href="#" class="dropdown-item">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<form action="{{ route('kardex-entrada.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
						@csrf
						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Motivos:</label>
							<div class="col-sm-4">
								<select class="form-control" name="motivo" required="required">
									@foreach($motivos as $motivo)
									<option value="{{$motivo->id}}" >{{$motivo->nombre}}</option>
									@endforeach
								</select>
							</div>

							<label class="col-sm-2 col-form-label">G Remision:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="guia_remision" required="required" value="0">
							</div>
						</div>

						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Factura:</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="factura" required="required" value="0">
							</div>

							<label class="col-sm-2 col-form-label"> Provedor:</label>
							<div class="col-sm-4">
								<select class="form-control" name="provedor" required="required">
									@foreach($provedores as $provedor)
									<option value="{{$provedor->id}}" >{{$provedor->empresa}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >Almacen:</label>
							<div class="col-sm-4">
								@if($usuario->name=='Colaborador')
								<input name="almacen" value="{{$usuario->almacen->id}}" hidden="hidden">
								<input  class="form-control" disabled="" value="{{$usuario->almacen->abreviatura}} - {{$usuario->almacen->descripcion}}">
								@elseif($usuario->name=='Administrador')
								<select class="form-control" name="almacen">
									@foreach($almacenes as $almacen)
									<option value="{{$almacen->id}}">{{$almacen->abreviatura}} -> {{$almacen->descripcion}}</option>
									@endforeach
								</select>
								@endif
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
									{{-- <select class="form-control" name="clasificacion">
										@foreach($categorias as $categorias)
										<option value="{{$categorias->id}}">{{$categorias->descripcion}}</option>
										@endforeach
									</select> --}}
								</div>

								<label class="col-sm-2 col-form-label" >Moneda:</label>
								<div class="col-sm-4">
									<select class="form-control" name="moneda" required="">
										<option value="">Seleccione una moneda</option>
										@foreach($moneda as $monedas)
										<option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
										@endforeach
									</select>
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
												<input list="browsers2" class="form-control " name="articulo[]" required id='articulo' onclick="Clear(this);" autocomplete="off">
												<datalist id="browsers2" >
													@foreach($productos as $producto)
													<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
														@endforeach
													</datalist>
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
					<input list="browsers" class="form-control " name="articulo[]" required id='articulo' onclick="Clear(this);" autocomplete="off">
					<datalist id="browsers" >
					@foreach($productos as $producto)
					<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
					@endforeach
					</datalist>
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
	</script>

	@endsection
