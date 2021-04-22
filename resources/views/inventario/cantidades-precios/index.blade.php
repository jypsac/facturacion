@extends('layout')
@section('title', 'Cantidades y Precios de Productos')
@section('breadcrumb', 'Cantidades y Precios de Productos')
@section('breadcrumb2', 'Cantidades y Precios de Productos')
@section('href_accion', '#')
@section('value_accion', '#')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Cantidades y Precios de Productos</h5>
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
                        <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                        placeholder="Buscar">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="8" data-filter=#filter>
                            <thead>
                                <tr>
                                    <th data-toggle="true">Id</th>
                                    <th>Nombre de Produto</th>
                                    <th>Stock</th>

                                    <th>Precio Nacional Venta</th>
                                    <th>Precio Extranjero Venta</th>
                                    <th data-hide="all" >Codigo</th>
                                    <th data-hide="all">Descripcion</th>
                                    <th data-hide="all">Garantia</th>
                                    <th data-hide="all">Marca</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($stock_producto as $index => $stock_producto)
                                 <tr class="gradeX">
                                    <td>{{$id++}}</td>
                                    <td>
                                        <a href="{{ route('productos.show', $stock_producto->producto_id) }}" target="_blank">
                                            {{$stock_producto->producto->nombre}}
                                        </a>
                                    </td>
                                    @if($stock_producto->stock > 0)
                                        <td>{{$stock_producto->stock}}</td>
                                        <td>{{$moneda_nacional->simbolo}}. {{$precio_nacional[$index] }}</td>
                                        <td>{{$moneda_extranjera->simbolo}}. {{$precio_extranjero[$index]}}</td>
                                    {{-- data-all --}}
                                    @else
                                        <td>Sin stock</td>
                                        <td>{{$moneda_nacional->simbolo}}. 0.00</td>
                                        <td>{{$moneda_extranjera->simbolo}}. 0.00</td>
                                    @endif
                                    <td >{{$stock_producto->producto->codigo_producto}}</td>
                                    <td>{{$stock_producto->producto->descripcion}} </td>
                                    <td>{{$stock_producto->producto->garantia}} </td>
                                    <td>{{$stock_producto->producto->marcas_i_producto->nombre}}</td>
                                    {{-- data-all --}}

                                </tr>
                                
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <ul class="pagination float-right"></ul>
                                </td>
                            </tr>
                        </tfoot>
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
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
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
<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable2').footable();

    });

</script>
@endsection