@extends('layout')

@section('title', 'Categoria')
@section('breadcrumb', 'Categoria')
@section('breadcrumb2', 'Categoria')
@section('href_accion' ,route('categoria.create'))
@section('value_accion', 'agregar')
@section('content')

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
                                                <th>EDITAR</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($categorias as $categoria)
                                            <tr class="gradeX">
                                                <td>{{$categoria->id}}</td>
                                                <td>{{$categoria->codigo}}</td>
                                                <td>{{$categoria->descripcion}}</td>

                                                <td><center><a href="{{ route('categoria.edit', $categoria->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td>
                                                <td>
                                                    <center>
                                                        <form action="{{ route('categoria.destroy', $categoria->id)}}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-s-m btn-danger">Eliminar</button>
                                                        </form>
                                                    </center>
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

