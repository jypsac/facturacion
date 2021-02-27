@extends('layout')

@section('title', 'Provedor')
@section('breadcrumb', 'Provedor')
@section('breadcrumb2', 'Provedor')
@section('href_accion', route('provedor.create'))
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
                       <table class="footable table table-stripped toggle-arrow-tiny">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>RUC</th>
                                <th>Empresa</th>
                                <th>Direccion</th>
                                <th>Telefonos</th>
                                <th>Correo</th>
                                <th>editar</th>
                                <th data-hide="all">RUC / Nombre Empresa / Direccion</th>
                                <th data-hide="all">Telefono / Email</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($provedores as $provedor)
                            <form action="{{ route('provedor.update',$provedor->id) }}"  enctype="multipart/form-data" method="post">
                                @csrf
                                @method('PATCH')
                                <tr class="gradeX">
                                    <td>{{$provedor->id}}</td>
                                    <td>{{$provedor->ruc}}</td>
                                    <td>{{$provedor->empresa}}</td>
                                    <td>{{$provedor->direccion}}</td>
                                    <td>{{$provedor->telefonos}}</td>
                                    <td>{{$provedor->email_provedor}}</td>
                                    <td><center><a href="{{ route('provedor.show', $provedor->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>

                                    <td>
                                        <div class="row">
                                            <div class="col-lg-4"><input class="form-control" name="ruc" value="{{$provedor->ruc}}" type="text"></div>
                                            <div class="col-lg-4"><input class="form-control" name="empresa" value="{{$provedor->empresa}}" type="text"></div>
                                            <div class="col-lg-4"><input class="form-control" name="direccion" value="{{$provedor->direccion}}" type="text"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-4"><input class="form-control" name="telefonos" value="{{$provedor->telefonos}}" type="text"></div>
                                            <div class="col-lg-4"><input class="form-control" name="email_provedor" value="{{$provedor->email_provedor}}" type="text"></div>
                                            <div class="col-lg-4"><input type="submit" value="enviar"><button type="submit" class="btn btn-primary">Enviar</button></div>
                                        </div>
                                    </td>
                                    <td><input type="submit"></td>
                                </tr>
                                {{-- <button type="submit" class="btn btn-primary">Enviar</button> --}}
                            </form>
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

<!-- FooTable -->
<script src="js/plugins/footable/footable.all.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable2').footable();

    });

</script>


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