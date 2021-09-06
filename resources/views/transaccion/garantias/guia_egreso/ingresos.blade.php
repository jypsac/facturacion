@extends('layout')

@section('title', ' Guias de Ingreso Disponibles')
@section('breadcrumb', 'Elegir Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.index'))
@section('value_accion', 'Atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
 @if($errors->any())
 <div style="padding-top: 20px;">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" id="table_egreso" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Marca</th>
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

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('#table_egreso').DataTable({
            "order": [[ 1, "desc" ]],
            "serverSide":true,
            "ajax":"{{url('api/garantia_ingreso_guias')}}",
            "columns":[
            {data : 'gar_ing_id'},
            {data : 'nombre_marca'},
            {data : 'motivo'},
            {data : 'personal_as'},
            {data : 'fecha'},
            {data : 'orden_servicio'},
            {data : 'asunto'},
            {data : 'cliente_nom',},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<center><a href="{{route('garantia_guia_egreso.create_egreso', ':id') }}"><button type="button" class="btn btn-info"><i class="fa fa-sign-in"></i></button></a></center>';
                    return actions.replace(/:id/g, data.gar_ing_id);
                }
            }
            ]
        });
    });

</script>
{{--     <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });

    </script> --}}
    @endsection