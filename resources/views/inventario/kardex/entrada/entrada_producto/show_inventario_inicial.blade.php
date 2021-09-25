@extends('layout')

@section('title', 'Ver')
@section('breadcrumb', 'INVENTARIO INICIAL')
@section('breadcrumb2', 'INVENTARIO INICIAL')
@section('href_accion', route('kardex-entrada.index') )
@section('value_accion', 'Atras')
@section('button2', 'Nueva Entrada')
@section('config',route('kardex-entrada.create'))

@section('content')

<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl">
                <div class="row">
                    <div class="col-sm-4 ">
                      <img src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="width: 300px;margin-bottom: 15px;">
                  </div>
                  <div class="col-sm-4 ">
                  </div>
                  <div class="col-sm-4 text-right">
                    <div class="form-control ruc" >
                        <center>
                            <h3 style="padding-top:10px ">RUC : {{$mi_empresa->ruc}}</h3>
                            <h2>INVENTARIO INICIAL</h2>
                            <h4 class="text-navy">{{$inventario_inicial->codigo_guia}}</h4>
                        </center>
                    </div><br>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
            <form action="{{ route('kardex-entrada.update',$inventario_inicial->id) }}"  enctype="multipart/form-data" method="post">
              @csrf
              @method('PATCH')
              <table class="table invoice-table" >
                <thead>
                    <tr>
                        <th style="width:50px"></th>
                        <th >Producto</th>
                        <th style="width:150px">Cantidad</th>
                        <th style="width:150px">Precio </th>
                        <th style="background: #f3f3f4;width:150px">Precio Total</th>
                    </tr>
                </thead>
                <tbody id="assas">
                    @if($cantidad_registro == 0) @else
                    @foreach($kardex_entradas_registros as $kardex_entradas_registro)
                    <tr>
                        <td> <button type="button" class='borrar btnenviar{{$kardex_entradas_registro->id}} btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button></td>
                        <td >
                            <p  align="left" class="form-control">{{$kardex_entradas_registro->producto->codigo_original}} -  {{$kardex_entradas_registro->producto->nombre}}</p>
                            <input type='hidden'  name='id_registro[]' readonly="readonly" value="{{$kardex_entradas_registro->id}}" required hidden="hidden" />
                        </td>
                        <td>
                            <input type='text'  name='cantidad[]' class="monto{{$kardex_entradas_registro->id}} form-control" value="{{$kardex_entradas_registro->cantidad_inicial}}"  onkeyup="multi({{$kardex_entradas_registro->id}});"  required/>
                        </td>
                        <td>
                            <input type='text' name='precio[]' class="monto{{$kardex_entradas_registro->id}} form-control" onkeyup="multi({{$kardex_entradas_registro->id}});" value="{{$kardex_entradas_registro->precio_nacional}}" required/>
                        </td>
                        <td>
                            <input disabled="disabled"  value="{{$kardex_entradas_registro->cantidad_inicial*$kardex_entradas_registro->precio_nacional}}" type='text' id='total{{$kardex_entradas_registro->id}}' name='total[]' class="form-control" required/>
                        </td>
                        <span id="spTotal"></span>
                    </tr>
                    @endforeach
                    @endif
                </tbody>

            </table>
            <span hidden="hidden"> @if($cantidad_registro == 0) {{$ultimo_numero=0}}@else{{$ultimo_numero=$kardex_entradas_registro->id}}@endif</span>
            <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>
            <button class="btn btn-secondary ladda-button finalizar float-right" data-style="zoom-out" style="margin-left: 10px;"  >Guardar y Finalizar</button><button  data-style="zoom-out" class="guardar ladda-button btn btn-info float-right" >Guardar</button>
            <div id="divmsg" style="display:none" class="alert alert-primary" role="alert">
            </div>
        </form>
        <br>
    </div>
</div>
</div>
</div>
<style type="text/css">
.select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 12px;text-align: left;}
.select2-container--default .select2-selection--single { border: none;}
.select2-container--default .select2-selection--single .select2-selection__rendered {font-size: 0.9rem;padding-left: 0px;color: inherit;}
span.select2.select2-container.select2-container--default{
    width: 100%!important;
    background-color: #FFFFFF;
    background-image: none;
    border-radius: 1px;
    display: block;
    padding: 3px 12px;
    border: 1px solid #e5e6e7;
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
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<!-- Ladda style -->
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css')}}" rel="stylesheet">
<!-- Ladda -->
<script src="{{ asset('js/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js')}}"></script>
<script>
    $(document).ready(function (){
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 10000 });
    });
</script>
<script type="text/javascript">


   function mostrarMensaje(mensaje){
       $("#divmsg").empty(); //limpiar div
       $("#divmsg").append("<p>"+mensaje+"</p>");
       $("#divmsg").show(500);
       $("#divmsg").hide(3000);
   }

   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

   @if($cantidad_registro == 0) @else
   @foreach($kardex_entradas_registros as $kardex_entradas_registro)
   $(".btnenviar{{$kardex_entradas_registro->id}}").click(function(e){

    e.preventDefault();

    var nombres = {{$kardex_entradas_registro->id}};
    // alert( nombres);
    $.ajax({
     type:'PUT',
     url:"{{ route('kardex-entrada.update', $kardex_entradas_registro->id) }}",
     data:{nombres:nombres},
     success:function(data){

      mostrarMensaje(data.mensaje);

  }
});

});
   @endforeach
   @endif
</script>
<script>
    {{-- Sumar --}}
    function multi(a){
        console.log(a);
        var total = 1;
            var change= false; //
            $(`.monto${a}`).each(function(){
                if (!isNaN(parseFloat($(this).val()))) {
                    change= true;
                    total *= parseFloat($(this).val());
                }
            });
            total = (change)? total:0;
            document.getElementById(`total${a}`).value = total;
        }
    </script>
    <script type="text/javascript">
        $(".select2_demo_3").select2({
            placeholder: "Seleccionar Producto",
            allowClear: true
        });
    </script>

    <script>
        {{-- Darle valor a cada Boton si es Finalizar o solo Guardar --}}
        $(".guardar").on('click', function () {
            var data = `<input value="1" type='hidden' name='action' class="form-control" required/>`;
            $('#assas').append(data);
            $(".finalizar").remove();
        });

        $(".finalizar").on('click', function () {
            var data = `<input value="2" type='hidden' name='action' class="form-control" required/>`;
            $('#assas').append(data);
            $(".guardar").remove();
        });
    </script>
    <script>
        var i =  {{$ultimo_numero}}+1;
        $(".addmore").on('click', function () {
            var data = `
            <tr>
            <td> <button type="button" class='borrar btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button></td>
            <td>
            <select class="select2_demo_3 asf" name="articulo_nuevo[]" required="" id="producto${i}" >
            <option></option>
            @foreach($productos as $producto)
            <option value="{{$producto->id}}">{{$producto->codigo_original}}- {{$producto->nombre}}</option>
            @endforeach
            </select>
            </td>
            <td>
            <input type='text' name='cantidad_nuevo[]' class="monto${i} form-control" onkeyup="multi(${i});" required/>
            </td>
            <td>
            <input type='text' name='precio_nuevo[]' class="monto${i} form-control"  onkeyup="multi(${i});"  required/>
            </td>
            <td>
            <input type='text' id='total${i}' class="form-control" disabled="disabled" value="0" required/>
            </td>
            </tr> `;
            $('#assas').append(data);
            i++;
            $(".select2_demo_3").select2({
                placeholder: "Seleccionar Producto",
                allowClear: true
            });

        });
    </script>

    <script>
       $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
</script>

@endsection
