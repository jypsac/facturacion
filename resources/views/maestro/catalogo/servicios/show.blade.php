@extends('layout')

@section('title', 'Servicios/Ver')
@section('breadcrumb', 'Servicios/Ver')
@section('breadcrumb2', 'Servicios/Ver')
@section('href_accion', route('servicios.index'))
@section('value_accion', 'Atras')

@section('content')


<div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">

 <form action="{{ route('servicios.store') }}"  enctype="multipart/form-data" method="post">
   @csrf
   <div class="row">

    <fieldset class="col-sm-6">
     <legend>Clasificacion del <br>Servicio</legend>

     <div class="panel panel-default">
       <div class="panel-body" align="left">
        <div class="row">
          <label class="col-sm-2 col-form-label">Codigo Alernativo:</label>
          <div class="col-sm-4"><input type="text" class="form-control" name="codigo_original" required="required" value="{{$servicios->codigo_original}}" readonly="readonly"></div>


          <label class="col-sm-2 col-form-label">Categoria:</label>
          <div class="col-sm-4">
            <input type="text" class="form-control m-b" readonly="readonly" value="Servicios" name="categoria">
          </div>
        </div>

      </div>
      <br>
    </div>

  </fieldset>

  <fieldset class="col-sm-6">
   <legend>Datos del <br>Servicios </legend>

   <div class="panel panel-default">
    <div class="panel-body" align="left">
     <div class="row">
      <label class="col-sm-2 col-form-label">Nombre:</label>
      <div class="col-sm-10"><input type="text" class="form-control" name="nombre" placeholder="Nombre del Producto" required="required" value="{{$servicios->nombre}}" readonly=""></div>

      <label class="col-sm-2 col-form-label">Descripcion:</label>
      <div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" rows="2" required="required" readonly="">{{$servicios->descripcion}}</textarea ></div>
    </div>

  </div>
</div>

</fieldset>

<fieldset class="col-sm-6">
 <legend>Precio del <br>Servicios</legend>

 <div class="panel panel-default">
  <div class="panel-body" align="left">
   <div class="row">
     <label class="col-sm-2 col-form-label">Descuento:</label>
     <div class="col-sm-4">
       <div class="input-group m-b">
        <div class="input-group-prepend">
          <span class="input-group-addon">%</span>
        </div>
        <input type="text" class="form-control" name="descuento" required="required" value="{{$servicios->descuento}}" readonly="">
      </div>
    </div>
    <label class="col-sm-2 col-form-label">Utilidad:</label>
    <div class="col-sm-4"><div class="input-group m-b">
      <div class="input-group-prepend">
        <span class="input-group-addon">%</span>
      </div>
      <input type="text" class="form-control" name="utilidad" required="required"  value="{{$servicios->utilidad}}" readonly="">
    </div>
  </div>

</div>
<div class="row">
  <label class="col-sm-2 col-form-label">Precio:</label>
  <div class="col-sm-4"><div class="input-group m-b">
    <div class="input-group-prepend">
      <span class="input-group-addon">S/.</span>
    </div>
    <input type="text" class="form-control" name="precio" required="required"  value="{{$servicios->precio}}" readonly="">
  </div>
</div>

<label class="col-sm-2 col-form-label">garantia:</label>
<div class="col-sm-4"><input type="text" class="form-control" name="garantia" value="12 meses" >
</div>
</div>
<div class="row">
</div>
</div>

</fieldset>
<fieldset class="col-sm-6">
 <legend>Foto del <br>Servicio </legend>

 <div class="panel panel-default">
  <div class="panel-body">
    <div class="col-sm-12">
     <input type="file" id="archivoInput" name="foto" onchange="return validarExt()"  />
     <div id="visorArchivo">
       <!--Aqui se desplegará el fichero-->
       <center ><img name="foto"  src="{{ asset('/archivos/imagenes/servicios/defecto.png')}}" width="350px" height="180px" /></center>
     </div>
   </div>
 </div>
</div>

</fieldset>


</div>

<button class="btn btn-primary" type="submit">Guardar</button>


</form>
</div>


<style>
	/*img{border-radius: 40px}*/
 p#texto{
  text-align: center;
  color:black;
}

input#archivoInput{
  position:absolute;
  top:0px;
  left:0px;
  right:0px;
  bottom:0px;
  width:100%;
  height:100%;
  opacity: 0	;
}
.form-control{    margin-bottom: 15px;border-radius: 5px
}
fieldset
{
  /*border: 1px solid #ddd !important;*/
  padding: 10px;
  /*border-radius:4px ;*/
  background-color:#f5f5f5;
  padding-left:10px!important;
  padding-right:10px!important;
  margin-bottom: 10px;
  border-left: 1px solid #ddd !important;

}

legend
{
  font-size:14px;
  font-weight:bold;
  margin-bottom: 0px;
  width: 35%;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px 5px 5px 10px;
  background-color: #ffffff;
}
</style>
	<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@endsection