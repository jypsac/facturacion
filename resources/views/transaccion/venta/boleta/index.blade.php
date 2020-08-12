@extends('layout')
@section('title', 'Boleta')
@section('breadcrumb', 'Boleta')
@section('breadcrumb2', 'Boleta')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')
@section('content')

@section('content')
<!-- modal -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div id="modal-form" class="modal fade" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="row" align="center">
                                    <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Agregar</h3>
                                        <p>Selecciona el Tipo de Facturacion</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{ route('boleta.create') }}"><button class="btn btn-sm btn-primary" type="submit"><strong>Productos</strong></button></a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{ route('boleta_servicio.create') }}"><button class="btn btn-sm btn-primary" type="submit"><strong>Servicios</strong></button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
{{-- fimodal --}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Lista de Boletas</h5>
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
                                    <th>Cliente ID</th>
                                    <th>Forma de pago</th>
                                    <th>Fecha de emision</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Ver</th>
                                    {{-- <th>ANULAR</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boletas as $boleta)
                                <tr class="gradeX">
                                    <td>{{$boleta->id}}</td>
                                    <td>{{$boleta->cliente_id}}</td>
                                    <td>{{$boleta->forma_pago_id}}</td>
                                    <td>{{$boleta->fecha_emision}}</td>
                                    <td>{{$boleta->fecha_vencimiento }}</td>
                                    <td><center><a href="{{route('boleta.show',$boleta->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                    {{-- <td>
                                        @if($boleta->estado == '0')
                                             Button trigger modal
                                        <button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#{{$boleta->id}}">
                                           Anular
                                       </button>
                                               <div class="modal fade" id="{{$boleta->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                   <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
                                                    <div class="modal-content" >
                                                        <div class="modal-body" style="padding: 0px;">

                                                           <div class="ibox-content float-e-margins">

                                                             <h3 class="font-bold col-lg-12" align="center">
                                                              ¿Esta Seguro que Deseas Anular la Factura: {{$boleta->codigo_fac}}".?<br>
                                                              <h4 align="center"> <strong>Nota: Una vez Anulado no hay opcion de devolver la accion </strong></h4>
                                                          </h3>
                                                          <p align="center">
                                                             <form action="{{ route('facturacion.destroy', $boleta->id)}}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <center>
                                                                    <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                                                                     <button type="button" class="btn btn-w-m btn-danger" data-dismiss="modal">Cancelar</button> </center>
                                                                </form>

                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            @elseif($boleta->estado == '1')
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal123">Anulado</button>
                                            @endif
                                    </td> --}}

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


<style type="text/css">
    .a{width: 200px}
</style>



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
