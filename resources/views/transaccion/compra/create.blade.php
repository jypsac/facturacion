@extends('layout')

@section('title', 'Transaccion - Entrada')
@section('breadcrumb', 'Transaccion')
@section('breadcrumb2', 'Transaccion')
@section('href_accion', route('transaccion-compra.index'))
@section('value_accion', 'Agregar')
@section('vue_js',  asset('js/app.js') )
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content m-b-sm border-bottom">
                <div class="p-xs">
                    <div class="float-left m-r-md">
                        <img src="{{asset('img/logos/logo.jpg')}}" style="width: 150px;height: 85px">
                    </div>
                    <form action="" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Provedor:</label>
                                <label class="col-form-label">Ruc:</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="abrev">
                                </div>
                                <label class="col-form-label">Nombre:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="abrev">
                                </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Direccion:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Fecha de entrega:</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">Atencion:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">Forma de Pago:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Glosa</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">Moneda:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">TC:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                        </div>
                        <button class="btn btn-primary" name="action">Guardar</button>
                    </form>
                </div>
            </div>
            <div class="ibox-content forum-container">
                <div id="app">
                    <cliente-component>

                    </cliente-component>
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

    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>

    <!-- jqGrid -->
    <script src="{{ asset('js/plugins/jqGrid/i18n/grid.locale-en.js') }}"></script>
    <script src="{{ asset('js/plugins/jqGrid/jquery.jqGrid.min.js') }}"></script>

    <!-- Custom and plugin javascript -->


    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>






@endsection