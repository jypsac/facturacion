<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inicio')</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

</head>

<body class="">
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <img alt="image" class="rounded-circle" src="{{ asset('img/profile_small.jpg') }}"/>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">David Beckan</span>
                                <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a class="dropdown-item" href="">Perfil</a></li>
                                <li><a class="dropdown-item" href="">Contactos</a></li>
                                <li><a class="dropdown-item" href="">Mail</a></li>
                                <li class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="">Cerrar Seccion</a></li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    <!-- MENU DESPELEGABLE -->
                    <li>
                        <a href="{{route('inicio')}}"><i class="fa fa-magic"></i> <span class="nav-label">Inicio</span></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label">Transacciones</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="#">Ventas</a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{route('cotizacion.index')}}">Cotizaciones</a></li>
                                    <li><a href="{{route('credito.index')}}">Credito</a></li>
                                    <li><a href="{{route('debito.index')}}">Debito</a></li>
                                    <li><a href="{{route('facturacion.index')}}">Facturacion</a></li>
                                    <li><a href="{{route('guia.index')}}">Guias</a></li>
                                    <li><a href="{{route('pedidos.index')}}">Pedidos</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('transaccion-compra.index')}}">Compras</a></li>
                            <li><a href="{{ route('almacen.index') }}">Almacenes</a></li>
                            <li>
                                <a href="#">Garantias</a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{route('garantia_guia_ingreso.index')}}">Guias Ingreso</a></li>
                                    <li><a href="{{route('garantia_guia_egreso.index')}}">Guia Egreso</a></li>
                                    <li><a href="{{route('garantia_informe_tecnico.index')}}">Informe Tecnico</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label">Inventario</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="#">Productos Kardex</a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{route('kardex-entrada.index')}}">Entrada Producto</a></li>
                                    <li><a href="{{route('kardex-salida.index')}}">Salida Producto</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('pagados.index')}}">Pagados</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file-archive-o"></i> <span class="nav-label">Planilla</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{route('personal.index')}}">Datos Generales</a></li>
                            <li><a href="{{route('personal-datos-laborales.index')}}">Datos Laborales</a></li>
                            <li><a href="{{route('horarios.index')}}">Horarios</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-inbox"></i> <span class="nav-label">Consultas</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{route('venta.index')}}">Ventas</a></li>
                            <li><a href="{{route('compra.index')}}">Compras</a></li>
                            <li>
                                <a href="#">Garantias</a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{route('consultas.garantias.guias_ingreso')}}">Guia Ingreso</a></li>
                                    <li><a href="{{route('consultas.garantias.guias_egreso')}}">Guia Egreso</a></li>
                                    <li><a href="{{route('consultas.garantias.informe_tecnico')}}">Informe Tecnico</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-address-card  "></i> <span class="nav-label">Auxiliares</span></a>
                        <ul class="nav nav-second-level collapse">
                            <li><a href="{{route('cliente.index')}}">Clientes</a></li>
                            <li><a href="{{route('provedor.index')}}">Provedores</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-magic"></i> <span class="nav-label">Maestro</span></a>
                        <ul class="nav nav-second-level collapse">

                            <li>
                                <a href="#">Catalogo</a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{route('productos.index')}}">Productos</a></li>
                                    <li><a href="{{route('servicios.index')}}">Servicios</a></li>
                                    <li><a href="{{route('promedios.index')}}">Promedios</a></li>
                                    <li><a href="{{route('Clasificacion')}}">Clasificacion</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('usuario.index')}}">Usuarios</a></li>
                            <li><a href="{{route('moneda.index')}}">Monedas</a></li>
                            <li><a href="{{route('documento.index')}}">Tipo de Documentos</a></li>
                            <li>
                                <a href="#">Configuracion General</a>
                                <ul class="nav nav-third-level">
                                    <li><a href="{{route('empresa.index')}}">Mi Empresa</a></li>
                                    <li><a href="{{route('unidad-medida.index')}}">Unidad de Medida</a></li>
                                    <li><a href="{{route('igv.index')}}">IGV</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
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
                            <form role="search" class="navbar-form-custom" action="search_results.html">
                                <div class="form-group">
                                    <input type="text" placeholder="Buscar..." class="form-control" name="top-search" id="top-search">
                                </div>
                            </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Bienvenido</span>
                        </li>
                        <li>
                            <a href="{{-- {{route('home')}} --}}">
                                <i class="fa fa-barsign-out"></i> Cerrar Secciónes
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-4">
                        <h2>@yield('title', 'Inicio')</h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a>@yield('breadcrumb', '')</a>
                            </li>
                            <li class="breadcrumb-item active">
                                <strong>@yield('breadcrumb2', '')</strong>
                            </li>
                        </ol>
                    </div>
                    <div class="col-sm-8">
                        <div class="title-action">
                            <a href="@yield('href_accion', '#')" class="btn btn-primary">@yield('value_accion', '#')</a>
                        </div>
                    </div>
                </div>

                @yield('content')



                <div class="footer">
                <div class="float-right">
                    Visitanos: <a href="http://www.jypsac.com"><strong>JYP</strong></a> <
                </div>
                <div>
                    <strong>Copyright</strong> JyP Perifericos &copy; 2019-2020
                </div>
                </div>
            </div>
    </div>


</body>
</html>
