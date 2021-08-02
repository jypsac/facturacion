@extends('layout')

@section('title', 'Moneda')
@section('breadcrumb', 'Moneda')
@section('breadcrumb2', 'Moneda')
@if($cantidad_monedas==2)
@else
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@endif
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

@section('content')

<!-- Modal Create  -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> moneda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('moneda.store') }}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <fieldset >
                            <legend> Agregar Moneda </legend>
                            <div>
                                <div class="panel-body" >
                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombres:</label>
                                       <div class="col-sm-10"><input type="text" class="form-control" name="nombre"></div>
                                   </div>

                                   <div class="form-group  row"><label class="col-sm-2 col-form-label">Simbolo:</label>
                                       <div class="col-sm-10"><input type="text" class="form-control" name="simbolo"></div>
                                   </div>

                                   <div class="form-group  row"><label class="col-sm-2 col-form-label">Codigo:</label>
                                       <div class="col-sm-10"><input type="text" class="form-control" name="codigo"></div>
                                   </div>

                                   <div class="form-group row"><label class="col-sm-2 col-form-label">Seleccionar Pais:</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="pais">
                                            <option>Seleccione</option>
                                            @foreach($paises as $pais)
                                            <option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>
                                            @endforeach
                                        </select>
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
<!-- / Modal Create  -->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Monedas</h5>
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
                                    <th>Simbolo</th>
                                    <th>Codigo</th>
                                    <th>Moneda Nacional/Extanjera</th>
                                    <th>Moneda Principal</th>
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moneda as $monedas)
                                <tr class="gradeX">
                                    <td>{{$monedas->id}}</td>
                                    <td>{{$monedas->nombre}}</td>
                                    <td>{{$monedas->simbolo}}</td>
                                    <td>{{$monedas->codigo}}</td>
                                    <td>Moneda {{$monedas->tipo}}</td>
                                    <td>@if($monedas->principal == 1)
                                      Si
                                      @else
                                      No
                                      @endif
                                  </td>
                                  <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$monedas->id}}">Editar</button>
                                    <div class="modal fade" id="exampleModal{{$monedas->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"> Edit Categoría</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                    {{-- ccccccccccccccccc --}}
                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                        <form action="{{ route('moneda.update',$monedas->id) }}"  enctype="multipart/form-data" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                            <fieldset >
                                                                <div>
                                                                    <div class="panel-body" >
                                                                        <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/moneda.svg')}}" width="100px"> <br><h3> Moneda {{$monedas->tipo}}</h3></div>

                                                                        <div class="form-group  row">
                                                                            <label class="col-sm-2 col-form-label">Nombres:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="nombre" value="{{$monedas->nombre}}" readonly="">
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Simbolo:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="simbolo" value="{{$monedas->simbolo}}" readonly="">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group  row">
                                                                            <label class="col-sm-2 col-form-label">Codigo:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="codigo" value="{{$monedas->codigo}}" readonly="" >
                                                                            </div>

                                                                            <label class="col-sm-2 col-form-label">Moneda Principal:</label>
                                                                            <div class="col-sm-4">
                                                                                @if($monedas->principal == 0)
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="principal" id="switch-label1" class="switch-button__checkbox" >
                                                                                    <label for="switch-label1" class="switch-button__label"></label>
                                                                                </div>
                                                                                @else
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="principal" id="switch-labels" class="switch-button__checkbox" checked="">
                                                                                    <label for="switch-label" class="switch-button__label"></label>
                                                                                </div>
                                                                                @endif
                                                                            </div>

                                                                        </div>

                                                                        <div class="form-group row"><label class="col-sm-2 col-form-label">Seleccionar Pais:</label>
                                                                            <div class="col-sm-10">
                                                                                <input class="form-control" readonly="" value="{{$monedas->pais}}">
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
                                    <!-- / Modal Create  -->

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
<style type="text/css" media="screen">
    :root {
        --color-button: #fdffff;
    }
    .switch-button {
        display: inline-block;
        padding-top: 9px;
        padding-right: 30px;
    }
    .switch-button .switch-button__checkbox {
        display: none;
    }
    .switch-button .switch-button__label {
        background-color:#1f1f1f66;
        width: 2rem;
        height: 1rem;
        border-radius: 3rem;
        display: inline-block;
        position: relative;
    }
    .switch-button .switch-button__label:before {
        transition: .6s;
        display: block;
        position: absolute;
        width: 1rem;
        height: 1rem;
        background-color: var(--color-button);
        content: '';
        border-radius: 50%;
        box-shadow: inset 0px 0px 0px 1px black;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label {
        background-color: #1c84c6;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
        transform: translateX(1rem);
    }
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