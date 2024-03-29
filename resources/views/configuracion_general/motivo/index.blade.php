@extends('layout')

@section('title', 'Motivos')
@section('breadcrumb', 'Motivos')
@section('breadcrumb2', 'Motivos')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

@section('content')

<!-- Modal Create  -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Motivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('motivo.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <fieldset >
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                       <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/motivo.svg')}}" width="100px"></div>
                                       <label class="col-sm-2 col-form-label">Nombre:</label>
                                       <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nombre">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <button class="btn btn-primary" type="submit" id="boton">Grabar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- / Modal Create  -->
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
                                    <th>Fecha de Modificacion</th>
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                             @foreach($motivos as $motivo)
                             <tr class="gradeX">
                                <td>{{$motivo->id}}</td>
                                <td>{{$motivo->nombre}}</td>
                                <td>{{$motivo->created_at}}</td>
                                <td>{{$motivo->updated_at}}</td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$motivo->id}}">Editar</button>
                                    <div class="modal fade" id="exampleModal{{$motivo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"> Edit Motivo</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                    {{-- ccccccccccccccccc --}}
                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                        <form action="{{ route('motivo.update',$motivo->id) }}"  enctype="multipart/form-data" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <fieldset >
                                                                <div>
                                                                    <div class="panel-body" >
                                                                        <div class="row">
                                                                           <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/motivo.svg')}}" width="100px"></div>
                                                                           <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                           <div class="col-sm-10">
                                                                            @if($motivo->created_at==$motivo->updated_at)
                                                                            <input type="text" class="form-control" value="{{$motivo->nombre}}" name="nombre">
                                                                            @else
                                                                            <input type="text" class="form-control" value="{{$motivo->nombre}}" name="nombre" readonly="readonly">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </fieldset>
                                                        <button class="btn btn-primary" type="submit">Grabar</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / Modal Create  --></td>
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
{{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
           { alert(incompleto); }
       else{boton.type = 'button';}
   }
</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
@endsection