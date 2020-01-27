@extends('layout')

@section('title', 'Contacto - crear')
@section('breadcrumb', 'Contacto - crear')
@section('breadcrumb2', 'Contacto - crear')
@section('href_accion', 'javascript:history.back()')
@section('value_accion', 'Atras')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('content')

<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
<form action="{{ route('contacto.store',$id) }}"  enctype="multipart/form-data" method="post">
                             @csrf
<div style="padding-bottom: 10px">
  <h1><i class="fa fa-address-book-o" aria-hidden="true"></i>  </h1>
    <div class="row marketing">
        <div class="col-lg-6">
          <h4>Nombre del Contacto:</h4>
          <p><input class="form-control" type="text" name="nombre" ></p><hr>
          <h4>Cargo:</h4>
          <p><input class="form-control " type="text" name="cargo" ></p><hr>
        </div>
        <div class="col-lg-6">
          <h4>Telefono/Celular:</h4>
         <p class=" row" style="padding-left: 15px"><input class="form-control col-sm-5" name="telefono" type="text" placeholder="Telefono"> &nbsp; -  &nbsp;<input class="form-control col-sm-5" name="celular" type="text" placeholder="Celular" ></p> <hr>
          <h4>Email:</h4>
          <p><input class="form-control" name="email" type="text" ></p><hr>
           <input type="hidden" name="clientes_id" value="{{$id}}">

        </div>
        <div class="col-lg-6">
        <p><input class="btn btn-primary" type="submit" value="Grabar"></p>
        </div>
        
    </div>  
 </div>
</form>
 </div>
 </div>

 <style>
    input{text-align: center;}
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