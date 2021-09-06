@extends('layout')

@section('title', 'Guias Informe Tecnico')
@section('breadcrumb', 'Informe Tecnico')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_informe_tecnico.guias'))
@section('value_accion', 'Agregar')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" id="table_informe_tec" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Orden servicio</th>
                                            <th>Marca</th>
                                            <th>fecha</th>
                                            <th>Motivo</th>
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

    <!-- Page-Level Scripts -->
        <script>    
$(document).ready(function(){
    $('#table_informe_tec').DataTable({
        // "order": [[ 1, "desc" ]],
        "serverSide":true,
        "ajax":"{{url('api/informe_tecnico')}}",
        "columns":[
            {data : 'inf_tec_id'},
            {data : 'orden_servicio'},
            {data : 'nombre_marca'},
            {data : 'fecha'},
            {data : 'motivo'},
            {data : 'asunto'},
            {data : 'cliente_nom'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<center><a href="{{ route('garantia_informe_tecnico.show', ':id') }}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>';
                    return actions.replace(/:id/g, data.inf_tec_id);
                }
            },
        ]
    });
});

</script>
@endsection