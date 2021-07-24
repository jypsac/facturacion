@extends('layout')

@section('title', 'Cliente')
@section('breadcrumb', 'Cliente')
@section('breadcrumb2', 'Cliente')
@section('data-toggle', 'modal')
@section('href_accion', '#ModalCliente')
@section('value_accion', 'Agregar')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('content')
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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 13px" id="table_cliente" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Nro Documento</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                          {{--   <tbody>
                                @foreach($clientes as $cliente)
                                <tr class="gradeX">
                                    <td>{{$cliente->id}}</td>
                                    <td>{{$cliente->nombre}}</td>
                                    <td>{{$cliente->documento_identificacion}}</td>
                                    <td>{{$cliente->numero_documento}}</td>
                                    <td>{{$cliente->email}}</td>
                                    <td>{{$cliente->celular}}</td>
                                    <td><center><a href="{{ route('cliente.show', $cliente->id) }}" target="_blank"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
                                </tr>

                                @endforeach
                            </tbody> --}}
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

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
{{-- scritp de modal agregar --}}

    <!-- Page-Level Scripts -->
<script>
$(document).ready(function(){
    $('#table_cliente').DataTable({
        "serverSide":true,
        "ajax":"{{url('api/clientes')}}",
        "columns":[
            {data : 'id'},
            {data : 'nombre'},
            {data : 'documento_identificacion'},
            {data : 'numero_documento'},
            {data : 'email'},
            {data : 'celular'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<a href="{{ route('cliente.show',':id') }}" target="_blank"><span class="btn btn-success" >VER</span></a>';
                    return actions.replace(/:id/g, data.id);
                }
            }
        ]
    });
});

</script>


    @endsection