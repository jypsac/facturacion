@extends('layout')

@section('title', 'Clasificacion')
@section('breadcrumb', 'Clasificacion')
@section('breadcrumb2', 'Clasificacion')
@section('href_accion', route('home') )
@section('value_accion', 'Inicio')

@section('content')

<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                    <h5>-></h5>
                    </div>
                        <div class="ibox-content">
                        	<div class="row">
                        		<div class="col-lg-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Categorias
                                        </div>
                                        <div class="panel-body">
                                            <center><a href="{{route('categoria.index')}}"><img src="{{asset('img/logos/logo.jpg')}}" style="width: 180px;height: 100px"></a></center>
                                            <center>
                                                <p>Descripcion</p>
                                            </center>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Familias
                                        </div>
                                        <div class="panel-body">
                                            <center><a href="{{route('familia.index')}}"><img src="{{asset('img/logos/logo.jpg')}}" style="width: 180px;height: 100px"></a></center>
                                            <center>
                                                <p>Descripcion</p>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Marcas
                                        </div>
                                        <div class="panel-body">
                                            <center><a href="{{route('marca.index')}}"><img src="{{asset('img/logos/logo.jpg')}}" style="width: 180px;height: 100px"></a></center>
                                            <center>
                                                <p>Descripcion</p>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                        	</div>
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