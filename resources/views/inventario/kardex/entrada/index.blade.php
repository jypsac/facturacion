@extends('layout')

@section('title', 'kardex Entrada')
@section('breadcrumb', 'Entrada')
@section('breadcrumb2', 'Entrada')
@section('href_accion', route('kardex-entrada.create'))
@section('value_accion', 'Agregar')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
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
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Codigo</th>
                                    <th>Motivo</th>
                                    <th>Provedor</th>
                                    <th>Almacen</th>
                                    <th>Guia Remision</th>
                                    <th>Factura</th>
                                    <th>Ver</th>
                                    {{-- <th>Editar</th> --}}
                                    <th>Anular</th>
                                </tr>
                            </thead>
                            <tbody><span hidden="hidden">{{$i=0}}</span>
                                @foreach($kardex_entradas as $value => $kardex_entrada)
                                <tr class="gradeX">
                                    <td> {{$i=$i+1}}</td>
                                    <td>{{$kardex_entrada->motivo->nombre}}</td>
                                    <td>{{$kardex_entrada->codigo_guia}}</td>
                                    <td>{{$kardex_entrada->provedor->empresa}}</td>
                                    <td>{{$kardex_entrada->almacen->nombre}}</td>
                                    <td>{{$kardex_entrada->guia_remision}}</td>
                                    <td>{{$kardex_entrada->factura}}</td>
                                    <td><center><a href="{{ route('kardex-entrada.show', $kardex_entrada->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
                                    <td>
                                        <center>
                                            @if($array_final[$value]==1)
                                                @if($kardex_entrada->estado==1)
                                                    <form action="{{ route('kardex-entrada.destroy', $kardex_entrada->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-s-m btn-info">Anular </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-s-m btn-danger">Anulado</button>
                                                 @endif
                                            @else
                                            <button class="btn btn-s-m btn-info">Guia en circulacion</button>

                                            @endif
                                        </center>
                                    </td>
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