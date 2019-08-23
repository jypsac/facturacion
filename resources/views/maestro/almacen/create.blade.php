@extends('layout')

@section('title', 'Almacen')
@section('breadcrumb', 'Almacen-Agregar')
@section('breadcrumb2', 'Almacen-Agregar')
@section('href_accion', route('almacen.index') )
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Agregar</h5>
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
					<form action=""  enctype="multipart/form-data" method="post">
					 	@csrf

					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Abreviatura:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="abrev"></div>
		                </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="name"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Dirección:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="direccion"></div>
		                </div>

		                <div class="form-group row"><label class="col-sm-2 col-form-label">Seleccionar Responsable:</label>
							<div class="col-sm-10">
								<select class="form-control m-b" name="responsable">
			          			<option>Seleccione</option>
					    		<option value="100">100MB</option>
					    		<option value="500">500MB</option>
					    		<option value="1000">1GB</option>
					    		<option value="2000">2GB</option>
					    		<option value="5000">5GB</option>
					    		<option value="10000">10GB</option>
					    		<option value="20000">20GB</option>
					    		<option value="50000">50GB</option>
		                        <option value="75000">75GB</option>
		                        <option value="100000">100GB</option>
		                        <option value="250000">250GB</option>
					    		</select>
		                    </div>
		                </div>

				    	<button class="btn btn-primary" type="submit" name="action">Guardar</button>

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