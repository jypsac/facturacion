@extends('layout')

@section('title', 'Facturacion Electronica')
@section('breadcrumb', 'Facturacion Electronica')
@section('breadcrumb2', 'Facturacion Electronica')
@section('href_accion' ,route('igv.edit',1))
@section('value_accion', 'editar')

@section('content')
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                    <h5>Facturacion Electronica</h5>
                    </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            RUC
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$igv->updated_at}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            USUARIO
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$igv->igv_total}}</p></center>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
                                            CLAVE SOL
                                        </div>
                                        <div class="panel-body">
                                            <center><p>{{$igv->renta}}</p></center>
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