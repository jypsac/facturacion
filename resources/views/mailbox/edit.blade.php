@extends('layout')

@section('title', 'Email Backup')
@section('breadcrumb', 'Email Backup')
@section('breadcrumb2', 'Email Backup')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Editar')

@section('content')
 <div class="wrapper wrapper-content animated fadeInRight">
	<div class="ibox-title">
		<h4>Backup de Email</h4>
	</div>
	<div class="ibox-content">
		<div class="row">
			<div class=" col-sm-3">
			</div>
			<div class=" col-sm-6" style="text-align: center;">
				<label style="text-align: center;font-size: 15px">Correo donde va a llegar una copia de cada email enviado por el sistema</label>
			</div>
			<div class=" col-sm-3">
			</div>
		</div>
		<div class="row">
			<div class=" col-sm-4">
			</div>
			<div class="col-sm-4">
				<label class="form-control" style="text-align: center;">{{$config->email_backup}}</label>
			</div>
			<div class=" col-sm-4">
			</div>
		</div>
		</div>
	</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('backup_save')}}" method="post">
      	@csrf
      <div class="modal-body">
      	<div class="row">
      		<label class="col-sm-2 col-form-label">Editar:</label>
      	<div class="col-sm-10">
      		<input type="email" class="form-control" name="backup" required="" id="" >
      	</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
       </form>

    </div>
  </div>
</div>
<style type="text/css">
	.form-control{
		border-radius: 8px 8px 8px 8px;
	}
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@stop