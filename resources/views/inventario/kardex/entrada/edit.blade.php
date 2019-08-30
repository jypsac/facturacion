@extends('layout')

@section('title', 'kardex_entradas')
@section('breadcrumb', 'kardex_entradas-Editar')
@section('breadcrumb2', 'kardex_entradas-Editar')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Editar Entrada</h5>
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
					<form action="{{ route('productos.update') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Nombres:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="nombre" value="{{$kardex_entrada->nombre}}"></div>
		                </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Precio:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="precio"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Cantidad:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="cantidad"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Provedor:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="provedor"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Nuevo Costo:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="nuevo_costo"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Almacen:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="almacen"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Informacion:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="informacion"></div>
		                </div>

                		<button class="btn btn-primary" type="submit">Guardar</button>
					</form>
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
@endsection