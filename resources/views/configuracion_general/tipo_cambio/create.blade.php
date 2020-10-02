@extends('layout')

@section('title', 'Tipo de cambio')
@section('breadcrumb', 'Cambio')
@section('breadcrumb2', 'Cambio')
@section('href_accion', route('tipo_cambio.index') )
@section('value_accion', 'Atras')

{{-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    @if(isset($error))
    <div>
      <div class="alert alert-danger">
        <div class="alert-link" href="#">
            <li style="color: red;">{{ $error }} <span style="color:black">Precio Recomendado : {{$paralelo_recomendado}}</span></li>
      </div>
  </div>
</div>
@endif
<div class="row">
  <div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <h5>Cambio Diario</h5>
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
           <form action="{{ route('tipo_cambio.store') }}"  enctype="multipart/form-data" method="post">
               @csrf
               <div class="alert alert-warning">
                {{-- Revisar correctamente el tipo de cambio ,el tipo de cambio solo se efectua 1 vez al dia y la actualización de esta solo podra hacerla el administrador una vez realizada <a class="alert-link"> -Precaución</a>. --}}
                <p>Moneda Principal:<b> {{$moneda_principal->nombre}}</b></p>
            </div>
            <div class="form-group  row"><label class="col-sm-2 col-form-label">Compra:</label>

             <div class="col-sm-10">
                @if(isset($compra))
                <input type="text" class="form-control" name="compra" id="compra" value="{{$compra}}" required="">
                @else
                <input type="text" class="form-control" name="compra"  id="compra" required="">
                @endif
            </div>
        </div>

        <div class="form-group  row"><label class="col-sm-2 col-form-label">Venta:</label>
         <div class="col-sm-10">
             @if(isset($venta))
             <input type="text" class="form-control" name="venta" id="venta" value="{{$venta}}" required="">
             @else
             <input type="text" class="form-control" name="venta"  id="venta" required="">
             @endif
         </div>
     </div>

     <div class="form-group  row"><label class="col-sm-2 col-form-label">Paralelo:</label>
       <div class="col-sm-10">
           @if(isset($paralelo_recomendado))
           <input type="text" class="form-control" name="paralelo" id="paralelo" value="{{$paralelo_recomendado}}" required="">
           @else
           <input type="text" class="form-control" name="paralelo" id="paralelo" required="">
       @endif</div>
   </div>

   <button class="btn btn-primary" type="submit">Guardar</button>
    <input id='myajax' type="button" class="btn btn-info" value="Automatico por Sunat">

</form>
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

<script type="text/javascript">
  $('#myajax').click(function(){
                                         $.ajax({
                                            url:'/sunat_cambio',
                                            data:{'name':"luis"},
                                            type:'post',
                                            headers: {
                                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                            },
                                            success: function (response) {
                                              var datos = eval(response);
                                                  $('#compra').val(datos[0]);
                                                  $('#venta').val(datos[1]);
                                                  $('#paralelo').val(datos[2]);
                                            },
                                            statusCode: {
                                               404: function() {
                                                  alert('web not found');
                                               }
                                            },
                                            error:function(x,xs,xt){
                                                window.open(JSON.stringify(x));
                                            }
                                         });
  });
</script>
@endsection