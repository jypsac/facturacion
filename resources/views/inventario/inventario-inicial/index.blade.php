@extends('layout')

@section('title', 'Inventario Inicial')
@section('breadcrumb', 'Inventario Inicial')
@section('breadcrumb2', 'Inventario Inicial')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')

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
                                            <form action="{{ route('inventario-inicial.create') }}"  enctype="multipart/form-data" method="get">
                                            <p>Selecciona Almacen</p>
                                                <div class="form-group">
                                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Almacen:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control m-b" name="almacen">
                                                            @foreach($almacenes as $almacen)
                                                            <option value="{{$almacen->id}}" >{{$almacen->nombre}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            <p>Selecciona Clasificacion</p>
                                                <div class="form-group">
                                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Clasificaion:</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control m-b" name="clasificacion">
                                                            @foreach($clasificaciones as $clasificacion)
                                                            <option value="{{$clasificacion->id}}" >{{$clasificacion->descripcion}}</option>
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
                <h5>Ver</h5>
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
                                <th>Id</th>
                                <th>Clasificacion</th>
                                <th>Codigo</th>
                                <th>Articulo</th>
                                <th>Unidad de medida</th>
                                <th>Saldo</th>
                                <th>Ver</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                    <tbody>
                        @foreach($inventario_iniciales as $inventario_inicial)
                        <tr class="gradeX">
                            <td>{{$inventario_inicial->id}}</td>
                            <td>{{$inventario_inicial->clasificacion}}</td>
                            <td>{{$inventario_inicial->codigo}}</td>
                            <td>{{$inventario_inicial->articulo}}</td>
                            <td>{{$inventario_inicial->unidad_medida}}</td>
                            <td>{{$inventario_inicial->saldo}}</td>
                            {{-- <td><center><a href="{{ route('provedor.show', $provedor->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
                            <td><center><a href="{{ route('provedor.edit', $provedor->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td> --}}

                            <td>Ver</td>
                            <td>Editar</td>
                        </tr>
                    @endforeach
                    </tbody>
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

@endsection