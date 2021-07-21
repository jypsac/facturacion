<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/archivos/imagenes/servicios/')}}/@yield('3', auth()->user()->config->foto_icono)" rel="shortcut icon" />
    <title>@yield('title', 'Inicio')/@yield('3', auth()->user()->name)</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    {{-- <script src="@yield('vue_js', '#')" defer></script> --}}
    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/footable/footable.core.css')}}" rel="stylesheet">

    <link href="{{ asset('main.css') }}" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/icono.svg') }}" sizes="any">

</head>
<style type="text/css">
   body {font:@yield('tamano_letra', auth()->user()->config->tamano_letra) @yield('Letra', auth()->user()->config->letra);}
   .spans{color:@yield('color_nombre', auth()->user()->config->color_nombre) !important;
   font-size: @yield('tamano_letra_perfil', auth()->user()->config->tamano_letra_perfil);
   text-shadow: 2px  2px 2px @yield('color_sombra', auth()->user()->config->color_sombra_nombre);}

   .nav-header {
      background-image: url("{{ asset('/css/patterns/')}}/@yield('1', auth()->user()->config->fondo_perfil)");
  }

  .btn-primary {
    color: #fff;
    background-color: #1a5eb3;
    border-color: #1a3bb3;
}
.btn-primary:hover {
    color: #fff;
    background-color: #1a3bb3;
    border-color: #1a5eb3;
}
.page-item.active .page-link {
    background-color: #1a5eb3;
    border-color: #1a3bb3;
}
.dataTables_filter{
    text-align: right;
}
.dataTables_filter > label{
    text-align: left;
}
.rounded-circle{width: 120px; height: auto; border:@yield('2', auth()->user()->config->borde_foto) solid @yield('2', auth()->user()->config->color_borde_foto);}
</style>
<body class="">
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
                                            <select class="form-control m-b" name="documento_identificacion" >
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

use App\Personal;
                                                <?php $clientes=Cliente::all();?>
                                                @foreach($clientes as $cliente)
                                                <option id="a">{{$cliente->numero_documento}} - existente</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <div class="form-group">
                                            <label>Direccion *</label>
                                            <input type="text" class="form-control" name="direccion" id="direccion_cli" class="form-control required" required="required">
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
                                                <input type="text" class="form-control" name="ciudad" id="distrito_cli" class="form-control required" required="required">
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
                                            <input value="01" name="cod_postal" type="text" class="form-control required ">
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha Registro *</label>
                                            <input  type="text" class="form-control" id="fechaInscripcion_cli" name="fecha_registro" class="form-control required" value="2020-07-22">
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

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element" style="left: 10% ">
                        <img alt="image" class="rounded-circle" src=" {{ asset('/profile/images/')}}/@yield('foto', auth()->user()->personal->foto)" style="width: 150px;height: 150px" />
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="block m-t-xs font-bold spans">@yield('nombre',auth()->user()->personal->nombres)</span>
                            <span class="block m-t-xs  spans ">@yield('area',auth()->user()->name) </span>
                        </a>
                    </div>
                    <div class="logo-element">
                        ---
                    </div>
                </li>
                <!-- MENU DESPELEGABLE -->
                @can('inicio')
                <li><a href="{{route('inicio')}}"><img src="{{ asset('/archivos/imagenes/layout/inicio.svg')}}" class="iconos"> <span class="nav-label">Inicio</span></a></li>
                @endcan

                @can('transacciones')
                <li>
                    <a href="#"><img src="{{ asset('/archivos/imagenes/layout/comercializacion.svg')}}" class="iconos"> <span class="nav-label">Comercialización</span></a>
                    <ul class="nav nav-second-level collapse">
                        @can('transacciones-ventas')
                        <li>
                            <a href="#">Ventas</a>
                            <ul class="nav nav-third-level">
                                @can('transacciones-ventas-cotizaciones.index')
                                {{-- <li><a href="{{route('cotizacion.index')}}">Cotizaciones</a></li> --}}
                                <li><a href="#"><span  class="nav-label">Cotizaciones</span></a>
                                    <ul class="nav nav-second-level collapse">
                                        <li><a href="{{route('cotizacion.index')}}"  style="padding-left: 80px;">C.Productos</a></li>
                                        <li><a href="{{route('cotizacion_servicio.index')}}"  style="padding-left: 80px;">C.Servicios</a></li>
                                        <li><a href="{{route('otros.index')}}"  style="padding-left: 80px;">C.Manual</a></li>
                                    </ul></li>
                                    @endcan
                                    @can('transacciones-ventas-facturacion.index')
                                    <li><a href="{{route('facturacion.index')}}">Facturacion</a></li>
                                    @endcan
                                    @can('transacciones-ventas-boleta.index')
                                    <li><a href="{{route('boleta.index')}}">Boleta</a></li>
                                    @endcan
                                    @can('transacciones-ventas-guia_remision.index')
                                    <li><a href="{{route('guia_remision.index')}}">Guia Remision</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                            {{-- <li><a href="{{route('transaccion-compra.index')}}">Compras</a></li> --}}
                            @can('transacciones-garantias')
                            <li>
                                <a href="#">Garantias</a>
                                <ul class="nav nav-third-level">
                                    @can('transacciones-garantias-guias_ingreso.index')
                                    <li><a href="{{route('garantia_guia_ingreso.index')}}">Guias Ingreso</a></li>
                                    @endcan
                                    @can('transacciones-garantias-guias_egreso.index')
                                    <li><a href="{{route('garantia_guia_egreso.index')}}">Guia Egreso</a></li>
                                    @endcan
                                    @can('transacciones-garantias-informe_tecnico.index')
                                    <li><a href="{{route('garantia_informe_tecnico.index')}}">Informe Tecnico</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('inventario')
                    <li>
                        <a href="#"><img src="{{ asset('/archivos/imagenes/layout/inventario.svg')}}" class="iconos">  <span class="nav-label">Inventario</span></a>
                        <ul class="nav nav-second-level collapse">
                            @can('inventario-productos_kardex')
                            <li>
                                <a href="#">Kardex-Producto</a>
                                <ul class="nav nav-third-level">
                                    @can('inventario-productos_kardex-entrada_producto.index')
                                    <li><a href="{{route('kardex-entrada.index')}}">Entrada Producto</a></li>
                                    @endcan
                                    <li><a href="{{route('kardex-entrada-Distribucion.index')}}">Distribucion Producto</a></li>
                                    <li><a href="{{route('kardex-entrada-Traslado-almacen.index')}}">Transalado de Almacen </a></li>
                                    @can('inventario-productos_kardex-salida_producto.index')
                                    <li><a href="{{route('kardex-salida.index')}}">Salida Producto</a></li>
                                    @endcan
                                    
                                </ul>
                            </li>
                            @endcan
                            {{-- <li><a href="{{route('pagados.index')}}">Pagados</a></li> --}}
                                {{-- @can('inventario-productos-inventario_inicial.index')
                                <li><a href="{{route('inventario-inicial.index')}}">Inventario Inicial</a></li>
                                @endcan --}}
                                @can('inventario-toma_de_inventario.index')
                                <li><a href="{{route('periodo-consulta.index')}}">Consultas de inventario</a></li><!-- Periodo Consulta -->
                                @endcan
                                <li><a href="{{route('cierre-periodo.index')}}">Cierre Periodo</a></li>
                                <li><a href="{{route('movimiento-consulta.index')}}">Movimiento Consulta</a></li>
                            </ul>
                        </li>
                        @endcan
                        <style>.iconos{width: 20px;border-radius: 0px;margin-right: 10px}</style>
                        @can('planilla')
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/planilla.svg')}}" class="iconos"> <span class="nav-label">Planilla</span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('planilla-datos_generales.index')
                                <li><a href="{{route('personal.index')}}">Personal</a></li>
                                @endcan
                                @can('planilla-vendedores.index')
                                <li><a href="{{route('vendedores.index')}}">Vendedores</a></li>
                                @endcan
                                <li><a href="{{route('vehiculo.index')}}">Vehiculos</a></li>

                            </ul>
                        </li>
                        @endcan
                        @can('consultas')
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/consultas.svg')}}" class="iconos"><span class="nav-label">Consultas</span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('consultas-garantias')
                                <li>
                                    <a href="#">Garantias</a>
                                    <ul class="nav nav-third-level">
                                        @can('consultas-garantias-guia_ingreso.index')
                                        <li><a href="{{route('consultas.garantias.guias_ingreso')}}">Guia Ingreso</a></li>
                                        @endcan
                                        @can('consultas-garantias-guia_egreso.index')
                                        <li><a href="{{route('consultas.garantias.guias_egreso')}}">Guia Egreso</a></li>
                                        @endcan
                                        @can('consultas-garantias-informe_tecnico.index')
                                        <li><a href="{{route('consultas.garantias.informe_tecnico')}}">Informe Tecnico</a></li>
                                        @endcan
                                    </ul>
                                </li>
                                @endcan
                                {{-- @can('consulta.cantidad_precio.index') --}}
                                <li><a href="{{route('cantidad_precio.index')}}">Productos</a></li>
                                {{-- @endcan --}}
                            </ul>
                        </li>
                        @endcan
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/cturacion_electronica.svg')}}" class="iconos"> <span class="nav-label">Fac.Electronica </span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{route('facturacion_electronica.index')}}">Facturas</a></li>
                                <li><a href="{{route('facturacion_electronica.index_boleta')}}">Boletas</a></li>
                                <li><a href="#">Resumen diario</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/correo.svg')}}" class="iconos"> <span class="nav-label">Correo </span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{route('email.index')}}">Bandeja de Entrada</a></li>
                                {{-- <li><a href="{{route('configuracion_email.index')}}">Configuracion</a></li> --}}
                                <li><a href="{{route('email.trash')}}">Papelera</a></li>

                            </ul>
                        </li>
                        @can('auxiliares')
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/auxiliar.svg')}}" class="iconos"><span class="nav-label">Auxiliares</span></a>
                            <ul class="nav nav-second-level collapse">
                                @can('auxiliares-clientes.index')
                                <li><a href="{{route('cliente.index')}}">Clientes</a></li>
                                @endcan
                                @can('auxiliares-provedores.index')
                                <li><a href="{{route('provedor.index')}}">Provedores</a></li>
                                @endcan
                            </ul>
                        </li>
                        @endcan

                        @can('maestro')
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/productos.svg')}}" class="iconos"><span class="nav-label">Produtos y Servicios</span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{route('productos.index')}}">Productos</a></li>
                                <li><a href="{{route('servicios.index')}}">Servicios</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/configuracion.svg')}}" class="iconos"><span class="nav-label">Configuracion </span></a>
                            <ul class="nav nav-second-level collapse">
                             @can('maestro-catalogo-clasificacion')
                             <li><a href="{{route('Configuracion')}}">Configuracion del Sistema</a></li>
                             @endcan
                             @can('maestro-configuracion_general.mi_empresa.index')
                             <li><a href="{{route('empresa.index')}}">Mi Empresa</a></li>
                             @endcan
                         </ul>
                     </li>

                     @endcan

                     <!-- MENU DESPELEGABLE -->
                 </ul>
             </div>
         </nav>
         {{-- Menu Superior --}}
         <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top  " role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        {{-- <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Buscar..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form> --}}
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Bienvenido :@yield('nombres',auth()->user()->personal->nombres)</span>
                        </li>
                        <li>
                            {{-- <a href="{{route('home')}}">
                                <i class="fa fa-barsign-out"></i> Cerrar Secciónes
                            </a> --}}
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Cerrar Seccion
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>@yield('title', 'Inicio')</h2>
                        <!-- <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a>@yield('breadcrumb', '')</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <strong>@yield('breadcrumb2', '')</strong>
                            </li>
                        </ol> -->
                    </div>
                    <div class="col-sm-8">
                        <div class="title-action">
                            <a style="visibility:@yield('visibility', 'hidden')" {{-- data-toggle="@yield('a', '')" --}}  href="@yield('ruta', '')" class="btn btn-primary">@yield('name', '')</a>

                            <a data-toggle="@yield('data-toggle', '')"  href="@yield('href_accion', '#')" class="btn btn-primary">@yield('value_accion', '#')</a>

                            <a id="actualizar" data-toggle="@yield('data-config', '')" onclick="@yield('onclick', '')"   href="@yield('config', '')"  class="@yield('class', 'btn btn-primary')" >@yield('button2', 'Actualizar')</a>
                        </div><!--
                        @yield('div', '') -->



                    </div>

                </div>

                @yield('content')




                <div class="footer">
                    <div class="float-right">
                        Visitanos: &nbsp;&nbsp; <a href="https://www.facebook.com/JYPPERIFERICOSSAC" target="_blank" ><i class="fa fa-facebook-square" aria-hidden="true"></i></a>&nbsp;
                        <a href="https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20" target="_blank" ><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                    </div>
                    <div>
                        <strong>Copyright </strong> &nbsp;<a href="http://www.jypsac.com" target="_blank" > JyP Perifericos</a>&nbsp;  &copy; 2019-2020
                    </div>

                </div>
            </div>
        </div>


    </body>
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
    </html>
