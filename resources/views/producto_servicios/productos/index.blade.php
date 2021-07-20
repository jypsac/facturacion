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
                <div class="ibox-title">
                    <h5>Creacion de Almacen</h5>
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
                        <table class="table table-striped table-bordered table-hover dataTables-example " id="table_productos">
                            <thead>
                            <tr><!--
                                <th>COD. GENERAL</th> -->
                                <th>N° Registro</th>
                                <th>Codigo Producto</th>
                                <th>Codigo Original</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Estado</th>
                                <th>Afectacion</th>
                                <th>Foto</th>
                                <th>Ver</th>
                                {{-- <th>Editar</th> - --}}
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
    $('#table_productos').DataTable({
        "serverSide":true,
        "ajax":"{{url('api/productos')}}",
        "columns":[
            {data : 'id'},
            {data : 'codigo_producto'},
            {data : 'codigo_original'},
            {data : 'nombre'},
            {data : 'categoria'},
            {data : 'marca'},
            {data : 'estado'},
            {data : 'afectacion'},
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
                    actions += '<a href="{{ route('productos.show',':id') }}" target="_blank"><span class="btn btn-success" >VER</span></a>';
                    return actions.replace(/:id/g, data.id);
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
                        actions += '<button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#:id">Anular</button><div class="modal fade" id=":id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" style="margin-top: 12%; border-radius: 20px"><div class="modal-content" ><div class="modal-body" style="padding: 0px;"><div class="ibox-content float-e-margins"><h3 class="font-bold col-lg-12" align="center">¿Esta Seguro que Deseas Anular el Producto: :id".?<br><h4 align="center"> <strong>Nota: Una vez Anulado no hay opcion de devolver la accion </strong></h4></h3><p align="center"><form action="{{ route('productos.destroy',':id')}}" method="POST">@csrf @method('delete')<center><button type="submit" class="btn btn-w-m btn-primary">Anular</button></form></p></div></div></div></div></div>';
                        return actions.replace(/:id/g, data.id);
                    }else{
                        var actions2 = '';
                        data: 'id';
                        actions2 += '<a href="{{ route('productos.show',':id') }}" target="_blank"><span class="btn btn-secondary" >ANULADO</span></a>';
                         return actions2.replace(/:id/g, data.id);
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
</script>

-->

@endsection