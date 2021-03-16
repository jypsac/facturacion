@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Perfil')
@section('breadcrumb2', 'Personal-Perfil')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')

@section('content')
<style>
  .form-control{border-radius:5px;border:1px solid #e5e6e700;background: #ffffff61;color: white;font-size: 25px}
  .fondo_perfil{margin: 10px 40px;padding:10px 0 0 10px; background-image: url('https://cdn.pixabay.com/photo/2016/10/30/20/22/astronaut-1784245_960_720.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;}
  .fh-column{width: 50%;border-right: 2px #c7c7c7b3 solid; padding: 10px;text-align: center;}
</style>
<div class="fh-breadcrumb" style="position: fixed;
}">
  <div class="jumbotron fondo_perfil">
    <div class="row">
      <div class="col-lg-3"><img src="{{ asset('/profile/images/')}}/{{$personales->foto}}" class="rounded-circle circle-border m-b-md"  width="150px" height="150px" ></div>
      <div class="col-lg-3" style="padding-top:30px"><div class="form-control"> {{$personales->nombres}} {{$personales->apellidos}}</div></div>
      <div class="col-lg-3" style="padding-top:30px"><div class="form-control">  {{$personales->nacionalidad}}</div></div>
    </div>
  </div>
  <div class="fh-column">
    <div class="row">
      <div class="col-lg-4"> <h4>Documento </h4>{{$personales->documento_identificacion}}<hr></div>
      <div class="col-lg-4"><h4>Numero Documento</h4>{{$personales->numero_documento}}<hr></div>
      <div class="col-lg-4"> <h4>Fecha Nacimiento</h4>{{$personales->fecha_nacimiento}}<hr></div>
      <div class="col-lg-4"> <h4>Genero</h4>{{$personales->genero}}<hr></div>

      <div class="col-lg-4"><h4>Celular</h4>{{$personales->celular}}<hr></div>
      <div class="col-lg-4"><h4>Telefono</h4>{{$personales->telefono}}<hr></div>
      <div class="col-lg-4"><h4>Correo</h4>{{$personales->email}}<hr></div>
      <div class="col-lg-4"><h4>Direccion</h4>{{$personales->direccion}}<hr></div>

      <div class="col-lg-4"><h4>Nivel Educativo</h4>{{$personales->nivel_educativo}}<hr></div>
      <div class="col-lg-4"><h4>Carrera Profesional</h4>{{$personales->profesion}}<hr></div>
      <div class="col-lg-4"><h4>Estado Civil</h4>{{$personales->estado_civil}}<hr></div>
    </div>
  </div>
  <div class="full-height" style="background: white">
    2
  </div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- blueimp gallery -->
<script src="{{ asset('js/plugins/blueimp/jquery.blueimp-gallery.min.js') }}"></script>

@endsection