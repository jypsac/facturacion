@extends('layout')

@section('title', 'Productos')
@section('breadcrumb', 'Productos-Editar')
@section('breadcrumb2', 'Productos-Editar')
@section('href_accion', route('productos.index') )
@section('value_accion', 'Atras')

@section('content')
@if($producto->estado_anular == '1')
  @if($errors->any())
  <div style="padding-top: 20px;">
    <div class="alert alert-danger">
      <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li style="color: red">{{ $error }}</li>
        @endforeach
      </a>
    </div>
  </div>
  @endif
<div class="ibox-content" style="margin-top: 5px;margin-bottom:50px" align="center">

  <form action="{{ route('productos.update',$producto->id) }}"  enctype="multipart/form-data" method="post">
   @csrf
   @method('PATCH')
   <div class="row">

    <fieldset class="col-sm-6">
     <legend>Clasificacion del <br>Producto</legend>

     <div class="panel panel-default">
       <div class="panel-body" align="left">
        <div class="row">
         <label class="col-sm-2 col-form-label">Codigo:</label>
         <div class="col-sm-4"><input type="text" class="form-control" name="codigo" value="{{$producto->codigo_producto}}" readonly="readonly">
         </div>

         <label class="col-sm-2 col-form-label">Codigo Alernativo:</label>
         <div class="col-sm-4"><input type="text" class="form-control" name="codigo_original" value="{{$producto->codigo_original}}" ></div>
       </div>

       <div class="row">
         <label class="col-sm-2 col-form-label">Categoria:</label>
         <div class="col-sm-4">
          <input type="text" class="form-control" value="{{$producto->categoria_i_producto->descripcion}}" disabled="disabled">
        </div>

        <label class="col-sm-2 col-form-label">Marca:</label>
        <div class="col-sm-4">
          <input type="text" class="form-control" value="{{$producto->marcas_i_producto->nombre}}" disabled="disabled">
        </div>
      </div>
      <div class="row">

       <label class="col-sm-2 col-form-label">Familia:</label>
       <div class="col-sm-10">
        <input type="text" class="form-control" value="{{$producto->familia_i_producto->descripcion}}" disabled="disabled">
      </div>

    </div>
    <br>
  </div>

</fieldset>

<fieldset class="col-sm-6">
 <legend>Datos del <br>Producto </legend>

 <div class="panel panel-default">
  <div class="panel-body" align="left">
   <div class="row">
    <label class="col-sm-2 col-form-label">Nombre:</label>
    <div class="col-sm-10"><input type="text" class="form-control" name="nombre" value="{{$producto->nombre}}"></div>

    <label class="col-sm-2 col-form-label">Descripcion:</label>
    <div class="col-sm-10"><textarea type="text" class="form-control" name="descripcion" rows="2" required="required">{{$producto->descripcion}}</textarea ></div>
  </div>
  <div class="row">
    <label class="col-sm-2 col-form-label">Estado:</label>
    <div class="col-sm-4">
      <select class="form-control m-b" name="estado_id">
        <option value="{{$producto->estado_i_producto->id}}"style="font-weight:bold">{{$producto->estado_i_producto->nombre}}</option>			          					@foreach($estados as $estado)
        <option value="{{ $estado->id }}">{{ $estado->nombre}}</option>
        @endforeach
      </select>
    </div>

    <label class="col-sm-2 col-form-label">Origen:</label>
    <div class="col-sm-4">
     <select class="form-control m-b" name="origen">
      <option value="{{$producto->origen}}" style="font-weight:bold">{{$producto->origen}}</option>
      <option value="Producto Nacional" >Producto Nacional</option>
      <option value="Producto Importado">Producto Importado</option>
    </select>
  </div>

</div>

</div>
</div>

</fieldset>

<fieldset class="col-sm-6">
 <legend>Precio del <br>Producto</legend>

 <div class="panel panel-default">
  <div class="panel-body" align="left">
   <div class="row">
     <label class="col-sm-2 col-form-label">Descuento1:</label>
     <div class="col-sm-4">
       <div class="input-group m-b">
        <div class="input-group-prepend">
          <span class="input-group-addon">%</span>
        </div>
        <input type="text" class="form-control" name="descuento1" value="{{$producto->descuento1}}" >
      </div>
    </div>

    <label class="col-sm-2 col-form-label">Descuento2:</label>
    <div class="col-sm-4">
     <div class="input-group m-b">
       <div class="input-group-prepend">
         <span class="input-group-addon">%</span>
       </div>
       <input type="text" class="form-control" name="descuento2" value="{{$producto->descuento2}}" >
     </div>
   </div>

 </div>
 <div class="row">
   <label class="col-sm-2 col-form-label">Descuento Maximo:</label>
   <div class="col-sm-4"><div class="input-group m-b">
    <div class="input-group-prepend">
      <span class="input-group-addon">%</span>
    </div>
    <input type="text" class="form-control" name="descuento_maximo" value="{{$producto->descuento_maximo}}" >
  </div>
</div>

<label class="col-sm-2 col-form-label">Utilidad:</label>
<div class="col-sm-4"><div class="input-group m-b">
  <div class="input-group-prepend">
    <span class="input-group-addon">%</span>
  </div>
  <input type="text" class="form-control" name="utilidad" value="{{$producto->utilidad}}"  >
</div>

</div>
</div>
<div class="row">
 <label class="col-sm-2 col-form-label">Unida de medida:</label>
 <div class="col-sm-4">
   <div class="input-group m-b">
    <select class="form-control m-b" name="unidad_medida_id">
     <option value="{{$producto->unidad_i_producto->id}}" style="font-weight:bold">{{$producto->unidad_i_producto->medida}}</option>
     @foreach($unidad_medidas as $unidad_medida)
     <option value="{{ $unidad_medida->id }}">{{ $unidad_medida->medida}}</option>
     @endforeach
   </select>
 </div>
</div>
<label class="col-sm-2 col-form-label">Peso:</label>
<div class="col-sm-2">
  <div class="input-group m-b">
   <input type="number" class="form-control" name="peso" value="{{$peso}}">
 </div>
</div>
<div class="col-sm-2">
  <div class="input-group m-b">
    <select name="simbolo" class="form-control">
      <option value="{{$simbolo}}">{{$simbolo}}</option>
      <option value="Kilos">Kilos</option>
      <option value="Gramos">Gramos</option>
      <option value="Toneladas">Toneladas</option>
    </select>
  </div>
</div>



</div>
<div class="row">
 <label class="col-sm-2 col-form-label">garantia:</label>
 <div class="col-sm-4">
   <select class="form-control" name="garantia"  >
    <option value="{{$producto->garantia}}">{{$producto->garantia}}</option>
    <option disabled="">----------------------</option>
    <option value="4 meses">4 meses</option>
    <option value="6 meses">6 meses</option>
    <option value="12 meses">12 meses</option>
    <option value="18 meses">18 meses</option>
    <option value="24 meses">24 meses</option>
    <option value="30 meses">30 meses</option>
    <option value="36 meses">36 meses</option>
  </select>
</div>

<label class="col-sm-2 col-form-label">Stok Minimo:</label>
<div class="col-sm-4"><input type="text" class="form-control" name="stock_minimo" value="{{$producto->stock_minimo}}"   >
</div>
<label class="col-sm-2 col-form-label">Stock Maximo:</label>
<div class="col-sm-4"><input type="text" class="form-control" name="stock_maximo"  value="{{$producto->stock_maximo}}"  >
</div>

</div>



</div>



</fieldset>
<fieldset class="col-sm-6">
 <legend>Foto del <br>Producto </legend>

 <div class="panel panel-default">
  <div class="panel-body">
    <div class="col-sm-12">
     <input type="file" id="archivoInput" name="foto" onchange="return validarExt()"  />
     <div id="visorArchivo">
       <!--Aqui se desplegará el fichero-->
       <center >
              @if(isset($producto->foto))
        <img src="
        {{ asset('/archivos/imagenes/productos/')}}/{{$producto->foto}}" style="width:250px; height: 250px;border-radius: 5px"></center>
        @else
        <img src="{{asset('img/logos/producto.svg')}}" style="width:250px; height: 250px;border-radius: 5px"></center>
        @endif
      </center>

    </div><input type="text" value="{{$producto->foto}}" class="form-control" name="ori_foto" hidden="hidden">
  </div>
  <input type="text" value="{{$producto->foto}}" hidden="hidden" name="foto_original">
</div>

</fieldset>


</div>

<button class="btn btn-primary" type="submit">Grabar</button>
</form>
</div>


@elseif($producto->estado_anular == '0')
@include("maestro.catalogo.productos.show");
@endif

<style>
	.form-control{    margin-bottom: 15px;
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
{{-- foto --}}
<script type="text/javascript">
  function validarExt()
  {
    var archivoInput = document.getElementById('archivoInput');
    var archivoRuta = archivoInput.value;
    var extPermitidas = /(.jpg|.png|.jfif)$/i;
    if(!extPermitidas.exec(archivoRuta)){
      alert('Asegurese de haber seleccionado una Imagen');
      archivoInput.value = '';
      return false;
    }

    else
    {
        //PRevio del PDF
        if (archivoInput.files && archivoInput.files[0])
        {
          var visor = new FileReader();
          visor.onload = function(e)
          {
            document.getElementById('visorArchivo').innerHTML =
            '<center><img name="foto" src="'+e.target.result+'"width="250px" height="250px" /></center>';
          };
          visor.readAsDataURL(archivoInput.files[0]);
        }
      }
    }
  </script>

  <script>
   function readURL(input) {
     if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#imgInp").change(function() {
   readURL(this);
 });
</script>
<script>
  function readURL(input) {
    if (input.files && input.files[0]) {
     var reader = new FileReader();

     reader.onload = function(e) {
       $('#blah').attr('src', e.target.result);
     }

     reader.readAsDataURL(input.files[0]);
   }
 }

 $("#imgInp").change(function() {
  readURL(this);
});
</script>

<script>
  $(document).ready(function(){
    $("#wizard").steps();
    $("#form").steps({
      bodyTag: "fieldset",
      onStepChanging: function (event, currentIndex, newIndex)
      {
					// ¡Siempre permita retroceder incluso si el paso actual contiene campos no válidos!
          if (currentIndex > newIndex)
          {
            return true;
          }

                    // Prohibir suprimir el paso "Advertencia" si el usuario es demasiado joven
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                      return false;
                    }

                    var form = $(this);

                    // Limpie si el usuario retrocedió antes
                    if (currentIndex < newIndex)
                    {
                        // Para eliminar estilos de error
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                      }

                    // Deshabilite la validación en los campos que están deshabilitados u ocultos.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Iniciar validación; Evite avanzar si es falso
                    return form.valid();
                  },
                  onStepChanged: function (event, currentIndex, priorIndex)
                  {
                    // Suprima (omita) el paso "Advertencia" si el usuario tiene edad suficiente.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                      $(this).steps("next");
                    }

                    // Suprima (omita) el paso "Advertencia" si el usuario tiene la edad suficiente y quiere el paso anterior.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                      $(this).steps("previous");
                    }
                  },
                  onFinishing: function (event, currentIndex)
                  {
                    var form = $(this);

					// Deshabilita la validación en los campos que están deshabilitados.
                    // En este punto, se recomienda hacer una verificación general (significa ignorar solo los campos deshabilitados)
                    form.validate().settings.ignore = ":disabled";

                    // Iniciar validación; Evitar el envío del formulario si es falso
                    return form.valid();
                  },
                  onFinished: function (event, currentIndex)
                  {
                    var form = $(this);

                    // Enviar entrada de formulario
                    form.submit();
                  }
                }).validate({
                  errorPlacement: function (error, element)
                  {
                    element.before(error);
                  },
                  rules: {
                    confirm: {
                      equalTo: "#password"
                    }
                  }
                });
              });
            </script>
            <style type="text/css">
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
          </style>
          @endsection