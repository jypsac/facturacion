@extends('layout')

@section('title', 'Guia de remision')
@section('breadcrumb', 'Guia de remision')
@section('breadcrumb2', 'Guia de remision')

@section('content')
<span hidden="">{{$i=1}}{{$a=1}}</span>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                @if(Session::has('successMsg'))
                <div class="ibox-content">
                    <div class="alert alert-success">
                     <b> {{ session('successMsg') }}.</b>
                    </div>
                </div>
                @endif
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li><a class="nav-link active show" data-toggle="tab" href="#tab-1">Por Enviar</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-2">Enviados</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#tab-3">Anulados</a></li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active show">
                            <div class="panel-body">

                             <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Codigo de Guia</th>
                                            <th>Fecha emision</th>
                                            <th>Fecha entrega</th>
                                            <th>Tipo Transporte</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($guia_remisiones as $guia_remision)
                                        <tr class="gradeX">
                                            <td>{{$a++}}</td>
                                            <td>{{$guia_remision->cod_guia}}</td>
                                            <td>{{$guia_remision->fecha_emision}}</td>
                                            <td>{{$guia_remision->fecha_entrega}}</td>

                                            @if($guia_remision->tipo_transporte==0)
                                            <td>Sin Trasporte</td>
                                            @elseif($guia_remision->tipo_transporte==1)
                                            <td>Trasporte Publico</td>
                                            @else
                                            <td>Trasporte Privado</td>
                                            @endif
                                            <td>
                                                <center>
                                                    <form action="{{route('facturacion_electronica.guia_remision_sunat')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="factura_id" value="{{$guia_remision->id}}">
                                                        <button type="submit" class="btn btn-w-m btn-primary">Enviar</button>
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
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                         <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Codigo de Guia</th>
                                            <th>Fecha emision</th>
                                            <th>Fecha entrega</th>
                                            <th>Tipo Transporte</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($guia_remision_enviados as $guia_remision)
                                        <tr class="gradeX">
                                            <td>{{$i++}}</td>
                                            <td>{{$guia_remision->cod_guia}}</td>
                                            <td>{{$guia_remision->fecha_emision}}</td>
                                            <td>{{$guia_remision->fecha_entrega}}</td>

                                            @if($guia_remision->tipo_transporte==0)
                                            <td>Sin Trasporte</td>
                                            @elseif($guia_remision->tipo_transporte==1)
                                            <td>Trasporte Publico</td>
                                            @else
                                            <td>Trasporte Privado</td>
                                            @endif
                                            <td>
                                                <center>
                                                    <form action="{{route('facturacion_electronica.guia_remision_baja_sunat')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="factura_id" value="{{$guia_remision->id}}">
                                                        <button type="submit" class="btn btn-w-m btn-danger">Anular</button>
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
                    <div role="tabpanel" id="tab-3" class="tab-pane">
                        <div class="panel-body">
                           <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Codigo de Guia</th>
                                            <th>Fecha emision</th>
                                            <th>Fecha entrega</th>
                                            <th>Tipo Transporte</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($guia_remision_anulado as $guia_remision)
                                        <tr class="gradeX">
                                            <td>{{$i++}}</td>
                                            <td>{{$guia_remision->cod_guia}}</td>
                                            <td>{{$guia_remision->fecha_emision}}</td>
                                            <td>{{$guia_remision->fecha_entrega}}</td>
                                            @if($guia_remision->tipo_transporte==0)
                                            <td>Sin Trasporte</td>
                                            @elseif($guia_remision->tipo_transporte==1)
                                            <td>Trasporte Publico</td>
                                            @else
                                            <td>Trasporte Privado</td>
                                            @endif
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
            buttons: []
        });
    });
</script>
@endsection