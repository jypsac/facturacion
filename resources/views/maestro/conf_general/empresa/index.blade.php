@extends('layout')

@section('title', 'Configuracion de Empresa')
@section('breadcrumb', 'Empresa')
@section('breadcrumb2', 'Empresa')
@section('href_accion' ,route('empresa.index'))
@section('value_accion', 'actualizar')

@section('content')
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <div class="container" style="height:800px;padding-top: 10px">
      <div class="jumbotron">
        <h1>{{$mi_empresa->nombre}}
        <img align="right"  src="{{asset('img/logos/logo.jpg')}}" style="width: 300px;height: 50px; border-radius:15px"></h1>
<br>
        <p class="lead" style="font-size: 15px">{{$mi_empresa->descripcion}}</p>
        <p><a class="btn btn-lg btn-success" href="#" style="background-color: #1ab394; border-color: #1ab394"> <i class="fas fa-edit"></i></a></p>
      </div>

      <div class="row marketing">
        <div class="col-lg-6">
          <h4> Razon Social</h4>
          <p>{{$mi_empresa->razon_social}}</p>

          <h4>RUC</h4>
          <p>{{$mi_empresa->ruc}}</p>

          <h4>Telefono</h4>
          <p>{{$mi_empresa->telefono}}</p>
        </div>

        <div class="col-lg-6">
          <h4>Movil</h4>
          <p>{{$mi_empresa->movil}}</p>

          <h4>Correo</h4>
          <p>{{$mi_empresa->correo}}</p>

          <h4>Pais</h4>
          <p>{{$mi_empresa->pais}}</p>
        </div>
        <div class="col-lg-6">
          <h4>Region Provincia</h4>
          <p>{{$mi_empresa->region_provincia}}</p>

          <h4>Ciudad</h4>
          <p>{{$mi_empresa->ciudad}}</p>

          <h4>Calle</h4>
          <p>{{$mi_empresa->calle}}</p>
        </div>
        <div class="col-lg-6">
          <h4>Codigo Postal</h4>
          <p>{{$mi_empresa->codigo_postal}}</p>

          <h4>Rubro</h4>
          <p>{{$mi_empresa->rubro}}</p>

          <h4>Moneda Principal</h4>
          <p>{{$mi_empresa->moneda_principal}}</p>
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

<script>

    $(document).ready(function () {

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '300px'
        })

    });

</script> 

@endsection