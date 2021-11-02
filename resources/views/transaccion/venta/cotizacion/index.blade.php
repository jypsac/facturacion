@extends('layout')

@section('title', 'Cotizacion')
@section('breadcrumb', 'Cotizacion')
@section('breadcrumb2', 'Cotizacions')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')
@section('content')

<!-- modal -->
@if($errors->any())
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li class="error" style="color: red">{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif
<div class="row">
    <div class="col-lg-12">
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" align="center">
                            <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Cotizacion</h3>
                            </div>
                            <!--FACTURA-->
                            <div class="col-sm-6">
                                @if($conteo_almacen==1)
                                <form action="{{ route('cotizacion.create_factura')}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
                                    <input class="btn btn-sm btn-info"  type="submit" value="Crear una cotizacion factura" >
                                </form>
                                @else
                                @if($user_login->name=='Administrador')
                                <div class="dropdown ">
                                  <button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Factura</button>
                                  <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
                                    @foreach($almacen as $almacens)
                                    <form action="{{ route('cotizacion.create_factura')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="hidden" class="dropdown-item" name="almacen"  value="{{$almacens->id}}">
                                        <input type="submit" class="dropdown-item" value="{{$almacens->nombre}}">
                                    </form>
                                    @endforeach
                                </div>
                            </div>
                            @elseif($user_login->name=='Colaborador')
                            <form action="{{ route('cotizacion.create_factura')}}"enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="text"  hidden="hidden" name="almacen"  value="{{$user_login->almacen_id}}">
                                <input type="submit" class="btn btn-sm btn-info"  value="Crear una cotizacion factura">
                            </form>
                            @endif
                            @endif
                        </div>
                        <!--BOLETA-->
                        <div class="col-sm-6">
                            @if($conteo_almacen==1)
                            <form action="{{ route('cotizacion.create_boleta')}}" enctype="multipart/form-data"  method="post">
                                @csrf
                                <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
                                <input class="btn btn-sm btn-info"  type="submit" value="Crear cotizacion boleta" >
                            </form>
                            @else
                            @if($user_login->name=='Administrador')
                            <div class="dropdown">
                              <button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Boleta</button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <form action="{{ route('cotizacion.create_boleta')}}"enctype="multipart/form-data" method="post">
                                    @csrf
                                    @foreach($almacen as $almacens)
                                    <input type="submit" class="dropdown-item" name="almacen"  value="{{$almacens->id}} - {{$almacens->nombre}}">
                                    @endforeach
                                </form>
                            </div>
                        </div>
                        @elseif($user_login->name=='Colaborador')
                        <form action="{{ route('cotizacion.create_boleta')}}"enctype="multipart/form-data" method="post">
                            @csrf
                            <input type="text"  hidden="hidden" name="almacen"  value="{{$user_login->almacen_id}}">
                            <input type="submit" class="btn btn-sm btn-info"  value="Crear cotizacion boleta">
                        </form>
                        @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
{{-- fimodal --}}
<style> .dropdown-menu{left: 70px; padding: 20px 0;}</style>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>N° Cotizacion</th>
                                    <th>Ruc/DNI</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Ver</th>
                                    <th>Estado</th>
                                    <th>Estado Aprobado</th>
                                    <th>Creado por</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizacion as $cotizacions)
                                <tr class="gradeX">
                                    <td>{{$cotizacions->id}}</td>
                                    <td>{{$cotizacions->cod_cotizacion}}</td>
                                    <td>{{$cotizacions->cliente->numero_documento}}</td>
                                    <td>{{$cotizacions->cliente->nombre}}</td>
                                    <td>{{$cotizacions->created_at}}</td>
                                    <td><center><a href="{{route('cotizacion.show',$cotizacions->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                    <td>
                                        @if($cotizacions->estado =='0')

                                        <button type="button" class="btn btn-w-m btn-info">En Proceso</button>

                                        @else
                                        <button type="button" class="btn btn-w-m btn-default">Procesado</button>
                                        @endif
                                    </td>

                                    <td>
                                        @if($cotizacions->estado_aprovar =='0')

                                        <form action="{{ route('cotizacion.aprobar', $cotizacions->id)}}" method="POST">
                                          @csrf
                                          @method('put')
                                          <center>
                                           <button type="submit" class="btn btn-w-m btn-info">Aprobar</button>
                                       </form>

                                       @else
                                       <button type="button" class="btn btn-w-m btn-default">Aprobado por <br>
                                         @if($cotizacions->aprobado->personal->nombres==auth()->user()->personal->nombres)
                                         usted
                                         @else
                                         {{$cotizacions->aprobado->personal->nombres}}
                                         @endif
                                     </button>
                                     @endif
                                 </td>
                                 <td>
                                   @if($cotizacions->user_personal->personal->nombres==auth()->user()->personal->nombres)
                                   Creado por usted
                                   @else
                                   Creado por  {{$cotizacions->user_personal->personal->nombres}}
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
