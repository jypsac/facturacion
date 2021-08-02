@extends('layout')

@section('title', 'Categoria')
@section('breadcrumb', 'Categoria')
@section('breadcrumb2', 'Categoria')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')
@section('button2', 'Inicio')
@section('config',route('Configuracion'))

<!-- Modal Create  -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('categoria.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <fieldset >
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                        <label class="col-sm-2 col-form-label">Descripcion:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="descripcion">
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
                    <h5>Categorias</h5>
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
                                    <th>codigo</th>
                                    <th>Descripcion</th>
                                    <th>Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr class="gradeX">
                                    <td>{{$categoria->id}}</td>
                                    <td>{{$categoria->codigo}}</td>
                                    <td>{{$categoria->descripcion}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$categoria->id}}">Editar</button>
                                        <div class="modal fade" id="exampleModal{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                                                            <form action="{{ route('categoria.update',$categoria->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                             <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                                                             <label class="col-sm-3 col-form-label">Descripcion:</label>
                                                                             <div class="col-sm-9">
                                                                                <input type="text" class="form-control" readonly="readonly" value="{{$categoria->descripcion}}">
                                                                            </div>
                                                                            <label class="col-sm-3 col-form-label">Activo/desactivo:</label>
                                                                            <div class="col-sm-3">
                                                                                 @if($categoria->estado == 0)
                                                                                 @if($conteo == 1)
                                                                                <div class="switch-button">
                                                                                    <input type="text" name="estado" value="on" hidden="hidden">
                                                                                    <input type="checkbox" name="estado" id="switch-label{{$categoria->id}}" class="switch-button__checkbox" checked="" disabled="disabled" >
                                                                                    <label for="switch-label{{$categoria->id}} " class="switch-button__label " ></label>
                                                                                </div>
                                                                                @elseif($conteo >1)
                                                                             <div class="switch-button">
                                                                                    <input type="checkbox" name="estado" id="switch-label{{$categoria->id}}" class="switch-button__checkbox" checked="" >
                                                                                    <label for="switch-label{{$categoria->id}}" class="switch-button__label"></label>
                                                                                </div>
                                                                            @endif

                                                                        @elseif($categoria->estado == 1)
                                                                            <div class="switch-button">
                                                                                <input type="checkbox" name="estado" id="aswitch-label{{$categoria->id}}" class="switch-button__checkbox" >
                                                                                <label for="aswitch-label{{$categoria->id}}" class="switch-button__label"></label>
                                                                            </div>
                                                                        @endif

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </fieldset>
                                                            <button class="btn btn-primary" type="submit" >Grabar</button>
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

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script>

    $(document).ready(function () {

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '200px'
        })

    });

</script>
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

