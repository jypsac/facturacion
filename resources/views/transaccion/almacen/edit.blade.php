@extends('layout')

@section('title', 'Almacen')
@section('breadcrumb', 'Almacen-Editar')
@section('breadcrumb2', 'Almacen-Editar')
@section('href_accion', back())
@section('value_accion', 'Atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Editar</h5>
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
					    		<option value="100">Responsable 1</option>
					    		<option value="500">Responsable 2</option>
					    		<option value="100">Responsable 3</option>
					    		</select>
		                    </div>
		                </div>

				    	<button class="btn btn-primary" type="submit" name="action">Editar</button>

					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection