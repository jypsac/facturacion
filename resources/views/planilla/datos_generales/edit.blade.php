@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Editar')
@section('breadcrumb2', 'Personal-Editar')
@section('href_accion', route('personal.show', $personales->id)  )
@section('value_accion', 'Atras')

@section('content')
<form action="{{ route('personal.update',$personales->id) }}"  enctype="multipart/form-data" method="post">
  @csrf
  @method('PATCH')
  <div style="padding-top: 20px;padding-bottom: 50px">
    <div class="container" style=" padding-top: 30px; background: white;">
      <div class="jumbotron"  style="padding: 10px 40px ; background-image: url('https://www.iwantwallpaper.co.uk/images/muriva-bluff-embossed-brick-effect-wallpaper-j30309-p711-1303_image.jpg'); background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
        <table>
          <tr>
            <th width="100% ">
              <div class="row marketing">
                <div class="col-lg-4">
                  <input style="font-size: 20px; text-align: center;" type="text" class="form-control" name="nombres" value="{{$personales->nombres}}">
                </div>
                <div class="col-lg-4">
                  <input style="font-size: 20px; text-align: center;"  type="text" class="form-control" name="apellidos" value="{{$personales->apellidos}}">
                </div>
              </div>
              <br>
              <div class="col-lg-4">
                <select class="form-control m-b" name="nacionalidad">
                  <option value="{{$personales->nacionalidad }}">{{$personales->nacionalidad }}</option>
                  <option disabled="disabled">------------------------</option>
                  @foreach($paises as $pais)
                  <option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>
                  @endforeach
                </select>
              </div>
            </th>
            <th  width="100%" rowspan="2">
             <input  type="file" id="archivoInput"  name="foto"   onchange="return validarExt()"  width="150px" height="150px" />

             <div id="visorArchivo">
               <!--Aqui se desplegará el fichero-->
               <center ><img name="foto" class="rounded-circle circle-border m-b-md" src="{{asset('/profile/images')}}/{{$personales->foto}}"  width="150px" height="150px"></center>
             </div>



           </th>

         </tr>

       </table>

     </div>

     <div class="row marketing">
      <div class="col-lg-6">
        <h4>Fecha Nacimiento</h4>
        <p><input type="date" class="form-control" name="fecha_nacimiento" value="{{$personales->fecha_nacimiento}}"></p>


        <h4>Celular Telefono</h4>
        <div class="row">
          <p class="col-lg-6"><input type="number" class="form-control" name="celular" title="celular"  value="{{$personales->celular}}"></p>
          <p class="col-lg-6"><input type="number" class="form-control" name="telefono" title="telefono" value="{{$personales->telefono}}"></p>
        </div>
        <h4>Genero</h4>
        <p>
          <select class="form-control m-b" name="genero">
            <option value="femenino">{{$personales->genero}}</option>
            @if($personales->genero == 'femenino')
            <option value="masculino">masculino</option>
            @elseif($personales->genero == 'masculino')
            <option value="femenino">femenino</option>
            @endif
          </select>
        </p>
      </div>

      <div class="col-lg-6">
        <h4>Correo</h4>
        <p><input type="email" class="form-control" name="email" value="{{$personales->email}}"></p>

        <h4>Nivel Educativo</h4>
        <p>
         <select class="form-control" name="nivel_educativo">
          <option value="{{$personales->nivel_educativo}}">{{$personales->nivel_educativo}}</option>
          <option value="Primaria">Primaria</option>
          <option value="Secundaria">Secundaria</option>
          <option value="Tecnico">Tecnico</option>
          <option value="universitaria">universitaria</option>
        </select></p>

        <h4>Carrera Profesional</h4>
        <p>
         <select class="form-control" name="profesion">
          <option value="{{$personales->profesion}}">{{$personales->profesion}}</option>
          <option value="sin carrera">sin carrera</option>
          <option value="Contabilidad">Contabilidad</option>
          <option value="Administracion">Administracion</option>
          <option value="Ingenieria">Ingenieria</option>
          <option value="Ciencias de la comunicación">Ciencias de la comunicación</option>
          <option value="Marketing y Mercadotecnia">Marketing y Mercadotecnia</option>
          <option value="Economia">Economia</option>
          <option value="Derecho">Derecho</option>
          <option value="Medicina">Medicina</option>
        </select></p>


      </div>
      <div class="col-lg-6">


        <h4>Documento Identificacion</h4>
        <p>
          <select class="form-control m-b" name="documento_identificacion">
            <option value="{{$personales->documento_identificacion}}">{{$personales->documento_identificacion}}</option>
            @if($personales->documento_identificacion == 'DNI')
            <option value="Pasaporte">Pasaporte</option>
            @elseif($personales->documento_identificacion == 'Pasaporte')
            <option value="DNI">DNI</option>
            @endif
          </select></p>

          <h4>Estado Civil</h4>
          <p>
            <select class="form-control m-b" name="estado_civil">
              <option value="{{$personales->estado_civil}}">{{$personales->estado_civil}}</option>
              @if($personales->estado_civil == 'Soltero')
              <option value="Casado">Casado</option>
              <option value="Viudo con hijos">Viudo con hijos</option>
              <option value="Viudo sin hijos">Viudo sin hijos</option>
              @elseif($personales->estado_civil == 'Casado')
              <option value="Soltero">Soltero</option>
              <option value="Viudo con hijos">Viudo con hijos</option>
              <option value="Viudo sin hijos">Viudo sin hijos</option>
              @elseif($personales->estado_civil == 'Viudo con hijos')
              <option value="Viudo sin hijos">Viudo sin hijos</option>
              <option value="Soltero">Soltero</option>
              <option value="Casado">Casado</option>
              @elseif($personales->estado_civil == 'Viudo sin hijos')
              <option value="Viudo con hijos">Viudo con hijos</option>
              <option value="Soltero">Soltero</option>
              <option value="Casado">Casado</option>
              @endif
            </select>
          </p>



        </div>
        <div class="col-lg-6">
         <h4>Numero Documento</h4>
         <p><input type="text" class="form-control" name="numero_documento" value="{{$personales->numero_documento}}"></p>


         <h4>Direccion Domiciliaria</h4>
         <p><input type="text" class="form-control" name="direccion" value="{{$personales->direccion}}"></p>


       </div>
       <div class="col-lg-6">
        <button class="btn btn-primary" type="submit">Grabar</button>
      </div>
    </div>


  </div>
</div>
</form>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


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
            '<center><img name="foto" class="rounded-circle circle-border m-b-md"  src="'+e.target.result+'"  width="150px" height="150px" ></center>';
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
             img{border-radius: 40px}
             p#texto{text-align: center;
              color:black;
            }

            input#archivoInput{
              position:absolute;
              top:25%;
              left:80%;
              right:0px;
              bottom:58%;
              width:15%;
              opacity: 0	;
            }
          </style>
          @stop

