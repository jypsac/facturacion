@extends('layout')

@section('title', 'Categoria')
@section('breadcrumb', 'Categoria')
@section('breadcrumb2', 'Categoria')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')

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

                    <form action="{{ route('categoria.store') }}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <fieldset >
                            <legend> Agregar Categoría </legend>
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Descripcion:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="descripcion">
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
                                                                    <legend> Editar Categoría </legend>
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                                <label class="col-sm-2 col-form-label">Descripcion:</label>
                                                                                <div class="col-sm-10">
                                                                                    <input type="text" class="form-control" name="descripcion" value="{{$categoria->descripcion}}">
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

@endsection

