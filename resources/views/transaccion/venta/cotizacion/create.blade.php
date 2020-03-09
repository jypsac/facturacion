@extends('layout')

@section('title', 'Cotizacion')
@section('breadcrumb', 'Cotizacion')
@section('breadcrumb2', 'Cotizacion')
@section('href_accion', route('cotizacion.index') )
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
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Agregar </h5>
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
				<form action="{{route('cotizacion.store')}}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	<div class="row">
					 		<div class="col-sm-6">
					 			<div class="row"> 
											<label class="col-sm-2 col-form-label">Cliente:</label>
												<div class="col-sm-10">
											<select class="form-control" name="cliente">
												@foreach($clientes as $cliente)
												<option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
												@endforeach
											<select>
												</div>
								</div><br>
					 			<div class="row"> 
								
									<label class="col-sm-2 col-form-label">Atencion:</label>
										<div class="col-sm-10">
								<input type="text" class="form-control" name="atencion">
										</div>
								</div><br>
					 			<div class="row"> 
								<label class="col-sm-2 col-form-label">Forma de pago:</label>
									<div class="col-sm-10">
										<select class="form-control" name="forma_pago">
											@foreach($forma_pagos as $forma_pago)
											<option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
											@endforeach
										<select>
									</div>
								</div><br>
					 			<div class="row">
					 				<label class="col-sm-2 col-form-label">Vendedor:</label>
											<div class="col-sm-10">
												<select class="form-control" name="personal">
													@foreach($personales as $personal)
													<option value="{{$personal->id}}">{{$personal->nombres}}</option>
													@endforeach
												<select>
											</div>
					 			</div>
					 			
					 		</div>
					 		<div class="col-sm-6">
					 			<div class="row"> 
								
					 			<label class="col-sm-2 col-form-label">Fecha de cotizacion:</label>
		                    		<div class="col-sm-10">
								<input type="datetime" name="fecha" class="form-control" value="{{date("d-m-Y")}}" disabled>
									</div>

					 			</div><br>
					 			<div class="row"> 
						 			<label class="col-sm-2 col-form-label">Validez:</label>
										<div class="col-sm-10">
									<select  class="form-control" name="validez">
										<option value="1 Día">1 Día</option>
										<option value="2 Días">2 Días</option>
										<option value="3 Días">3 Días</option>
										<option value="4 Días">4 Días</option>
										<option value="5 Días">5 Días</option>
									</select>
									</div>
					 			</div><br>

					 			<div class="row"> 
					 					<label class="col-sm-2 col-form-label">Referencia:</label>
										<div class="col-sm-10">
										<input type="text" class="form-control" name="referencia">
										</div>
					 			</div><br>

					 			<div class="row"> 
					 						<label class="col-sm-2 col-form-label">Observacion:</label>
											<div class="col-sm-10">
												<textarea class="form-control" name="observacion" id=""  rows="3" ></textarea>
											</div>
					 			</div>

					 		
					 	</div>



				    	<table 	 cellspacing="0" class="table table-striped ">
							<thead>
							<tr>
								<th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
								<th style="width: 600px">Articulo</th>
								<th style="width: 100px">Cantidad</th>
								{{-- <th style="width: 100px">Precio</th>
								<th style="width: 100px">Total</th> --}}
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type='checkbox' class="case">
								</td>
								<td>
									<input list="browsers2" class="form-control " name="articulo[]" required id='articulo' onkeyup="calcular(this);" autocomplete="off">
										<datalist id="browsers2" >
											@foreach($productos as $producto)
											<option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}}">
											@endforeach
										</datalist>
								</td>
								<td><input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control"    required/></td>
								{{-- <td><input type='text' id='precio' name='precio[]' class="monto0 form-control" onkeyup="multi(0);calcular(this);" required/></td>
								<td><input type='text' id='total0' name='total[]' class="form-control" required/></td> --}}
								<span id="spTotal"></span>
							</tr>
						</tbody>
						</table>

						<button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>&nbsp;
						<button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
						<button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>


					</form>

				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.form-control{border-radius: 10px}
</style>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

	<script>
        var i = 2;
        $(".addmore").on('click', function () {
            var data = `[
			<tr>
				<td>
					<input type='checkbox' class='case'/>
				</td>";
				<td>
					<input list="browsers" class="form-control " name="articulo[]" required id='articulo' autocomplete="off">
						<datalist id="browsers" >
							@foreach($productos as $producto)
							<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
							@endforeach
						</datalist>
				</td>
				<td>
					<input type='text' id='cantidad" + i + "' name='cantidad[]' class="monto${i} form-control" required/>
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
		function calcular(input)
		{
			var id = input.id;
			if (id == "articulo") {
			var cadena=input.value;
			var separador=" ";
			var id=cadena.split(separador,1)
			document.getElementById("precio").value = id; 
			} 
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
@stop