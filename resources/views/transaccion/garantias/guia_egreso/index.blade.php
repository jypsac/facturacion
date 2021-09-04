@extends('layout')

@section('title', 'Garantia - Guia de egreso')
@section('breadcrumb', 'Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.guias'))
@section('value_accion', 'Agregar')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Vista Previa</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" id="table_egreso" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Marca</th>
                                            <th>Estado</th>
                                            <th>Motivo</th>
                                            <th>Ing Asignado</th>
                                            <th>fecha</th>
                                            <th>Orden servicio</th>
                                            <th>Asunto</th>
                                            <th>Cliente</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
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

<script>    
$(document).ready(function(){
    $('#table_egreso').DataTable({
        // "order": [[ 1, "desc" ]],
        "serverSide":true,
        "ajax":"{{url('api/garantia_egreso')}}",
        "columns":[
            {data : 'egreso_id'},
            {data : 'nombre_marca'},
            {data : 'estado'},
            {data : 'motivo'},
            {data : 'personal_as'},
            {data : 'fecha'},
            {data : 'orden_servicio'},
            {data : 'asunto'},
            {data : 'cliente_nom'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<center><a href="{{ route('garantia_guia_egreso.show', ':id') }}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>';
                    return actions.replace(/:id/g, data.egreso_id);
                }
             }
        ]
    });
});

</script>
@endsection