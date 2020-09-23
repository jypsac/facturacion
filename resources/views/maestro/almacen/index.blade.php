    @extends('layout')

    @section('title', 'Almacen')
    @section('breadcrumb', 'Almacen')
    @section('breadcrumb2', 'Almacen')
    @section('data-toggle', 'modal')
    @section('href_accion', '#exampleModal')
    @section('value_accion', 'Agregar')

    @section('content')

    <!-- Modal Create  -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="margin-left: 450px;">
            <div class="modal-content" style="width: 702px;">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Categoría</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="padding-left: 15px;padding-right: 15px;">
                    {{-- ccccccccccccccccc --}}
                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                        <form action="{{route('almacen.store')}}"  enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="form-group  row">
                                <label class="col-sm-2 col-form-label">Nombre:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="nombre">
                                </div>

                                <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="abreviatura">
                                </div>

                                <label class="col-sm-2 col-form-label">Responsable:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="responsable">
                                </div>

                                <label class="col-sm-2 col-form-label">Dirección:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="direccion">
                                </div>

                                <label class="col-sm-2 col-form-label">Descripcion:</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="descripcion">
                                </div>
                            </div>

                            <button class="btn btn-primary" type="submit" name="action">Guardar</button>

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
                        <h5>Creacion de Almacen</h5>
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
                                        <th>Id</th>
                                        <th>Nombre</th>
                                        <th>Abreviatura</th>
                                        <th>Direccion</th>
                                        <th>Responsable</th>
                                        <th>Descripcion</th>
                                        <th>Activo/Desactivo</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($almacenes as $almacen)
                                    <tr class="gradeX">
                                        <td>{{$almacen->id}}</td>
                                        <td>{{$almacen->nombre}}</td>
                                        <td>{{$almacen->abreviatura}}</td>
                                        <td>{{$almacen->direccion}}</td>
                                        <td>{{$almacen->responsable}}</td>
                                        <td>{{$almacen->descripcion}}</td>
                                        <td>@if($almacen->estado==0)Activo @elseif($almacen->estado==1)Desactivo @endif</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$almacen->id}}">Editar</button>
                                            <div class="modal fade" id="exampleModal{{$almacen->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document"style="margin-left: 450px;">
                                                    <div class="modal-content" style="width: 702px;">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> Edit Categoría</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div style="padding-left: 15px;padding-right: 15px;">
                                                            {{-- ccccccccccccccccc --}}
                                                            <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                                <form action="{{route('almacen.update',$almacen->id)}}"  enctype="multipart/form-data" method="post">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Nombre:</label>
                                                                       <div class="col-sm-4"><input type="text" class="form-control" name="nombre" value="{{$almacen->nombre}}"></div>

                                                                       <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                                                       <div class="col-sm-4"><input type="text" class="form-control" name="abreviatura" value="{{$almacen->abreviatura}}"></div>

                                                                       <label class="col-sm-2 col-form-label">Responsable:</label>
                                                                       <div class="col-sm-4"><input type="text" class="form-control" name="responsable" value="{{$almacen->responsable}}"></div>

                                                                       <label class="col-sm-2 col-form-label">Dirección:</label>
                                                                       <div class="col-sm-4"><input type="text" class="form-control" name="direccion" value="{{$almacen->direccion}}"></div>

                                                                       <label class="col-sm-2 col-form-label">Descripcion:</label>
                                                                       <div class="col-sm-4"><input type="text" class="form-control" name="descripcion" value="{{$almacen->descripcion}}"></div>

                                                                       <label class="col-sm-2 col-form-label">Activo/desactivo:</label>
                                                                       <div class="col-sm-3">
                                                                        @if($almacen->estado == 0)
                                                                        <div class="switch-button">
                                                                            <input type="checkbox" name="estado" id="switch-label{{$almacen->id}}" class="switch-button__checkbox" checked="">
                                                                            <label for="switch-label{{$almacen->id}}" class="switch-button__label"></label>
                                                                        </div>
                                                                        @else
                                                                        <div class="switch-button">
                                                                            <input type="checkbox" name="estado" id="aswitch-label{{$almacen->id}}" class="switch-button__checkbox" >
                                                                            <label for="aswitch-label{{$almacen->id}}" class="switch-button__label"></label>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <button class="btn btn-primary" type="submit" name="action">Editar</button>
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
<style>
    .col-sm-4{padding-bottom: 10px}
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
