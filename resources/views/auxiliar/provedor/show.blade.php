@extends('layout')

@section('title', 'Provedor Ver')
@section('breadcrumb', 'Provedor Ver')
@section('breadcrumb2', 'Provedor Ver')
@section('href_accion', route('provedor.index'))
@section('value_accion', 'atras')

@section('content')


<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
      <div class="jumbotron" style="height: 50px;padding:10px">
       <center><h1>{{$provedor->empresa}}</h1> </center>
      </div>

  <i  class="fa fa-user-o" aria-hidden="true" style="font-size: 35px"></i>&nbsp;&nbsp;
  <a  class="btn btn-sm btn-success" href="{{ route('provedor.edit', $provedor->id) }}" style="background-color: #1ab394; border-color: #1ab394;padding: 2px 4px"> <i style="font-size: 15px" class="fa fa-edit"></i></a>
  <br><br>
      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Ruc:</h4>
          <p>{{$provedor->ruc}}</p><hr>

          <h4>Direccion:</h4>
          <p>{{$provedor->direccion}}</p><hr>

          <h4>Telefonos:</h4>
          <p>{{$provedor->telefonos}}</p><hr>

          <h4>Correo del provedor:</h4>
          <p>{{$provedor->email_provedor}}</p><hr>
        </div>

        <div class="col-lg-6">
          <h4>Correo:</h4>
          <p>{{$provedor->email}}</p><hr>

          <h4>Nombre del contacto:</h4>
          <p>{{$provedor->contacto_provedor}}</p><hr>

          <h4>Celular del contacto:</h4>
          <p>{{$provedor->celular_provedor}}</p><hr>
          
          

          <h4>Observacion:</h4>
          <p>{{$provedor->observacion}}</p><hr>

        </div>



    </div> 


                           
</div>
</div>


<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>



@endsection