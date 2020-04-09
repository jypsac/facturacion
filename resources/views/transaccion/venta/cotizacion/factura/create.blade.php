@extends('layout')

@section('title', 'Cotizacion - Factura')
@section('breadcrumb', 'Cotizacion - Factura')
@section('breadcrumb2', 'Cotizacion - Factura')
@section('href_accion', route('cotizacion.index') )
@section('value_accion', 'Atras')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

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
			<div class="alert alert-danger">
                <a class="alert-link" href="#">
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</a>
            </div>
@endif


	<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target=".bd-example-modal-lg1"><i class="fa fa-user-o" aria-hidden="true"></i><span> cliente</span></a>
    <a href="{{route('cotizacion.create_boleta')}}" class="icon icon-twitter" ><i style="padding-left: 5px" class="fa fa-male" aria-hidden="true"></i><span> Factura</span></a>

	</div>
	<!-- Modal CLiente -->

							<div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
								  <div class="modal-content" style="width: 100%">
						<!-- Consulta API -->
							<form class="wizard-big" style="margin:20px 20px 20px 20px">
                        {{ csrf_field() }}
						<div class="form-group row ">
								<label class="col-sm-2 col-form-label" >Introducir Ruc (Inestable):</label>
							        <div class="col-sm-10">
							            <input type="text" class="form-control" class="ruc" id="ruc" name="ruc">
							            <button class="btn btn-primary" id="botoncito" class="botoncito"><i class="fa fa-search"></i> Buscar</button>
							        </div>
						</div>
						</form>

                        <script>
                        $(function(){
                            $('#botoncito').on('click', function(){
                                var ruc = $('#ruc').val();
                                var url = "{{ url('provedorruc') }}";
                                $('.ajaxgif').removeClass('hide');
                                $.ajax({
                                type:'GET',
                                url:url,
                                data:'ruc='+ruc,
                                success: function(datos_dni){
                                    $('.ajaxgif').addClass('hide');
                                    var datos = eval(datos_dni);
                                        var nada ='nada';
                                        if(datos[0]==nada){
                                            alert('DNI o RUC no válido o no registrado');
                                        }else{
                                            $('#numero_ruc').val(datos[0]);
                                            $('#razon_social').val(datos[1]);
                                            $('#fecha_actividad').val(datos[2]);
                                            $('#condicion').val(datos[3]);
                                            $('#tipo').val(datos[4]);
                                            $('#estado').val(datos[5]);
                                            $('#fecha_inscripcion').val(datos[6]);
                                            $('#domicilio').val(datos[7]);
                                            $('#emision').val(datos[8]);
                                        }
                                }
                            });
                            return false;
                            });
                        });
                        </script>

						<!-- Fin Consulta API -->

									<form action="{{ route('agregado_rapido.cliente_cotizado') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post" style="margin:0 20px 20px 20px">

										@csrf
										<h1 ><i class="fa fa-user-o" aria-hidden="true"></i></h1>
									 	<div class="form-group row ">
									 		<label class="col-sm-2 col-form-label" >Tipo Documento:</label>
							                    <div class="col-sm-4">
							                     	<select class="form-control m-b" name="documento_identificacion" >
															<option value="Ruc">Ruc</option>
															<option value="dni">DNI</option>
															<option value="pasaporte">Pasaporte</option>
														</select>
							                    </div>

							                    <label class="col-sm-2 col-form-label">Numero de Documento:</label>
												<div class="col-sm-4">

													<input list="browserdoc" class="form-control m-b" name="numero_documento" id="numero_ruc" required value="{{ old('numero_documento')}}" autocomplete="off">
														<datalist id="browserdoc" >
															@foreach($clientes as $cliente)
																<option id="a">{{$cliente->numero_documento}} - existente</option>
															@endforeach
												 		</datalist>
							                    </div>
										</div> 



						                <div class="form-group row" >
									 		<label class="col-sm-2 col-form-label" >Cliente:</label>
							                    <div class="col-sm-4">



												<input list="browsersc" class="form-control m-b" name="nombre" id="razon_social" required value="{{ old('nombre')}}" autocomplete="off">
														<datalist id="browsersc" >
															@foreach($clientes as $cliente)
																<option id="a">{{$cliente->nombre}} - existente</option>
															@endforeach
												 		</datalist>

							                    </div>

							                    <label class="col-sm-2 col-form-label">Direccion:</label>
												<div class="col-sm-4">
														<input type="text" class="form-control" name="direccion" id="domicilio" class="form-control" required value="{{ old('direccion')}}" autocomplete="off">
							                    </div>

						                </div>

						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label" >correo:</label>
							                    <div class="col-sm-4">
							                    	<input type="email" class="form-control" name="email" class="form-control" required value="{{ old('email')}}" autocomplete="off">
							                    	 </div>


						                </div>


										<input type="submit"class="btn btn-primary" value="Grabar">

									</form>

								  </div>
								</div>
							</div>
	<!-- Fin Modal Clieb¿nte -->

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
				<form action="{{route('cotizacion.store_factura')}}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	<div class="row">
					 		<div class="col-sm-6">
					 			<div class="row"> 
									<label class="col-sm-2 col-form-label">Cliente:</label>
									<div class="col-sm-10">
						<input list="browsersc1" class="form-control m-b" name="cliente" required value="{{ old('nombre')}}" autocomplete="off">
										<datalist id="browsersc1" >
											@foreach($clientes as $cliente)
												<option id="{{$cliente->id}}">{{$cliente->numero_documento}} - {{$cliente->nombre}}</option>
											@endforeach
										 </datalist>
									</div>
									<input type="hidden" value="0" name="print" id="prints">
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
								<label class="col-sm-2 col-form-label">Moneda:</label>
									<div class="col-sm-10">
										<select class="form-control" name="moneda" required="required">
											@foreach($moneda as $monedas)
											<option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
											@endforeach
										<select>
									</div>
								</div><br>
					 			<div class="row">
					 				<label class="col-sm-2 col-form-label">Vendedor:</label>
											<div class="col-sm-10">
											<input type="text" class="form-control" name="personal" disabled required="required" value="{{auth()->user()->name}}">
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
					 			</div><br><br>

					 			<div class="row"> 
					 					<label class="col-sm-2 col-form-label">Garantia:</label>
										<div class="col-sm-10">
										<!-- <input type="text" class="form-control" name="referencia" > -->
										<select class="form-control" name="garantia">
											<option value="6 meses">6 Meses</option>
											<option value="1 año">1 Año</option>
											<option value="2 años">2 Años</option>
											<option value="3 años">3 Años</option>
										</select>
										</div>
					 			</div><br>

					 			<div class="row"> 
					 						<label class="col-sm-2 col-form-label">Comisionista:</label>
											<div class="col-sm-10">
												<!-- <input type="text" name="comisionista" class="form-control"> -->
												<input list="browsersc2" class="form-control m-b" name="comisionista" required value="{{ old('nombre')}}" autocomplete="off">
										<datalist id="browsersc2" >
											@foreach($p_venta as $p_ventas)
												<option id="{{$p_ventas->id}}">{{$p_ventas->personal->personal_l->numero_documento}} - {{$p_ventas->personal->personal_l->nombres}}</option>
											@endforeach
										 </datalist>
											</div>
					 			</div>

					 	</div>
					 	<div class="col-sm-12" style="padding-top: 15px">
					 		<div class="row">
					 			<label class="col-sm-1 col-form-label">Observacion:</label>
											<div class="col-sm-11">
												<textarea class="form-control" name="observacion" id="observacion"  rows="1"  ></textarea>
											</div>
							</div>
					 	</div>


				    	<table 	 cellspacing="0" class="table table-striped ">
							<thead>
							<tr>
								<th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
								<th style="width: 600px;font-size: 13px">Articulo</th>
								<th style="width: 100px;font-size: 13px">Stock</th>
								<th style="width: 100px;font-size: 13px">Cantidad</th>
								<th style="width: 100px;font-size: 13px">Precio</th>
								<th style="width: 100px;font-size: 13px">Descuento</th>
								<th style="width: 100px;font-size: 13px">PU. Dsto.</th>
								<th style="width: 100px;font-size: 13px">Comision</th>
								<th style="width: 100px;font-size: 13px">PU. Comision.</th>
								<th style="width: 100px;font-size: 13px">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<input type='checkbox' class="case">
								</td>
								<td>
									<input list="browsers2" class="form-control " name="articulo[]" class="monto0 form-control" required id='articulo' onkeyup="calcular(this,0);multi(0)"  autocomplete="off">
										<datalist id="browsers2" >
											@foreach($productos as $index => $producto)
											<option value="{{$producto->id}} | {{$producto->codigo_producto}} | {{$producto->codigo_original}} | {{$producto->nombre}} / &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp {{$array_cantidad[$index]}} {{$producto->descuento1}} {{$array[$index]}}">
											@endforeach
										</datalist>
										
								</td>
								<td><input type='text' id='stock0' disabled="disabled" name='stock[]' class="form-control" required  autocomplete="off"/></td>
								<td><input type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" /></td>
								<td><input type='text' id='precio0' name='precio[]' disabled="disabled" class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" /></td>
								<td><input type='checkbox' id='check0' name='check[]'  class="form-control"  onclick="multi(0)"  autocomplete="off"/>
									<input type='hidden' id='check_descuento0' name='check_descuento[]'  class="form-control"  required >
									<input type='text' id='descuento0' name='descuento[]' disabled="disabled" class="form-control" required  autocomplete="off"/></td>
								<td><input type='text' id='precio_unitario_descuento0' name='precio_unitario_descuento[]' disabled="disabled" class="precio_unitario_descuento0 form-control"  required  autocomplete="off" /></td>
								<td><input type='text'   disabled="disabled" class="form-control"  required  autocomplete="off" /></td>
								<td><input type='text'   disabled="disabled" class="form-control"  required  autocomplete="off" /></td>
								<td><input type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" /></td>
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

						<a onclick="print()"><button class="btn btn-warning float-right" ><i class="fa fa-cloud" aria-hidden="true">Imprimir</i></button></a>

						<button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>&nbsp;
						

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
					<input list="browsers" class="form-control " name="articulo[]" required id='articulo${i}' onkeyup="calcular(this,${i});multi(${i})" autocomplete="off">
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
					<input type='checkbox' id='check${i}' name='check[]'  class="form-control"  onclick="multi(${i})"  autocomplete="off"/>
					<input type='hidden' id='check_descuento${i}' name='check_descuento[]'  class="form-control"  required >
					<input type='text' id='descuento${i}' name='descuento[]' disabled="disabled" class="form-control" required onkeyup="multi(${i})"  autocomplete="off"/>
				</td>
				<td>
					<input type='text' id='precio_unitario_descuento${i}' name='precio_unitario_descuento[]' disabled="disabled" class="precio_unitario_descuento${i} form-control"  required  autocomplete="off" />
				</td>
				<td><input type='text'   disabled="disabled" class="form-control"  required  autocomplete="off" /></td>
								<td><input type='text'   disabled="disabled" class="form-control"  required  autocomplete="off" /></td>
								
				<td>
					<input type='text' id='total${i}' name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
				</td>
				
				
			</tr>`;
            $('table').append(data);
            i++;
        });
	</script>

	<script>
	function print(){
		var print_input=1;
		document.getElementById("prints").value = print_input;
		var estado = document.querySelector("#prints").value;
		console.log(estado);
	}
	
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

		// Get the checkbox
		var checkBox = document.getElementById(`check${a}`);
		if (checkBox.checked == true){
			var descuento = document.querySelector(`#descuento${a}`).value;
			var precio = document.querySelector(`#precio${a}`).value;
			var final= total-(total*descuento/100);

			var multiplier = 100;
			var final_decimal = Math.round(final * multiplier) / multiplier;  

			var precio_uni=precio-(precio*descuento/100);
			var precio_uni_dec=Math.round(precio_uni * multiplier) / multiplier;  
			document.getElementById(`total${a}`).value = final_decimal;
			document.getElementById(`check_descuento${a}`).value = descuento;
			document.getElementById(`precio_unitario_descuento${a}`).value = precio_uni_dec;
		} else {
			var descuento = 0;
			var precio = document.querySelector(`#precio${a}`).value;
			var final= total-(total*descuento/100);

			var multiplier = 100;
			var final_decimal = Math.round(final * multiplier) / multiplier;  
			document.getElementById(`check_descuento${a}`).value = 0;
			document.getElementById(`total${a}`).value = final_decimal;
			document.getElementById(`precio_unitario_descuento${a}`).value = precio;
		}

		var totalInp = $('[name="total"]'); 
		var total_t = 0;

		totalInp.each(function(){
			total_t += parseFloat($(this).val());
		});

		var multiplier2 = 100;
		var total_tt = Math.round(total_t * multiplier2) / multiplier2;  

		$('#sub_total').val(total_tt);

		var igv_valor={{$igv->renta}};
		var subtotal = document.querySelector(`#sub_total`).value;
		var igv=subtotal*igv_valor/100;

		var igv_decimal = Math.round(igv * multiplier2) / multiplier2;  
		var end=igv_decimal+parseFloat(subtotal);

		var end2 = Math.round(end * multiplier2) / multiplier2;  
		
		document.getElementById("igv").value = igv_decimal;
		document.getElementById("total_final").value = end2;
	
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
			document.getElementById(`cantidad${a}`).value = 1;
			document.getElementById(`precio_unitario_descuento${a}`).value = precio_v;
			document.getElementById(`stock${a}`).value = stock_v; 
			document.getElementById(`descuento${a}`).value = descuento_v;
			document.getElementById(`check_descuento${a}`).value =0;  

		}
	</script>

    <script>
        $(".delete").on('click', function () {
            $('.case:checkbox:checked').parents("tr").remove();
			var totalInp = $('[name="total"]'); 
			var total_t = 0;

			totalInp.each(function(){
				total_t += parseFloat($(this).val());
			});
			$('#sub_total').val(total_t);

			var igv_valor={{$igv->renta}};
			var subtotal = document.querySelector(`#sub_total`).value;
			var igv=parseFloat(subtotal)*igv_valor/100;
			var end=parseFloat(igv)+parseFloat(subtotal);

			console.log(typeof igv);
			console.log(typeof end);
			document.getElementById("igv").value = igv;
			document.getElementById("total_final").value = end;
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
	<style type="text/css">
		.a{color: red}
	</style>

	
@stop