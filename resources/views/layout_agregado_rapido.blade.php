
{{-- Modal Cliente --}}
<div class="modal fade" id="ModalCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-left: 22%;">
    <div class="modal-content" style="width: 880px;">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Cliente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div>
    <div class="ibox-content" style="padding-bottom: 0px;">
        <form>
            {{ csrf_field() }}
            <div class="form-group  row"><label class="col-sm-3 col-form-label">Introducir Ruc (Inestable):</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" class="ruc" id="ruc_cliente" name="ruc_cliente" required="required">
                </div>
                <div class="col-sm-2"> <button class="btn btn-primary" id="botoncito_cliente" name="btn" value="cliente" class="botoncito_cliente"><i class="fa fa-search"></i> Buscar</button></div>
            </div>
        </form>
    </div>
    <script>
        $(function(){
            $('#botoncito_cliente').on('click', function(){
                var ruc_cliente = $('#ruc_cliente').val();
                var url = "{{ url('clienteruc') }}";
                $.ajax({
                    type:'GET',
                    url:url,
                    data:'ruc='+ruc_cliente,
                    success: function(datos_dni){
                        var datos = eval(datos_dni);
                        $('#numero_ruc_cli').val(datos[0]);
                        $('#razon_social_cli').val(datos[1]);
                        $('#direccion_cli').val(datos[2]);
                        $('#provincia_cli').val(datos[3]);
                        $('#distrito_cli').val(datos[4]);
                        $('#fechaInscripcion_cli').val(datos[5]);
                    }
                });
                return false;
            });
        });
    </script>
    <div class="wrapper wrapper-content animated fadeInRight" style="padding-bottom: 0px">
        <div class="row">
            <div class="col-lg-12">
                <div >
                    <div >
                        <form action=" @yield('form_action_modal_cliente', route('cliente.store'))"  enctype="multipart/form-data" id="form" class="wizard-big" method="post"> {{-- Yiel form- es para colocar una ruta alterna  --}}
                            @csrf
                            <h1>Datos Personales</h1>
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Documento Identificacion *</label>
                                            <select class="form-control m-b" name="documento_identificacion" onchange="seleccionado()" id="cliente_doc" >
                                                <option value="RUC">RUC</option>
                                                <option value="DNI">DNI</option>
                                                <option value="pasaporte">Pasaporte</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre *</label>
                                            <input type="text" class="form-control" name="nombre" class="form-control required" id="razon_social_cli" required="required">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Numero de Documento *</label>
                                            <input list="browserdoc" class="form-control m-b" name="numero_documento" id="numero_ruc_cli" required  autocomplete="off" type="text">
                                            <datalist id="browserdoc" >
                                                <?php use  App\Cliente; ?>
                                                <?php $clientes=Cliente::all();?>
                                                @foreach($clientes as $cliente)
                                                <option id="a">{{$cliente->numero_documento}} - existente</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="form-group">
                                            <label>Direccion *</label>
                                            <input type="text" value="Lima" class="form-control" name="direccion" id="direccion_cli" class="form-control required" required="required">
                                        </div>
                                    </div>
                                    <!--  -->
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ">
                                                <label>Correo *</label>
                                                <input  name="email" value="sincorreo@gmail.com" type="text" class="form-control required " required="required">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Distrito *</label>
                                                <input type="text" value="Lima" class="form-control" name="ciudad" id="distrito_cli" class="form-control required" required="required">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <h1>Informacion</h1>
                            <fieldset>
                                <div class="row" >
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ">
                                                <label>Telefono *</label>
                                                <input value="00000" type="number" class="form-control" name="telefono" class="form-control required">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Departamento *</label>
                                                <input value="Lima" type="text" class="form-control" name="departamento" id="provincia_cli" class="form-control required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="form-group col-lg-6 ">
                                                <label>Celular *</label>
                                                <input value="0000000" type="number" class="form-control" name="celular" class="form-control required">
                                            </div>
                                            <div class="form-group col-lg-6">
                                                <label>Pais *</label>
                                                <input value="Perú" type="text" class="form-control" name="pais" class="form-control required">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tipo Cliente *</label>
                                            <select class="form-control" name="tipo_cliente">
                                                <option value="Cliente Frecuente">Cliente Frecuente</option>
                                                <option value="Cliente Revendedor">Cliente Revendedor</option>
                                                <option value="Cliente VIP">Cliente VIP</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Aniversario *</label>
                                            <input value="2020-07-22" type="date" class="form-control" name="aniversario" class="form-control required">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Codigo Postal *</label>
                                            <input value="150101" name="cod_postal" type="text" class="form-control required ">
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha Registro *</label>
                                            <input  type="date" class="form-control" id="fechaInscripcion_cli" name="fecha_registro" class="form-control required" value="2020-07-22">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <h1>Contacto</h1>
                            <fieldset>
                                <h2>Informacion I</h2>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Nombre *</label>
                                            <input id="name" name="nombre_contacto" type="text" class="form-control required" value="Contacto">
                                        </div>
                                        <div class="form-group">
                                            <label>Cargo *</label>
                                            <input id="surname" name="cargo_contacto" type="text" class="form-control required" value="Cargo">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Telefono *</label>
                                            <input  name="telefono_contacto" type="text" class="form-control required" value="0050000">
                                        </div>
                                        <div class="form-group">
                                            <label>Celular *</label>
                                            <input id="address" name="celular_contacto" type="text" class="form-control required" value="951000000">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label> Correo *</label>
                                            <input name="email_contacto" type="text" class="form-control required email" value="correo@contanto.com">
                                        </div>
                                    </div>
                                    {{--  --}}
                                    <input type="text" name="ruta_retorno" hidden="hidden" value="@yield('ruta_retorno','cotizacion')">
                                    {{--  --}}
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
{{-- Fin Modal Cliente --}}
{{-- Modal Provedor --}}
<div class="modal fade" id="ModalProvedor" tabindex="-1" role="dialog" aria-labelledby="Provedor" aria-hidden="true">
  <div class="modal-dialog" role="document" style="margin-left: 22%;">
    <div class="modal-content" style="width: 880px;">
      <div class="modal-header">
        <h5 class="modal-title" id="Provedor">Agregar Provedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div>
   <div class="ibox-content" style="padding-bottom: 0px;">
    <form>
        {{ csrf_field() }}
        <div class="form-group  row"><label class="col-sm-3 col-form-label">Introducir Ruc (Inestable):</label>
            <div class="col-sm-7">
                <input type="text" class="form-control" class="ruc_provedor" id="ruc_provedor" name="ruc_provedor" required="required">
            </div>
            <div class="col-sm-2"> <button class="btn btn-primary" id="submit_provedor" class="submit_provedor"><i class="fa fa-search"></i> Buscar</button></div>
        </div>

    </form>
    <script>
        $(function(){
            $('#submit_provedor').on('click', function(){
                var ruc_provedor = $('#ruc_provedor').val();
                var url = "{{ url('provedorruc') }}";
                $.ajax({
                    type:'GET',
                    url:url,
                    data:'ruc='+ruc_provedor,
                    success: function(datos_dni){
                        var datos = eval(datos_dni);
                        $('#numero_ruc_prov').val(datos[0]);
                        $('#razon_social_prov').val(datos[1]);
                        $('#direccion_prov').val(datos[2]);
                    }
                });
                return false;
            });
        });
    </script>
</div>

<form enctype="multipart/form-data" id="form1" class="wizard-big" method="post" action="{{route('provedor.store')}}" > {{-- Yiel form- es para colocar una ruta alterna  --}}
    @csrf
    <h1>Datos Personales</h1>
    <fieldset>
        <div class="row">
           <div class="col-lg-6">
            <label>Nombre *</label>
            <input type="text" class="form-control" name="nombre" class="form-control required" id="razon_social_prov" required="required">
        </div>
        <div class="col-lg-6">
         <label>Numero de Documento *</label>
         <input list="browserdoc" class="form-control m-b" name="numero_documento" id="numero_ruc_prov" required  autocomplete="off" type="number">
     </div>
     <div class="col-lg-6">
         <label>Direccion *</label>
         <input type="text" class="form-control required" name="direccion" id="direccion_prov" required="required">
     </div>
     <div class="col-lg-6">
         <label>Correo *</label>
         <input  type="text"  class="form-control required " name="correo" value="sincorreo@gmail.com" required="required">
     </div>
     <div class="col-lg-6" style="padding-top: 5px">
         <label>Telefono *</label>
         <input  type="text"  class="form-control required " name="telefono" value="95000000" required="required">
     </div>

 </div>
</fieldset>
</form>
</div>
</div>
</div>
</div>
{{-- Fin Modal Provedor --}}
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
<script >
    function seleccionado(){
        var opt = $('#cliente_doc').val();
        if(opt=="DNI" || opt == "pasaporte"){
                // $('#consulta_p_input').prop('disabled', false);
                $('#botoncito_cliente').prop('disabled', true);
                $('#numero_ruc_cli').val('');
                $('#direccion_cli').val('Lima');
                $('#distrito_cli').val('Lima');
                $('#razon_social_cli').val('');
                // $('#consulta_s').hide();
            }else{
                // $('#consulta_p_input').prop('disabled', 'disabled');
                // document.getElementById('credito_pago').style.visibility = "initial";
                $('#botoncito_cliente').prop('disabled', false);
                $('#numero_ruc_cli').val('');
                $('#direccion_cli').val('Lima');
                $('#distrito_cli').val('Lima');
                $('#razon_social_cli').val('');
                // $('#consulta_s').show();
            }
        }
    </script>
