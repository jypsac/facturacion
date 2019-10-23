@extends('layout')

@section('title', 'crear provedor')
@section('breadcrumb', 'crear provedor')
@section('breadcrumb2', 'crear provedor')
@section('href_accion', route('provedor.index'))
@section('value_accion', 'atras')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Creacion de provedor</h5>
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
					<form action="{{ route('provedor.store') }}"  enctype="multipart/form-data" method="post">
					 	@csrf
					 	<div class="form-group  row"><label class="col-sm-2 col-form-label">Ruc:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="ruc"></div>
                        </div>
                        
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre de Empresa:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="empresa"></div>
                        </div>

				        <div class="form-group  row"><label class="col-sm-2 col-form-label">Direccion:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="direccion"></div>
		                </div>

		                <div class="form-group  row"><label class="col-sm-2 col-form-label">Telefonos:</label>
		                     <div class="col-sm-10"><input type="text" class="form-control" name="telefonos"></div>
		                </div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Correo:</label>
		                     <div class="col-sm-10"><input type="email" class="form-control" name="email"></div>
                        </div>
                        
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre del contacto:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="contacto_provedor"></div>
                       </div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Celular del contacto:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="celular_provedor"></div>
                        </div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Correo del provedor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="email_provedor"></div>
                        </div>

                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Observacion:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="observacion"></div>
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