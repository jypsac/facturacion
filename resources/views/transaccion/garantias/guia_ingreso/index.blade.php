@extends('layout')

@section('title', 'Garantia - Guia de ingreso')
@section('breadcrumb', 'Guia de ingreso')
@section('breadcrumb2', 'Garantia')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')


@section('content')
<!-- modal -->
    <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">



                            <div id="modal-form" class="modal fade" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Agregar</h3>

                                                    <p>Selecciona marca a agregar</p>

                                                    <form action="{{ route('garantia_guia_ingreso.create') }}"  enctype="multipart/form-data" method="get">
                                                        <div class="form-group">{{-- <label>Marca</label> --}}
                                                            <div class="form-group row"><label class="col-sm-2 col-form-label">Marca:</label>
                                                                <div class="col-sm-10">
                                                                    <select class="form-control m-b" name="familia">
                                                                    @foreach($marcas as $marca)
                                                                    <option value="{{$marca->id}}" >{{$marca->nombre}}</option>
                                                                    @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" type="submit"><strong>Grabar</strong></button>
                                                    </form>

                                                        </div>
                                                </div>

                                            </div>
                                    </div>
                                    </div>
                                </div>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Vista Previa</h5>
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
                                <table class="table table-striped table-bordered table-hover dataTables-example" id="table_productos" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Orden servicio</th>
                                            <th>Marca</th>
                                            <th>fecha</th>
                                            <th>Motivo</th>
                                            <th>Asunto</th>
                                            <th>Cliente</th>
                                            <th>Ver</th>
                                            <th>Anular</th>
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


<script >
$(document).ready(function(){
    $('#table_productos').DataTable({
        "serverSide":true,
        "ajax":"{{url('api/garantia_ingreso')}}",
        "columns":[
         {data : 'id'},
         {data : 'orden_servicio'},
         {data : 'marcas'},
         {data : 'fecha'},
         {data : 'motivo'},
         {data : 'asunto'},
         {data : 'cliente'},
         {
            name: '',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                var actions = '';
                actions += '<center><a href="{{ route('garantia_guia_ingreso.show', ':id') }}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center>';
                return actions.replace(/:id/g, data.id);
            }
         },
         {
            // data: 'anulacion'
            name: '',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                if(data.anulacion == 1){
                    if(data.estado == 1){
                        var actions = '';
                        actions += '<center><a data-toggle="modal" class="btn btn-warning" href="#modal-form:id">Anular</a></center>'+
                        '<div id="modal-form:id" class="modal fade" aria-hidden="true">'+
                            '<div class="modal-dialog">'+
                                '<div class="modal-content">'+
                                    '<div class="modal-body">'+
                                        '<div class="row">'+
                                            '<div class="col-sm-12 b-r"><h3 class="m-t-none m-b">¿Seguro que desea ANULAR esta guia? :id </h3>'+
                                                '<p>Esta guia se anulara inmediatamente. Esta acción no se puede deshacer</p>'+
                                                '<form action=" {{ route('garantia_guia_ingreso.update', ':id') }} "  enctype="multipart/form-data" method="post">'+
                                                    '@csrf @method('PATCH')'+
                                                    '<button type="submit" class="btn btn-w-m btn-danger">ANULAR</button>'+
                                                '</form>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                        return actions.replace(/:id/g, data.id);
                    }else{
                        var actions2 = '';
                        data: 'id';
                        actions2 += '<center><button class="btn btn-w-m btn-secondary">PROCESADO</button></center>';
                         return actions2.replace(/:id/g, data.id);
                    }
                }else{
                    var actions2 = '';
                    data: 'id';
                    actions2 += '<center><button class="btn btn-w-m btn-info">FUERA DE FUNCION</button></center>';
                     return actions2.replace(/:id/g, data.id);
                }
            }
         },
        ]
    });
});
</script>


@endsection