@extends('layout')
@section('title', 'kardex Traslado Almacen')
{{-- @section('href_accion', route('kardex-entrada-Traslado-almacen.create'))
@section('value_accion', 'Agregar') --}}
@section('data-toggle', 'modal')
@section('href_accion', '#Modal_Select_Almacen')
@section('value_accion', 'Agregar')

@section('content')

<div class="modal fade" id="Modal_Select_Almacen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" >
            <div >
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center" onsubmit="return valida(this)">
                    <form action="{{route('kardex-entrada-Traslado-almacen.create')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group  row">
                           <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{ asset('/archivos/imagenes/kardex_img/2795451.svg')}}" width="150px"></div>
                           <label class="col-sm-4 col-form-label">Almacen Emisor:</label>
                           <div class="col-sm-6">
                            <select class="form-control" name="almacen" id="select">
                                @foreach($almacen as $almacenes)
                                <option value="{{$almacenes->id}}">{{$almacenes->nombre}}  </option>
                            </div>
                            @endforeach

                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" name="action" id="boton">Guardar</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>

<div >

    <div class="wrapper wrapper-content animated fadeInRight">
        @if (session('repite'))
        <div class="alert alert-danger">
            {{ session('repite') }}
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Codigo</th>
                                        <th>Almacen Emisor</th>
                                        <th>Almacen Receptor</th>
                                        <th>Ver</th>
                                        <th>Anular</th>
                                    </tr>
                                </thead>
                                <tbody><span hidden="hidden">{{$i=0}}</span>
                                 @foreach($kardex_distribucion as $kardex_distribuciones)
                                 <tr class="gradeX">
                                    <td> {{$i=$i+1}}</td>
                                    <td>{{$kardex_distribuciones->codigo_guia}}</td>
                                    <td>{{$kardex_distribuciones->almacen_emisor->nombre}}</td>
                                    <td>{{$kardex_distribuciones->almacen_receptor->nombre}}</td>
                                    <td><a href="{{ route('kardex-entrada-Traslado-almacen.show', $kardex_distribuciones->id) }}"><button type="button" class="btn btn-s-m btn-info">VER</button></a></td>
                                    <td><button class="btn btn-secondary">Anular</button></td>
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
@endsection