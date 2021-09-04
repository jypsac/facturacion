@extends('layout')

@section('title', ' Crear - Guia de Egreso')
@section('breadcrumb', 'Crear Guia de egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.index'))
@section('value_accion', 'Atras')

@section('content')
<style>
    .form-control{margin-top: 10px;}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <form action="{{route('garantia_guia_egreso.store')}}"  enctype="multipart/form-data" method="post">
       @csrf
       <div class="ibox-content p-xl" style=" margin-bottom: 2px;padding-bottom: 50px;">
          <br>
          <div class="row" style="height: 120px">
            <div class="col-sm-4 text-left" align="left">
                <div class="form-control" align="center" style="height: 79%;" align="left">
                    <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
                </div>
            </div>
            <div class="col-sm-4" align="center">
                <div class="form-control" align="center" style="height: 79%;" align="center"  >
                    <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantias_guias_ingresos->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
                </div>
            </div>
            <div class="col-sm-4" align="right" >
                <div class="form-control" align="center" style="height: 79%;"align="right">
                    <h3 style="">R.U.C {{$empresa->ruc}}</h3>
                    <h2 style="font-size: 19px">GUIA DE EGRESO</h2>
                    <h5>{{$garantias_guias_ingresos->orden_servicio}}</h5>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
         <div class="col-sm-6" align="center" >
            <div class="form-control">
                <h3>Datos Generales </h3>
                <br>
                <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
                  <label class="col-sm-2 col-form-label">Asunto:</label>
                  <div class="col-sm-4">
                     <input type="text" class="form-control" value="{{$garantias_guias_ingresos->asunto}}" disabled="disabled">
                 </div>
                 <label class="col-sm-2 col-form-label">Ing. Asignado:</label>
                 <div class="col-sm-4">
                    <input type="text" class="form-control" disabled="disabled"value="{{$garantias_guias_ingresos->personal_laborales->nombres}}">
                </div>
                <label class="col-sm-2 col-form-label">Motivo:</label>
                <div class="col-sm-4">
                   <input type="text" class="form-control" value="{{$garantias_guias_ingresos->motivo}}" disabled="disabled">
               </div>
               <label class="col-sm-2 col-form-label">Fecha:</label>
               <div class="col-sm-4">
                  <input type="text" class="form-control"  value="{{date('Y-m-d')}}" disabled="disabled">
              </div>
          </div>
          <br>
      </div>
  </div>
  <div class="col-sm-6" align="center">
      <div class="form-control">
         <h3>Datos del Cliente</h3>
         <br>
         <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
            <label class="col-sm-2 col-form-label">Nombre:</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" value="{{$garantias_guias_ingresos->clientes_i->nombre}}" disabled="disabled">
            </div>
            <label class="col-sm-2 col-form-label">Telefono:</label>
            <div class="col-sm-4">
               <input type="text" class="form-control" value="{{$garantias_guias_ingresos->clientes_i->telefono}}" disabled="disabled">
           </div>
           <label class="col-sm-2 col-form-label">Correo:</label>
           <div class="col-sm-10">
             <input type="text" class="form-control" value="{{$garantias_guias_ingresos->clientes_i->email}}" disabled="disabled">
         </div>
     </div>
     <br>
 </div>
</div>
<div class="col-sm-12" align="center">
  <br>
  <div class="form-control">
     <h3>Datos del Equipo</h3>
     <br>
     <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
        <label class="col-sm-2 col-form-label">Modelo:</label>
        <div class="col-sm-4">
           <input type="text" class="form-control" value="{{$garantias_guias_ingresos->nombre_equipo}}" disabled="disabled">
           <input type="hidden" name="id" value="{{$id}}" readonly="" hidden="hidden">
       </div>
       <label class="col-sm-2 col-form-label"> Nr Serie:</label>
       <div class="col-sm-4">
           <input type="text" class="form-control" value="{{$garantias_guias_ingresos->numero_serie}}" disabled="disabled">
       </div>
       <label class="col-sm-2 col-form-label">Codigo Interno:</label>
       <div class="col-sm-4">
           <input type="text" class="form-control" value="{{$garantias_guias_ingresos->codigo_interno}}" disabled="disabled">
       </div>
       <label class="col-sm-2 col-form-label">Fecha Compra:</label>
       <div class="col-sm-4">
         <input type="text" class="form-control" value="{{$garantias_guias_ingresos->fecha_compra}}" disabled="disabled">
     </div>
 </div>
 <br>
</div>
</div>
<div class="col-sm-12" align="center">
  <br>
  <div class="form-control">
   <h3>Informe del Problema</h3>
   <br>
   <div align="left" class="row" style="padding-right:10px; padding-left: 10px;">
     <div class="col-sm-4">
        <center><h4>Descripcion del Problema</h4></center>
        <div class="input-group m-b">
           <textarea class="form-control" rows="5" id="comment" name="descripcion_problema" maxlength="1230" required style="resize: none;height: 300px;"></textarea>
       </div>
   </div>
   <div class="col-sm-4">
    <center><h4>Diagnostico y Solucion</h4></center>
    <div class="input-group m-b">
       <textarea class="form-control" rows="5" id="comment" name="diagnostico_solucion"  maxlength="1230" required style="resize: none;height: 300px;"></textarea>
   </div>
</div>
<div class="col-sm-4">
    <center><h4>Recomendaciones</h4></center>
    <div class="input-group m-b">
        <textarea class="form-control" rows="5" id="comment" name="recomendaciones"  maxlength="1230" required style="resize: none;height: 300px;"></textarea>
    </div>
</div>
</div>
</div>
<br>
<button class="btn btn-xl btn-primary float-right m-t-n-xs" type="submit" ><strong>Grabar</strong></button>
</div>
</div>
</div>
</form>
</div>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


@stop