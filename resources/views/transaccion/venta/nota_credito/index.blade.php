@extends('layout')

@section('title', 'Nota Credito')
@section('breadcrumb', 'Nota Credito')
@section('breadcrumb2', 'Nota Credito')
@section('href_accion', route('nota-credito.create'))
@section('value_accion', 'Agregar')

@section('content')
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
                                    <th>Codigo de Guia</th>
                                    <th>Cliente</th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha emision</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notas_creditos as $nota_credito)
                                <tr class="gradeX">
                                    <td>{{$nota_credito->id}}</td>
                                    <td>{{$nota_credito->cod_guia}}</td>
                                    <td>{{$nota_credito->cliente->nombre}}</td>
                                    <td>{{$nota_credito->cliente->numero_documento}}</td>
                                    <td>{{$nota_credito->fecha_emision}}</td>
                                    <td><center><a href="{{route('nota-credito-create-nc' , $nota_credito->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
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
            buttons: []

        });

    });

</script>
@endsection
