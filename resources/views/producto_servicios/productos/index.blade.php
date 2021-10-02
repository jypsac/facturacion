@extends('layout')

@section('title', 'productos')
@section('breadcrumb', 'productos')
@section('breadcrumb2', 'productos')
@section('value_accion', 'Agregar')
@section('href_accion', route('productos.create'))
@section('content')



<div class="wrapper wrapper-content animated fadeInRight">
    @if (session('anulacion'))
    <div class="alert alert-danger">
        {{ session('anulacion') }}
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example " id="table_prod">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Nombre</th>
                                    <th>Codigo Producto</th>
                                    <th>Codigo Original</th>
                                    {{-- <th>Familia</th> --}}
                                    <th>Marca</th>
                                    <th>Estado</th>
                                    <th>Afectacion</th>
                                    <th>Foto</th>
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

<script>
    $(document).ready(function(){
        $('#table_prod').DataTable({
            "serverSide":true,
            "ajax":"{{url('api/productos')}}",
            "columns":[
            {data : 'prod_id'},
            {data : 'prod_nomnre'},
            {data : 'codigo_producto'},
            {data : 'codigo_original'},
            // {data : 'familia_desc'},
            {data : 'nombre_marca'},
            {data : 'estado_nom'},
            {data : 'afectacion_info'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var imagen_act = '';
                    imagen_act += '<img src="{{ asset('/archivos/imagenes/productos/')}}/:foto" style="width: 45px;" />';
                    return imagen_act.replace(/:foto/g, data.foto);
                }
            },
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<a href="{{ route('productos.show',':id') }}" target="_blank"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a>';
                    return actions.replace(/:id/g, data.prod_id);
                }
            },
            {
                data: null,
                name: '',
                sortable: false,
                searchable: false,
                render: function (data) {
                    if(data.estado_anular == 1){
                        data: null;
                        var actions = '';
                        actions +=
                        '<button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#:id"><i class="fa fa-trash-o" aria-hidden="true"></i></button>'+
                        '<div class="modal fade" id=":id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
                        '<div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">'+
                        '<div class="modal-content" >'+
                        '<div class="modal-body" style="padding: 0px;">'+
                        '<div class="ibox-content float-e-margins">'+
                        '<h3 class="font-bold col-lg-12" align="center">'+
                        '¿Esta Seguro que Deseas Anular el Producto: :id".?<br>'+
                        '<h4 align="center"> <strong>Nota: Una vez Anulado no hay opcion de devolver la accion </strong></h4>'+
                        '</h3><p align="center"><form action="{{ route('productos.destroy',':id')}}" method="POST">'+
                        '@csrf @method('delete')'+

                        '<center><button type="submit" class="btn btn-w-m btn-primary">Anular</button></form>'+
                        '</p></div></div></div></div></div>';
                        return actions.replace(/:id/g, data.prod_id);
                    }else{
                        var actions2 = '';
                        data: 'id';
                        actions2 += '<a href="#"><span class="btn btn-secondary" ><i class="fa fa-times-circle" aria-hidden="true"></i></span></a>';
                        return actions2.replace(/:id/g, data.prod_id);
                    }

                }
            }
            ]
        });
    });

</script>





<!-- Page-Level Scripts


<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({

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
</script>

-->

@endsection