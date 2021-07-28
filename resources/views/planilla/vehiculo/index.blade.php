@extends('layout')

@section('title', 'Vehiculos')
@section('breadcrumb', 'Vehiculos')
@section('breadcrumb2', 'Vehiculos')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')

<!-- Modal Create  -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Vehiculo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('vehiculo.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)"
>
                        @csrf
                        <fieldset >
                            <legend> Agregar Vehiculo </legend>
                            <div>
                                <div class="panel-body" >
                                    <div class="form-group  row">
                                        <div class="col-sm-12"><img src="{{asset('img/logos/camion.svg')}}" width="100px"></div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Placa:</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" name="placa" required="" placeholder="AT4-234"></div>
                                        <label class="col-sm-2 col-form-label">Marca:</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" name="marca"  required="" placeholder="Toyota"></div>

                                    </div>

                                    <div class="form-group  row">
                                        <label class="col-sm-2 col-form-label">Modelo:</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" required="" name="modelo" placeholder="RAV4"></div>

                                        <label class="col-sm-2 col-form-label">Año:</label>
                                        <div class="col-sm-4"><input type="text" class="form-control" required="" name="año" placeholder="2020"></div>
                                    </div>
                                    <div class="form-group  row">
                                        <label class="col-sm-3 col-form-label">Certificado de Inscripcion:</label>
                                        <div class="col-sm-9"><input type="text" class="form-control" required="" name="certificado_inscripcion" ></div>
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
                                    <th>ITEM</th>
                                    <th>Placa</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Año</th>
                                    <th>Certificado</th>
                                    <th>Activo/desactivo</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehiculo as $vehiculos)
                                <tr>
                                 <td>{{$vehiculos->id}}</td>
                                 <td>{{$vehiculos->placa}}</td>
                                 <td>{{$vehiculos->marca}}</td>
                                 <td>{{$vehiculos->modelo}}</td>
                                 <td>{{$vehiculos->año}}</td>
                                 <td>{{$vehiculos->certificado_inscripcion}}</td>
                                 <td>
                                    @if($vehiculos->estado_activo==0)Activo
                                    @elseif($vehiculos->estado_activo==1)Desactivado
                                    @endif
                                 </td>
                                 <td><a href="#exampleModal{{$vehiculos->id}}" data-toggle="modal" class="btn btn-info">Editar</a>

                                    <!-- Modal Create  -->

                                    <div class="modal fade" id="exampleModal{{$vehiculos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"> Vehiculo</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                    {{-- ccccccccccccccccc --}}
                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                       <form action="{{route('vehiculo.update',$vehiculos->id)}}"  enctype="multipart/form-data" method="post">
                                                        @csrf
                                                        @method('PATCH')
                                                        <fieldset >
                                                            <legend> Agregar Vehiculo </legend>
                                                            <div>
                                                                <div class="panel-body" >
                                                                    <div class="form-group  row">
                                                                        <div class="col-sm-12"><img src="{{asset('img/logos/camion.svg')}}" width="100px"></div>
                                                                    </div>
                                                                    <div class="form-group  row">
                                                                        <label class="col-sm-2 col-form-label">Placa:</label>
                                                                        <div class="col-sm-4"><input type="text" class="form-control" name="placa" value="{{$vehiculos->placa}}" placeholder="AT4-234"></div>
                                                                        <label class="col-sm-2 col-form-label">Marca:</label>
                                                                        <div class="col-sm-4"><input type="text" class="form-control" name="marca" value="{{$vehiculos->marca}}" placeholder="Toyota"></div>
                                                                    </div>

                                                                    <div class="form-group  row">
                                                                        <label class="col-sm-2 col-form-label">Modelo:</label>
                                                                        <div class="col-sm-4"><input type="text" class="form-control" name="modelo" value="{{$vehiculos->modelo}}" placeholder="RAV4"></div>

                                                                        <label class="col-sm-2 col-form-label">Año:</label>
                                                                        <div class="col-sm-4"><input type="text" class="form-control" name="año" value="{{$vehiculos->año}}" placeholder="2020"></div>
                                                                    </div>
                                                                    <div class="form-group  row">
                                                                        <label class="col-sm-3 col-form-label">Certificado de Inscripcion:</label>
                                                                        <div class="col-sm-9"><input type="text" class="form-control" required="" value="{{$vehiculos->certificado_inscripcion}}" name="certificado_inscripcion" ></div>
                                                                    </div>
                                                                    <div class="form-group  row">
                                                                         <div class="col-sm-6" align="right">
                                                                      <label class="col-form-label">Activo/desactivo:</label></div>
                                                                      <div class="col-sm-6" align="left">
                                                                        @if($vehiculos->estado_activo == 0)
                                                                        <div class="switch-button">
                                                                            <input type="checkbox" name="estado_activo" id="switch-label{{$vehiculos->id}}" class="switch-button__checkbox" checked="">
                                                                            <label for="switch-label{{$vehiculos->id}}" class="switch-button__label"></label>
                                                                        </div>
                                                                        @else
                                                                        <div class="switch-button">
                                                                            <input type="checkbox" name="estado_activo" id="aswitch-label{{$vehiculos->id}}" class="switch-button__checkbox" >
                                                                            <label for="aswitch-label{{$vehiculos->id}}" class="switch-button__label"></label>
                                                                        </div>
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
<style>
    .form-control{border-radius: 5px}
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
