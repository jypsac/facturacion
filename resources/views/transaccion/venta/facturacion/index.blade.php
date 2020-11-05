@extends('layout')
@section('title', 'Facturacion')
@section('breadcrumb', 'Facturacion')
@section('breadcrumb2', 'Facturacion')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')
@section('content')
<!-- modal -->
<div class="row">
    <div class="col-lg-12">
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" align="center">
                            <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Facturacion</h3>
                            </div>
                            <!--Producto-->
                            <div class="col-sm-6">
                                @if($conteo_almacen==1)
                                <form action="{{ route('facturacion.create')}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
                                    <input class="btn btn-sm btn-info"  type="submit" value="Producto" >
                                </form>
                                @else
                                @if($user_login->name=='Administrador')
                                <div class="dropdown">
                                  <button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Productos</button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <form action="{{ route('facturacion.create')}}"enctype="multipart/form-data" method="post">
                                        @csrf
                                        @foreach($almacen as $almacens)
                                        <input type="submit" class="dropdown-item" name="almacen"  value="{{$almacens->id}} - {{$almacens->nombre}}">
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                            @elseif($user_login->name=='Colaborador')
                            <form action="{{ route('facturacion.create')}}"enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="text"  hidden="hidden" name="almacen"  value="{{$user_login->almacen_id}}">
                                <input type="submit" class="btn btn-sm btn-info"  value="Producto">
                            </form>
                            @endif
                            @endif
                        </div>
                        <!--Servicios-->
                        <div class="col-sm-6">
                                    {{-- <form action="{{ route('facturacion_servicio.create')}}" enctype="multipart/form-data"  method="post">
                                        @csrf
                                        <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
                                        <input class="btn btn-sm btn-info"  type="submit" value="Servicio" >
                                    </form>  --}}

                                    <a href="{{ route('facturacion_servicio.create')}}"><button class="btn btn-sm btn-info" >Servicios</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- fimodal --}}
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">

                <div class="col-lg-12">
                    @if (session('repite'))
                    <div class="alert alert-danger">
                        {{ session('repite') }}
                    </div>
                    @endif
                    @if (session('campo'))
                    <div class="alert alert-success">
                        {{ session('campo') }}
                    </div>
                    @endif
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Creacion de cotizacion</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="fa fa-wrench"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li>
                                        <a href="#" class="dropdown-item">Config option 1</a>
                                    </li>
                                    <li>
                                        <a href="#" class="dropdown-item">Config option 2</a>
                                    </li>
                                </ul>
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
               {{--  <button type="button" id='myajax'>click me</button>
                <div id='msg'>
                        mensaje
                    </div> --}}
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Codigo de Factura</th>
                                        <th>Cliente</th>
                                        <th>Ruc/DNI</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>Ver</th>
                                        <th>Anular</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($facturacion as $facturacions)
                                    <tr class="gradeX">
                                        <td>{{$facturacions->id}}</td>
                                        <td>{{$facturacions->codigo_fac}}</td>


                                        @if(isset($facturacions->cliente_id)) <!-- Nombre del cliente -->
                                        <td>{{$facturacions->cliente->nombre}}</td>
                                        @else
                                        <td>{{$facturacions->cotizacion->cliente->nombre}}</td>
                                        @endif

                                        @if(isset($facturacions->cliente_id))<!-- documento del cliente -->
                                        <td>{{$facturacions->cliente->numero_documento}}</td>
                                        @else
                                        <td>{{$facturacions->cotizacion->cliente->numero_documento}}</td>
                                        @endif

                                        <td>{{$facturacions->fecha_vencimiento }}</td>
                                        <td>
                                            <center>
                                                @if($facturacions->tipo=='servicio')
                                                <a href="{{route('facturacion_servicio.show',$facturacions->id)}}">
                                                    <button type="button" class="btn btn-w-m btn-primary">VER SERVICIO</button>
                                                </a>
                                                @elseif($facturacions->tipo=='producto')
                                                <a href="{{route('facturacion.show',$facturacions->id)}}">
                                                    <button type="button" class="btn btn-w-m btn-primary">VER PRODUCTOSSSS</button>
                                                </a>
                                                @endif

                                            </center>
                                        </td>
                                        <td>
                                            @if($facturacions->estado == '0')
                                            <button type="button" class="btn btn-s-m btn-danger" data-toggle="modal" data-target="#{{$facturacions->id}}">Anular</button>
                                            <div class="modal fade" id="{{$facturacions->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
                                                    <div class="modal-content" >
                                                        <div class="modal-body" style="padding: 0px;">
                                                            <div class="ibox-content float-e-margins">
                                                                <h3 class="font-bold col-lg-12" align="center">
                                                                    ¿Esta Seguro que Deseas Anular la Factura: {{$facturacions->codigo_fac}}".?
                                                                    <br>
                                                                    <h4 align="center">
                                                                        <strong>Nota: Una vez Anulado no hay opcion de devolver la accion </strong>
                                                                    </h4>
                                                                </h3>
                                                                <p align="center">
                                                                    <form action="{{ route('facturacion.destroy', $facturacions->id)}}" method="POST">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <center>
                                                                            <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                                                                        </center>
                                                                    </form>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @elseif($facturacions->estado == '1')
                                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal123">Anulado</button>
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

    {{-- ESTILOS --}}
    <style type="text/css">
        .a{width: 200px}
    </style>

    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Page Scripts -->
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

        $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
       });

        $('#myajax').click(function(){
       //we will send data and recive data fom our AjaxController
       $.ajax({
          url:'/facturacion/create/ajax',
          data:{'name':"luis"},
          type:'post',
          success: function (response) {
            $("#msg").html(response.msg);
        },
        statusCode: {
           404: function() {
            alert('web not found');
        }
    },
    error:function(x,xs,xt){
              //nos dara el error si es que hay alguno
              window.open(JSON.stringify(x));
              //alert('error: ' + JSON.stringify(x) +"\n error string: "+ xs + "\n error throwed: " + xt);
          }
      });
   });

</script>
@endsection
