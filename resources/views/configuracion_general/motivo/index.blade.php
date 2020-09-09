@extends('layout')

@section('title', 'Motivos')
@section('breadcrumb', 'Motivos')
@section('breadcrumb2', 'Motivos')
@section('href_accion', route('motivo.create'))
@section('value_accion', 'Agregar')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
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
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Fecha de creacion</th>
                                <th>Fecha de creacion</th>
                                <th>EDITAR</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                    <tbody>
                         @foreach($motivos as $motivo)
                            <tr class="gradeX">
                                <td>{{$motivo->id}}</td>
                                <td>{{$motivo->nombre}}</td>
                                <td>{{$motivo->created_at}}</td>
                                <td>{{$motivo->updated_at}}</td>
                                <td><center><a href="{{ route('motivo.edit', $motivo->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td>
                                <td>
                                    <center>
                                        <form action="{{ route('motivo.destroy', $motivo->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-s-m btn-danger">Eliminar</button>
                                        </form>
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