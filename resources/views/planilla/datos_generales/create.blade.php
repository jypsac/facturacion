@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Agregar')
@section('breadcrumb2', 'Personal-Agregar')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')

@section('content')

<form action="{{ route('personal.store') }}"  enctype="multipart/form-data" method="post">
						@csrf
<div style="padding-top: 20px;padding-bottom: 50px">
<div class="container" style=" padding-top: 30px; background: white;">
      <div class="jumbotron"  style="padding: 10px 40px ; background-image: url('https://www.iwantwallpaper.co.uk/images/muriva-bluff-embossed-brick-effect-wallpaper-j30309-p711-1303_image.jpg'); background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
    <table>
            <tr>
                <th width="100% ">
                		<div class="row marketing">
                		<div class="col-lg-4">
                		<input style="font-size: 20px; text-align: center;" type="text" class="form-control" name="nombres" value="" placeholder="Nombres">
                		</div>
                		<div class="col-lg-4">
                		<input style="font-size: 20px; text-align: center;"  type="text" class="form-control" name="apellidos" value="" placeholder="Apellidos">
                		</div>
                		</div>
                		 <br>
                        <div class="col-lg-4">
                          <select class="form-control m-b" name="nacionalidad">
                            <option value="">Seleccione Pais</option>
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
						<center ><img name="foto" class="rounded-circle circle-border m-b-md"  src="{{asset('/profile/images/perfil.svg')}}" width="150px" height="150px"></center>
						</div>
													

                 </th>
                
             </tr>

     </table>
                        
      </div>

      <div class="row marketing">
        <div class="col-lg-6">
          <h4>Fecha Nacimiento</h4>
          <p><input type="date" class="form-control" name="fecha_nacimiento" value=""></p>
                                                

          <h4>Celular</h4>
          <p><input type="text" class="form-control" name="celular"  value=""></p>    


          <h4>Genero</h4>
          <p>
          <select class="form-control m-b" name="genero">
            <option value="femenino">Selecione Genero</option>
            <option value="masculino">masculino</option>
            <option value="femenino">femenino</option>
          </select>
         </p>
        </div>

        <div class="col-lg-6">
          <h4>Correo</h4>
          <p><input type="email" class="form-control" name="email" value=""></p>  

            <h4>Nivel Educativo</h4>
          <p>
            <select class="form-control" name="nivel_educativo">
              <option value="Primaria">Primaria</option>
              <option value="Secundaria">Secundaria</option>
              <option value="Tecnico">Tecnico</option>
              <option value="universitaria">universitaria</option>
            </select></p>  
          
            <h4>Carrera Profesional</h4>
          <p>
           <select class="form-control" name="profesion">
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
            <option value="">Selecione Documento</option>
            <option value="Pasaporte">Pasaporte</option>
              <option value="DNI">DNI</option>
           </select></p>

          <h4>Estado Civil</h4>
          <p>
              <select class="form-control m-b" name="estado_civil">
                 <option value="Soltero">Soltero</option>
                  <option value="Casado">Casado</option>
                  <option value="Viudo con hijos">Viudo con hijos</option>
                  <option value="Viudo sin hijos">Viudo sin hijos</option>
               </select>
          </p>  

        

        </div>
        <div class="col-lg-6">
         <h4>Numero Documento</h4>
          <p><input type="text" class="form-control" name="numero_documento" value=""></p> 
          

          <h4>Direccion Domiciliaria</h4>
          <p><input type="text" class="form-control" name="direccion" value=""></p>   

          
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
  
