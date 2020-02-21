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
            </div>
            <div class="ibox-content">

                <table class="table  table-striped ">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad Inicial</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($periodo_consulta_registros as $periodo_consulta_registro)
                        <tr class="gradeX">
                            <td>{{$periodo_consulta_registro->id}}</td>
                            <td>{{$periodo_consulta_registro->periodo_producto->nombre}}</td>
                            <td>{{$periodo_consulta_registro->cantidad_inicial}}</td>
                            <td>{{$periodo_consulta_registro->precio}}</td>
                            <td>{{$periodo_consulta_registro->cantidad}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
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

    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection
