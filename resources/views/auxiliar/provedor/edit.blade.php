@extends('layout')

@section('title', 'editar provedor')
@section('breadcrumb', 'editar provedor')
@section('breadcrumb2', 'editar provedor')
@section('href_accion', route('provedor.show', $provedor->id))
@section('value_accion', 'atras')

@section('content')


<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style="padding-top: 30px;padding-bottom: 30px; background: white;">
<form action="{{ route('provedor.update',$provedor->id) }}"  enctype="multipart/form-data" method="post">
  @csrf
@method('PATCH')

      <div class="jumbotron" style="height: 60px;padding:10px">
       <center><input style="width: 250px;font-size: 18px;" type="text" class="form-control" name="empresa" value="{{$provedor->empresa}}"></center>
      </div>

<h1><i class="fa fa-user-o" aria-hidden="true"></i></h1>
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Ruc:</h4>
         <p><input type="text" class="form-control" name="ruc" value="{{$provedor->ruc}}"></p>

          <h4>Direccion:</h4>
          <p><input type="text" class="form-control" name="direccion" value="{{$provedor->direccion}}"></p>

          <h4>Telefonos:</h4>
          <p><input type="text" class="form-control" name="telefonos" value="{{$provedor->telefonos}}"></p>

           <h4>Correo del provedor:</h4>
          <p><input type="text" class="form-control" name="email_provedor" value="{{$provedor->email_provedor}}"></p>
        </div>

        <div class="col-lg-6">
        
          <h4>Correo:</h4>
          <p><input type="text" class="form-control" name="email" value="{{$provedor->email}}"></p>

          <h4>Nombre del contacto:</h4>
          <p><input type="text" class="form-control" name="contacto_provedor" value="{{$provedor->contacto_provedor}}"></p>

          <h4>Celular del contacto:</h4>
          <p><input type="text" class="form-control" name="celular_provedor" value="{{$provedor->celular_provedor}}"></p>

          <h4>Observacion:</h4>
          <p><textarea name="observacion" class="form-control">{{$provedor->observacion}}</textarea></p>

        </div>

    </div>
                           
<button class="btn btn-primary" type="submit">Grabar</button>
</form>
</div>
</div>
{{--  --}}
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@stop