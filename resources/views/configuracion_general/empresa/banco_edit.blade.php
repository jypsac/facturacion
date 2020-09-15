@extends('layout')
@section('title', 'Configuracion de Empresa')
@section('breadcrumb', 'Empresa')
@section('breadcrumb2', 'Empresa')
@section('href_accion' ,route('empresa.index'))
@section('value_accion', 'atras')

@section('content')
<div class="container" style="height:auto;padding-top: 10px; background: white; margin-bottom: 50px; padding-bottom: 30px" >
      <div class="jumbotron">
        <h1>{{$banco->nombre}}
        <img align="right"  src="{{asset('img/logos/'.$banco->foto)}}" style="width: 250px;height: auto; border-radius:15px"></h1>
<br>
      </div>
 <form action="{{route('banco.update',$banco->id) }}"  enctype="multipart/form-data" method="post">
		@csrf
		@method('PATCH')
      <div class="row ">

        <div class="col-lg-6">
        	<div class="row">
        		<label class="col-sm-3 ">N° Soles: </label>
        		<div class="col-sm-9"><input class="form-control" type="text" name="numero_soles" value="{{$banco->numero_soles}}" ></div>
        	</div>
        </div>

        <div class="col-lg-6">
        	<div class="row">
        		<label class="col-sm-3 ">N° Dolares: </label>
        		<div class="col-sm-9"><input class="form-control" type="text" name="numero_dolares" value="{{$banco->numero_dolares}}" ></div>
        	</div>
        </div>
        <div class="col-lg-6">
        	<div class="row">
        		<label class="col-sm-3 ">Estado: </label>
        		<div class="col-sm-9">
        			<select class="form-control" name="estado">
        				@if($banco->estado==0)
        				<option value="0">Activado</option>
        				@else
        				<option value="1">Desactivado</option>
        				@endif

        				@if($banco->estado==0)
        				<option value="1">Desactivado</option>
        				@else
        				<option value="0">Activado</option>
        				@endif
        			</select></div>
        	</div>
        </div>
         <div class="col-lg-6" style="padding-top: 5px">
        		 <button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit"><strong>Grabar</strong></button>
        </div>

      </div>
 </form>
 </div>
     <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<style type="text/css">
	.col-lg-6{padding-bottom: 8px}
</style>
@endsection