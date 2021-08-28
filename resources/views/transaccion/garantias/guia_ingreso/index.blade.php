@extends('layout')

@section('title', 'Garantia - Guia de ingreso')
@section('breadcrumb', 'Guia de ingreso')
@section('breadcrumb2', 'Garantia')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')

<!-- modal -->
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Agregar</h3>
                        <p>Selecciona marca a agregar</p>
                        <form action="{{ route('garantia_guia_ingreso.create')}}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group">
                                <div class="form-group row"><label class="col-sm-2 col-form-label">Marca:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="marca">
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
<div class="wrapper wrapper-content animated fadeInRight">
    @if (session('repite'))
    <div class="alert alert-danger">
        {{ session('repite') }}
    </div>
    @endif
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
                <div class="">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Vista Previa</h5>
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
                                            <th></th>
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
        // "order": [[ 1, "desc" ]],
        "serverSide":true,
        "ajax":"{{url('api/garantia_ingreso')}}",
        "columns":[
        {data : 'gar_ing_id'},
        {data : 'orden_servicio'},
        {data : 'nombre_marca'},
        {data : 'fecha'},
        {data : 'motivo'},
        {data : 'asunto'},
        {data : 'cliente_nom',},
        {
            name: '',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                var actions = '';
                actions += '<center><a href="{{ route('garantia_guia_ingreso.show', ':id') }}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center>';
                return actions.replace(/:id/g, data.gar_ing_id);
            }
        },
        {
            // data: 'anulacion'
            name: '',
            data: null,
            sortable: false,
            searchable: false,
            render: function (data) {
                if(data.estado_ga_ing == 1 && data.egresado == 0){
                    var actions1 = '';
                    actions1 += '<center><a data-toggle="modal" class="btn btn-warning btn-circle btn-ls" href="#modal-form:id"><i class="fa fa-trash-o"></i></a></center>'+
                    '<div id="modal-form:id" class="modal fade" aria-hidden="true">'+
                    '<div class="modal-dialog">'+
                    '<div class="modal-content">'+
                    '<div class="modal-body">'+
                    '<div class="row" align="center">'+
                    '<div class="col-sm-12 b-r"><h3 class="m-t-none m-b">¿Seguro que desea anular esta guia?</h3>'+
                    '<p>Esta guia se anulara inmediatamente. Esta acción no se puede deshacer</p>'+
                    '<form action=" {{ route('garantia_guia_ingreso.update', ':id') }} "  enctype="multipart/form-data" method="post">'+
                    '@csrf @method('PATCH')'+
                    '<center><button type="submit" class="btn btn-w-m btn-danger">Anular</button></center>'+
                    '</form>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                    return actions1.replace(/:id/g, data.gar_ing_id);
                }else if(data.egresado == 1){
                    var actions2 = '';
                    data: 'id';
                    actions2 += '<center><button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button></center>';
                    return actions2.replace(/:id/g, data.gar_ing_id);/*PROCESADO*/
                }else if(data.estado_ga_ing == 0 && data.egresado == 0){
                    var actions2 = '';
                    data: 'id';
                    actions2 += '<center><button class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button></center>';
                    return actions2.replace(/:id/g, data.gar_ing_id);/*ANULADO*/
                }else if(data.estado_ga_ing == 2 && data.egresado == 0){
                    var actions2 = '';
                    data: 'id';
                    actions2 += '<center><button style="background: gray;" class="btn btn-circle btn-ls"><i style="color: white;" class="fa fa-history"></i></button></center>';
                    return actions2.replace(/:id/g, data.gar_ing_id);/*FUERA DE FUNCION*/
                }
            }
        },
        ]
    });
    });
</script>


@endsection