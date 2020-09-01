@extends('layout')

@section('title', 'Guia Remision')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
@section('href_accion', route('guia_remision.seleccionar'))
@section('value_accion', 'Agregar')

@section('content')
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
                                    <th>Codigo de Guia</th>
                                    <th>Cliente</th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha emision</th>
                                    <th>Ver</th>
                                    <!-- <th>EDITAR</th> -->
                                    <th>Anular</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guia_remision as $guias_remision)
                                <tr class="gradeX">
                                    <td>{{$guias_remision->id}}</td>
                                    <td>{{$guias_remision->cod_guia}}</td>
                                    <td>{{$guias_remision->cliente->nombre}}</td>
                                    <td>{{$guias_remision->cliente->numero_documento}}</td>
                                    <td>{{$guias_remision->fecha_emision}}</td>
                                    <td><center><a href="{{route('guia_remision.show' , $guias_remision->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                    <td>
                                      @if($guias_remision->estado_anulado == '0')
                                      <!-- Button trigger modal -->
                                      <button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#1">
                                         Anular
                                     </button>

                                     <!-- Modal -->
                                     <div class="modal fade" id="1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                         <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
                                            <div class="modal-content" >
                                                <div class="modal-body" style="padding: 0px;">

                                                 <div class="ibox-content float-e-margins">

                                                   <h3 class="font-bold col-lg-12" align="center">
                                                      ¿Esta Seguro que Deseas Anular la Guia de remision: ".?<br>
                                                      <h4 align="center"> <strong>Nota: Una vez Anulado no hay opcion de devolver la accion </strong></h4>
                                                  </h3>
                                                  <p align="center">
                                                    <form action="{{route('guia_remision.destroy', $guias_remision->id)}}" method="POST">
                                                      @csrf
                                                      @method('delete')
                                                      <center>
                                                        <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                                                        {{-- <button type="button" class="btn btn-w-m btn-danger" data-dismiss="modal">Cancelar</button> --}}</center>
                                                    </form>

                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @elseif($guias_remision->estado_anulado == '1')
                            <button type="button" class="btn btn-secondary" >Anulado</button>
                            @endif
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
