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
											<select class="form-control" name="cliente" required="required">
												@foreach($clientes as $cliente)
												<option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
												@endforeach
											<select>
												</div>
								</div><br>
					 			<div class="row"> 
								
									<label class="col-sm-2 col-form-label">Atencion:</label>
										<div class="col-sm-10">
								<input type="text" class="form-control" name="atencion" required="required">
										</div>
								</div><br>
					 			<div class="row"> 
								<label class="col-sm-2 col-form-label">Forma de pago:</label>
									<div class="col-sm-10">
										<select class="form-control" name="forma_pago" required="required">
											@foreach($forma_pagos as $forma_pago)
											<option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
											@endforeach
										<select>
									</div>
								</div><br>
					 			<div class="row">
					 				<label class="col-sm-2 col-form-label">Vendedor:</label>
											<div class="col-sm-10">
												<select class="form-control" name="personal" required="required">
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
									<select  class="form-control" name="validez" required="required">
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
										<input type="text" class="form-control" name="referencia" required="required">
										</div>
					 			</div><br>

					 			<div class="row"> 
					 						<label class="col-sm-2 col-form-label">Observacion:</label>
											<div class="col-sm-10">
												<textarea class="form-control" name="observacion" id="" required="required"  rows="3" ></textarea>
											</div>
					 			</div>

					 	</div>


				    	<table 	 cellspacing="0" class="table table-striped ">
							<thead>
							<tr>
								<th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
								<th style="width: 600px">Articulo</th>
								<th style="width: 100px">Stock</th>
								<th style="width: 100px">Cantidad</th>
								<th style="width: 100px">Precio</th>
								<th style="width: 100px">Descuento</th>
								<th style="width: 100px">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type='checkbox' class="case">
								</td>
								<td>
									<input list="browsers2" class="form-control " name="articulo[]" class="monto0 form-control" required id='articulo' onkeyup="calcular(this,0);"  autocomplete="off">
										<datalist id="browsers2" >
											@foreach($productos as $index => $producto)
											<option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$array_cantidad[$index]}} {{$producto->descuento1}} {{$array[$index]}}">
											@endforeach
										</datalist>
										
								</td>
								<td><input type='text' id='stock0' disabled="disabled" name='stock[]' class="form-control" required  autocomplete="off"/></td>
								<td><input type='number' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" /></td>
								<td><input type='text' id='precio0' name='precio[]' disabled="disabled" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" /></td>
								<td><input type='text' id='descuento0' name='descuento[]' class="form-control" required  autocomplete="off"/></td>
								<td><input type='text' id='total0' name='total' class="total form-control " required  autocomplete="off" /></td>
								<span id="spTotal"></span>
							</tr>

						</tbody><br>
						<tbody>
						<tr style="background-color: #f5f5f500;" align="center">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Subtotal :</td>
						<td><input id='sub_total'  disabled="disabled" class="form-control" required /></td>
						</tr>
						<tr style="background-color: #f5f5f500;" align="center">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>IGV :</td>
						<td><input id='igv'  disabled="disabled" class="form-control" required /></td>
						</tr>
						<tr  align="center">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Total :</td>
						<td><input id='total_final'  disabled="disabled" class="form-control" required /></td>
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
					<input list="browsers" class="form-control " name="articulo[]" required id='articulo${i}' onkeyup="calcular(this,${i});" autocomplete="off">
						<datalist id="browsers" >
							@foreach($productos as $index => $producto)
								<option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$array_cantidad[$index]}} {{$producto->descuento1}} {{$array[$index]}}" >
							@endforeach
						</datalist>
				</td>

				<td>
					<input type='text' id='stock${i}' name='stock[]' disabled="disabled" class="form-control" required  autocomplete="off"/>
				</td>
				<td>
					<input type='text' id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
				</td>
				<td>
					<input type='text' id='precio${i}' name='precio[]' disabled="disabled" class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
				</td>
				<td>
					<input type='text' id='descuento${i}' name='descuento[]' class="form-control" required onkeyup="multi(${i})"  autocomplete="off"/>
				</td>
				<td>
					<input type='text' id='total${i}' name='total' class="total form-control "  required  autocomplete="off"/>
				</td>
				
				
			</tr>`;
            $('table').append(data);
            i++;
        });
	</script>

	<script>
	function multi(a){
		var total = 1;
		var totales=0;
		var change= false; //
		$(`.monto${a}`).each(function(){
			if (!isNaN(parseFloat($(this).val()))) {
				change= true;
				
				total *= parseFloat($(this).val());
			}
		});
		total = (change)? total:0;
		var descuento = document.querySelector(`#descuento${a}`).value;
		var precio = document.querySelector(`#precio${a}`).value;
		var final= total-(total*descuento/100);

		document.getElementById(`total${a}`).value = final;

		var totalInp = $('[name="total"]'); 
		var total_t = 0;

		totalInp.each(function(){
			total_t += parseFloat($(this).val());
		});
		$('#sub_total').val(total_t);

		var igv_valor={{$igv->renta}};
		var subtotal = document.querySelector(`#sub_total`).value;
		var igv=subtotal*igv_valor/100;
		var end=igv+parseInt(subtotal);

		console.log(typeof igv);
		console.log(typeof end);
		document.getElementById("igv").value = igv;
		document.getElementById("total_final").value = end;
		

	}
	</script>

	<script>
		function reverseString(str) {
			return str.split("").reverse().join("");;
		}

		function calcular(input,a)
		{
			var id = input.id;
			var caracteres = input.value;
			var caracteres_reverse=reverseString(caracteres);
			var cadena=input.value;
			var separador=" ";
			var seprador_total= " / ";
			var id=cadena.split(separador,1);
			//revirtiendo la cadena
				var reverse=reverseString(caracteres);//devuelve toda la cadena articulo al reves
			//para precio
				var precio_v_r=reverse.split(separador,1); //devuelve el precio en objeto al revez
				var precio_r=precio_v_r[0];//obtiene el precio del objeto [0] al revez
				var precio_v =reverseString(precio_v_r[0]);//convierte el precio al revez a la normalidad

				var caracteres_space=caracteres_reverse.replace(precio_r,"");//obtiene la cadena articulo sin precio,pero con un espacio en blanco
				var reverse2=caracteres_space.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
			//para descuento
				var descuento_v_r=reverse2.split(separador,1);////obtiene el descuento del objeto [0] al revez
				var descuento_r=descuento_v_r[0];//obtiene el descuento del objeto [0] al revez
				var descuento_v =reverseString(descuento_v_r[0]);//convierte el descuento al revez a la normalidad

				var caracteres_space_2=reverse2.replace(descuento_r,"");//obtiene la cadena articulo sin precio,descuento,con un espacio en blanco
				var reverse3=caracteres_space_2.slice(1);//elimina el espacion en blanco de la cadena articulo sin precio
			//para stock
				var stock_v_r=reverse3.split(separador,1);
				var stock_r=stock_v_r[0];
				var stock_v =reverseString(stock_v_r[0]);

			document.getElementById(`precio${a}`).value = precio_v;
			document.getElementById(`stock${a}`).value = stock_v; 
			document.getElementById(`descuento${a}`).value = descuento_v; 

		}
	</script>

    <script>
        $(".delete").on('click', function () {
            $('.case:checkbox:checked').parents("tr").remove();
        });
		//meter en funcion la suma
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
	<style type="text/css">
		.a{color: red}
	</style>
	
@stop