@extends('layout')

@section('title', 'Guia Remision')
@section('breadcrumb', 'Guia Remision')
@section('breadcrumb2', 'Guia Remision')
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
                            <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Crear Guia Remision</h3>
                            </div>
                            <!-- <div class="col-sm-12"> -->
                               <!--  <a href="{{route('guia_remision.seleccionar') }}"><button class="btn btn-sm btn-info" type="submit"><strong>Ver Aprobadas</strong></button></a> -->
                            <!-- </div> -->
                            <div class="col-sm-12">
                                {{-- @if($conteo_almacen==1 and $user_login->name=='Administrador' ) --}}
                                @if($conteo_almacen==1 )
                                <form action="{{ route('guia_remision.create')}}" enctype="multipart/form-data" method="post">
                                    @csrf
                                    <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
                                    <input class="btn btn-sm btn-info"  type="submit" value="Crear una nueva Guia" >
                                </form>
                                {{-- @elseif($conteo_almacen==1 and $user_login->almacen->estado==1 and $user_login->name=='Colaborador' ) --}}
                                @elseif($conteo_almacen==1 and $user_login->almacen->estado==1  )
                                <input id="auto" onclick="divAuto()" type="submit" class="btn btn-sm btn-info"  value="Crear una Nueva Guia">
                                <div id="div-mostrar" style="color: black">
                                    <div id="texto" style="opacity:0;transition: .4s ;text-align: center;padding-top: 10px;" >Almacen Asignado esta Desactivado, Activelo o cambie de Almacen.</div>
                                </div>
                                {{-- @elseif($conteo_almacen==1 and $user_login->almacen->estado==0 and $user_login->name=='Colaborador' ) --}}
                                @elseif($conteo_almacen==1 and $user_login->almacen->estado==0  )
                                <form action="{{ route('guia_remision.create')}}" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="text" value="{{$user_login->almacen_id}}" hidden="hidden" name="almacen">
                                    <input class="btn btn-sm btn-info"  type="submit" value="Crear una nueva Guia" >
                                </form>

                                {{-- @elseif($conteo_almacen > 1 and $user_login->name =='Administrador') --}}
                                @elseif($conteo_almacen > 1 )
                                <div class="dropdown">
                                  <button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Crear una Nueva Guia</button>
                                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <form action="{{ route('guia_remision.create')}}"enctype="multipart/form-data" >
                                        @csrf
                                        @foreach($almacen as $almacens)
                                        <input type="submit" class="dropdown-item" name="almacen"  value="{{$almacens->id}} - {{$almacens->nombre}}">
                                        @endforeach
                                    </form>
                                </div>
                            </div>
                            {{-- @elseif($conteo_almacen > 1 and $user_login->name=='Colaborador') --}}
                            @elseif($conteo_almacen > 1 )
                            @if($user_login->almacen->estado==1  )
                            <input id="auto" onclick="divAuto()" type="submit" class="btn btn-sm btn-info"  value="Crear una Nueva Guia">
                            <div id="div-mostrar" style="color: black">
                                <div id="texto" style="opacity:0;transition: .4s ;text-align: center;padding-top: 10px;" >Almacen Asignado esta Desactivado, Activelo o cambie de Almacen.</div>
                            </div>
                            @elseif($user_login->almacen->estado==0 )
                            <form action="{{ route('guia_remision.create')}}" enctype="multipart/form-data" >
                                @csrf
                                <input type="text" value="{{$user_login->almacen_id}}" hidden="hidden" name="almacen">
                                <input class="btn btn-sm btn-info"  type="submit" value="Crear una nueva Guia" >
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
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Lista de Guias R.</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Codigo de Guia</th>
                                    <th>Cliente</th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha emision</th>
                                    <th>Ver</th>
                                    <!-- <th>EDITAR</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guia_remision as $guias_remision)
                                <tr class="gradeX">
                                    <td>{{$guias_remision->id}}</td>
                                    <td>{{$guias_remision->cod_guia}}</td>
                                    <td>{{$guias_remision->cliente->nombre}}</td>
                                    <td>{{$guias_remision->cliente->numero_documento}}</td>
                                    <td>{{$guias_remision->fecha_emision}}</td>
                                    <td><center><a href="{{route('guia_remision.show' , $guias_remision->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>


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


<style type="text/css">
.a{width: 200px}

#auto{
    /*padding: -100px;*/
    /*background: orange;*/
    /*width: 95px;*/
    cursor: pointer;
    /*margin-top: 10px;*/
    /*margin-bottom: 10px;*/
    box-shadow: 0px 0px 1px #000;
    display: inline-block;
}

#auto:hover{
    opacity: .8;
}

#div-mostrar{
    /*width: 50%;*/
    margin: auto;
    height: 0px;
    /*margin-top: -5px*/
    /*background: #000;*/
    /*box-shadow: 10px 10px 3px #D8D8D8;*/
    transition: height .4s;
    color:white;
    text-align: right;
}
#auto:hover{
    opacity: .8;
}
/*#auto:hover + #div-mostrar{
    height: 50px;
    }*/
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
    var clic = 1;
    function divAuto(){
       if(clic==1){
           document.getElementById("div-mostrar").style.height = "50px";
           document.getElementById("texto").style.opacity = "1";
           clic = clic + 1;
       } else{
        document.getElementById("div-mostrar").style.height = "0px";
        document.getElementById("texto").style.opacity = "0";

        clic = 1;
    }
}
</script>
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
