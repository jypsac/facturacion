@extends('layout')

@section('title', 'Configuracion Sistema')
@section('breadcrumb', 'Configuracion Sistema')
@section('breadcrumb2', 'Configuracion Sistema')
@section('href_accion','/' )
@section('value_accion', 'Inicio')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Configuracion General</h5>
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Tema</th>
                                    <th>TIPO CONFIGURACION</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/svg/static/icons/svg/2897/2897818.svg" width="13px" alt=""></td>
                                    <td>Almacen</td>
                                    <td><a class="btn btn-primary" href="{{ route('almacen.index') }}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/svg/static/icons/svg/852/852890.svg" width="13px" alt=""></td>
                                    <td>Apariencia</td>
                                    <td><a class="btn btn-primary" href="{{route('apariencia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/svg/static/icons/svg/25/25622.svg" width="13px" alt=""></td>
                                    <td>Categorias</td>
                                    <td><a class="btn btn-primary" href="{{route('categoria.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                 <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/svg/static/icons/svg/3076/3076591.svg" width="15px" alt=""></td>
                                    <td>Familias</td>
                                    <td><a class="btn btn-primary" href="{{route('familia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/svg/static/icons/svg/25/25345.svg" width="13px" alt=""></td>
                                    <td>Marcas</td>
                                    <td><a class="btn btn-primary" href="{{route('marca.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/svg/static/icons/svg/25/25605.svg" width="13px" alt=""></td>
                                    <td>Motivo</td>
                                    <td><a class="btn btn-primary" href="{{route('motivo.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><i class="fa fa-money" aria-hidden="true"></i></td>
                                    <td>Monedas</td>
                                    <td><a class="btn btn-primary" href="{{route('moneda.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><i class="fa fa-pie-chart"></i></td>
                                    <td>IGV</td>
                                    <td><a class="btn btn-primary" href="{{route('igv.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><i class="fa fa-balance-scale"></i></td>
                                    <td>Unidades de Medidas</td>
                                    <td><a class="btn btn-primary" href="{{route('unidad-medida.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/svg/static/icons/svg/929/929493.svg" width="15px" alt=""></td>
                                    <td>Usuarios</td>
                                    <td><a class="btn btn-primary" href="{{route('usuario.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="https://www.flaticon.es/premium-icon/icons/svg/2460/2460831.svg" width="16px" alt=""></td>
                                    <td>Tipo de Cambio</td>
                                    <td><a class="btn btn-primary" href="{{route('tipo_cambio.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="" width="16px" alt=""></td>
                                    <td>Backup de Email</td>
                                    <td><a class="btn btn-primary" href="{{route('email_backup')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
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