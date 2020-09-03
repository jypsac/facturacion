@extends('layout')

@section('title', 'periodo consulta')
@section('breadcrumb', 'periodo consulta')
@section('breadcrumb2', 'periodo consulta')
@section('href_accion', route('periodo-consulta.index') )
@section('value_accion', 'Atras')


@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Vista</h5>
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
            </div><div class="ibox-content">

                        <div class="form-group row ">
                            <label class="col-sm-1 col-form-label" >Nombre:</label>
                                <div class="col-sm-5">
                                    <p class="form-control" >{{$periodo_consulta->nombre}}</p>
                                </div>
                             <label class="col-sm-1 col-form-label" >Almacen:</label>
                                <div class="col-sm-5">
                                    <p class="form-control" >{{$periodo_consulta->almacen_periodo->nombre}}</p>
                                </div>
                        </div>

                        <div class="form-group row ">
                            <label class="col-sm-1 col-form-label">Informacion:</label>
                                <div class="col-sm-5">
                                   <p class="form-control" >{{$periodo_consulta->informacion}}</p>
                                </div>
                                <label class="col-sm-1 col-form-label">Fecha:</label>
                                <div class="col-sm-5">
                                   <p class="form-control"  >{{$periodo_consulta->created_at}}</p>
                                </div>
                        </div>

                </div>
            <div class="ibox-content">

                <table class="table table-striped">
                        <thead class="thead-" style="background: #4f5254b8; color: white; ">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Producto</th>
                        <th scope="col">Cantidad Inicial</th>
                        <th scope="col">Precio nacional</th>
                        <th scope="col">Precio extranjero</th>
                        <th scope="col">Cantidad</th>
                        {{-- <th scope="col">Nombre</th>
                        <th scope="col">Informacion</th>
                        <th scope="col">Almacen</th>
                        <th scope="col">Fecha y hora de creacion</th> --}}

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($periodo_consulta_registros as $periodo_consulta_registro)
                        <tr class="gradeX">
                            <td>{{$periodo_consulta_registro->id}}</td>
                            <td>{{$periodo_consulta_registro->periodo_producto->nombre}}</td>
                            <td>{{$periodo_consulta_registro->cantidad_inicial}}</td>
                            <td>{{$periodo_consulta_registro->precio_nacional}}</td>
                            <td>{{$periodo_consulta_registro->precio_extranjero}}</td>
                            <td>{{$periodo_consulta_registro->cantidad}}</td>
                            {{-- <td>{{$periodo_consulta->nombre}}</td>
                            <td>{{$periodo_consulta->informacion}}</td>
                            <td>{{$periodo_consulta->almacen_periodo->nombre}}</td>
                            <td>{{$periodo_consulta->created_at}}</td> --}}
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>
<style>
    .form-control{border:none; font-weight: bold;}
</style>

	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection
