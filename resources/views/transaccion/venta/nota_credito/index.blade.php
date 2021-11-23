@extends('layout')

@section('title', 'Nota Credito')
@section('breadcrumb', 'Nota Credito')
@section('breadcrumb2', 'Nota Credito')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')

<div class="col-lg-12">
    <div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" align="center">
                        <!--FACTURA-->
                        <div class="col-sm-6">
                            <a href="{{route('nota-credito.create')}}"><button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" >Factura</button></a> 
                        </div>
                        <!--BOLETA-->
                        <div class="col-sm-6">
                            <a href="{{route('nota-credito.create_boleta')}}"><button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" >Boleta</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DOC</th>
                                    <th>Tipo</th>
                                    <th>Fecha emision</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($notas_creditos as $nota_credito)
                                <tr class="gradeX">
                                    <td>{{$nota_credito->id}}</td>
                                    <td>
                                        @if($nota_credito->facturacion_id==NULL)
                                            Boleta
                                        @else
                                            Factura
                                        @endif
                                    </td>
                                    <td>{{$nota_credito->tipo}}</td>
                                    <td>{{$nota_credito->created_at}}</td>
                                    <td><a href="{{route('nota-credito.show',$nota_credito->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></td>
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
