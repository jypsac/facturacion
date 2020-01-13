@extends('layout')

@section('title', 'kardex_entradas')
@section('breadcrumb', 'kardex_entradas-Agregar')
@section('breadcrumb2', 'kardex_entradas-Agregar')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')
{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.4.1.min.js integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script> --}}

@section('content')
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
					<form action="{{ route('kardex-entrada.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Nombres:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="nombre"></div>
		                </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Precio:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="precio"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Serie del producto:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="serie_producto"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Cantidad:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="cantidad"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Provedor:</label>
		                    <div class="col-sm-10">
								<select class="form-control" name="provedor">
									@foreach($provedores as $provedor)
									<option>{{$provedor->empresa}}</option>
									@endforeach
								</select>
							</div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Almacen:</label>
							<div class="col-sm-10">
								<select class="form-control" name="almacen">
									@foreach($almacenes as $almacen)
									<option value="{{$almacen->abreviatura}}">{{$almacen->abreviatura}} -> {{$almacen->descripcion}}</option>
									@endforeach
								</select>
							</div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Informacions:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="informacion"></div>
						</div>

						<table border="1" cellspacing="0">
							<tr>
								<th><input class='check_all' type='checkbox' onclick="select_all()" /></th>
								<th>---- Codigo ------ Descripcion</th>

								<th>Cantidad</th>
								<th>Precio</th>
								<th>Total</th>
							</tr>
							<tr>
								<td><input type='checkbox' class='case' /></td>
								<td>
								<select class="form-control" id='descripcion' name='descripcion[]' required>
									@foreach($productos as $producto)
									<option value="{{$producto->id}}">{{$producto->codigo_producto}} -> {{$producto->nombre}}</option>
									@endforeach
								</select></td>

								<td><input type='text' id='cantidad' name='cantidad[]' class="monto" onkeyup="multi();"  required/></td>
								<td><input type='text' id='precio' name='precio[]' class="monto" onkeyup="multi();" required/></td>
								<td><input type='text' id='total' name='total[]' required/></td>
								<span id="spTotal"></span>
							</tr>
						</table>

						<button type="button" class='delete'>- Eliminar</button>
						<button type="button" class='addmore'>+ Agregar</button>



						<button class="btn btn-primary" type="submit">Guardar</button>

					</form>




<tr>
    {{-- <td>
    <label>
      <input type="text" name="Precio" id="Precio" value="" class="monto" onkeyup="multi();">
    </label>
  </td>
    <td>
    <label>
      <input type="text" name="Cantidad" id="Cantidad" class="monto" onkeyup="multi();">
    </label>
  </td> --}}
  <td>
    <label id="Costo">
      <input type="text" name="Costo" disabled>
    </label>
  </td>
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

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script>
// function multi(){
//     var total = 1;
//     var change= false; //
//     $(".monto").each(function(){
//         if (!isNaN(parseFloat($(this).val()))) {
//             change= true;
//             total *= parseFloat($(this).val());
//         }
//     });
//     total = (change)? total:0;
//     document.getElementById('Costo').innerHTML = total;
// }
</script>


    <script>
        var i = 2;
        $(".addmore").on('click', function () {
            var data = `[<tr><td><input type='checkbox' class='case'/></td>";
             <td>
			<select class="form-control" id='descripcion' name='descripcion[]' required>
									@foreach($productos as $producto)
									<option value="{{$producto->id}}">{{$producto->codigo_producto}} --- {{$producto->nombre}}</option>
									@endforeach
								</select>
			</td>

			<td><input type='text' id='cantidad" + i + "' name='cantidad[]' onkeyup="multi();" required/></td>
			<td><input type='text' id='precio" + i + "' name='precio[]' onkeyup="multi();" required/></td>
			<td><input type='text' id='total" + i + "' name='total[]' required/></td>
			</tr>`;
            $('table').append(data);
            i++;
        });
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
    {{-- <script src="https://code.jquery.com/jquery-1.9.1.min.js"
	integrity="sha256-wS9gmOZBqsqWxgIVgA8Y9WcQOa7PgSIX+rPA0VL2rbQ=" crossorigin="anonymous"></script> --}}


	<script>function multi(){
		var total = 1;
		var change= false; //
		$(".monto").each(function(){
			if (!isNaN(parseFloat($(this).val()))) {
				change= true;
				total *= parseFloat($(this).val());
			}
		});
		total = (change)? total:0;
		document.getElementById('Costo').innerHTML = total;
	}
	</script>

@endsection