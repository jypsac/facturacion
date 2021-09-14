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
    <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">

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
                                    <li><a href="{{route('nota-credito.index')}}">Nota Credito</a></li>
                                    <li><a href="{{route('nota-credito.index')}}">Nota Debito</a></li>
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
                            <a href="#"><img src="{{ asset('/archivos/imagenes/layout/facturacion_electronica.svg')}}" class="iconos"> <span class="nav-label">Fac.Electronica </span></a>
                            <ul class="nav nav-second-level collapse">
                                <li><a href="{{route('facturacion_electronica.index')}}">Facturas</a></li>
                                <li><a href="{{route('facturacion_electronica.index_boleta')}}">Boletas</a></li>
                                <li><a href="{{route('facturacion_electronica.index_guia_remision')}}">Guia Remision</a></li>
                                <li><a href="{{route('facturacion_electronica.index')}}">Nota de creditos</a></li>
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

                            <a id="actualizar" data-toggle="@yield('data-config', '')" onclick="@yield('onclick', '')"   href="@yield('config', '')"  class="@yield('class', 'btn btn-primary')" @yield('atributo_actu', '') >@yield('button2', 'Actualizar')</a>
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
</html>
