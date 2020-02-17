@extends('layout')

@section('title', 'kardex_salida')
@section('breadcrumb', 'kardex_salida-Agregar')
@section('breadcrumb2', 'kardex_salida-Agregar')
@section('href_accion', route('kardex-salida.index') )
@section('value_accion', 'Atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Nueva Salida</h5>
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
					<form action="{{ route('kardex-salida.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf

					 	<div class="form-group row ">
							<label class="col-sm-2 col-form-label" >motivos:</label>
								<div class="col-sm-4">
									<select class="form-control" name="motivo">
										@foreach($motivos as $motivo)
										<option value="{{$motivo->id}}" >{{$motivo->nombre}}</option>
										@endforeach
									</select>
								</div>
							<label class="col-sm-2 col-form-label">Informaciones:</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="informacion">
							    </div>
						</div>
					 	
						<table cellspacing="0" class="table table-striped ">
							<thead>
								<tr>
									<th><input class='check_all' type='checkbox' onclick="select_all()" /></th>
									<th>Producto</th>
									<th>Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input type='checkbox' class='case' style="background:red;">
									</td>
									<td>
										<input list="browsers2" class="form-control " name="articulo[]" required id='articulo' autocomplete="off">
											<datalist id="browsers2" >
												@foreach($productos as $producto)
												<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
												@endforeach
											</datalist>
									</td>
									<td>
										<input type='text' id='cantidad' name='cantidad[]' class="monto0 form-control" required/>
									</td>
									<span id="spTotal"></span>
								</tr>
							</tbody>
						</table>

						
						<button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>
						<button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
						<button class="btn btn-primary float-right" type="submit"><i class="fa fa-cloud-upload" aria-hidden="true"> Guardar</i></button>


					</form>
				</div>
			</div>
		</div>
	</div>
</div>

	<style>	
	.form-control{
		border-radius: 5px;
	}
	</style>

	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script>
        var i = 2;
        $(".addmore").on('click', function () {
            var data = `[<tr><td><input type='checkbox' class='case'/></td>";
             <td>
				<input list="browsers" class="form-control " name="articulo[]" required id='articulo' autocomplete="off">
						<datalist id="browsers" >
							@foreach($productos as $producto)
							<option value="{{$producto->id}} | {{$producto->nombre}} | {{$producto->codigo_original}} | {{$producto->codigo_producto}}">
							@endforeach
						</datalist>
			</td>

			<td><input type='text' id='cantidad" + i + "' name='cantidad[]' class="monto form-control"  required/></td>
			
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

	<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

	<script>
		$(document).ready(function () {
			$('.i-checks').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});
		});
	</script>

@endsection
