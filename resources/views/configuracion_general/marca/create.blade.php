@extends('layout')

@section('title', 'Marca')
@section('breadcrumb', 'Marca-Agregar')
@section('breadcrumb2', 'Marca-Agregar')
@section('href_accion', route('marca.index') )
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Datos Personales</h5>
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
					<form action="{{ route('marca.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf

					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="nombre"></div>
		                </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Codigo:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="codigo"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Abreviatura:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="abreviatura"></div>
		                </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre de Empresa:</label>
		                    <div class="col-sm-10"><input type="text" class="form-control" name="nombre_empresa"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Descripcion:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="comment" name="descripcion">
                                </textarea>
                            </div>
                        </div>

						<div class="form-group  row"><label class="col-sm-2 col-form-label">Foto:</label>
							<div class="col-sm-10"><input type="file" class="btn btn-success  dim" name="imagen"></div>
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
@stop