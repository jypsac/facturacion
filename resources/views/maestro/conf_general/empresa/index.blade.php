@extends('layout')

@section('title', 'Configuracion de Empresa')
@section('breadcrumb', 'Empresa')
@section('breadcrumb2', 'Empresa')
@section('href_accion' ,route('empresa.index'))
@section('value_accion', 'actualizar')

@section('content')
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                    <h5>{{$mi_empresa->nombre}}</h5>
                    </div>
                        <div class="ibox-content">
                        	<div class="row">
                        		<div class="col-lg-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Logo
                                        </div>
                                        <div class="panel-body">
                                            <center><img src="{{asset('img/logos/logo.jpg')}}" style="width: 378px;height: 77px"></center>
                                            <center> 
                                                <p>{{$mi_empresa->descripcion}}</p>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                        	</div>

                            <div class="row">

                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Razon Social
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->razon_social}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            RUC
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->ruc}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Telefono
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->telefono}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Movil
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->movil}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Correo
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->correo}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Pais
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->pais}}</p></center>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
								<div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Region Provincia
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->region_provincia}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Ciudad
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->ciudad}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Calle
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->calle}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Codigo Postal
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->codigo_postal}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Rubro
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->rubro}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            Moneda Principal
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$mi_empresa->moneda_principal}}</p></center>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>
	</div>
	<div class="footer">
            <div class="float-right">
                Visitanos: <a href="http://www.jypsac.com"><strong>JYP</strong></a> <
            </div>
            <div>
                <strong>Copyright</strong> JyP Perifericos &copy; 2019-2020
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

<script>

    $(document).ready(function () {

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '200px'
        })

    });

</script>

@endsection