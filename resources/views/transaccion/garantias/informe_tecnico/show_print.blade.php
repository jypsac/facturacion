<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Guia Informe Tecnico</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <script src="@yield('vue_js', '#')" defer></script>

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">
 {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
        window.close();
        }
    </SCRIPT>

</head>
{{-- LLAMADO AL BODY EN FUNCION CERRAR CON UNA DURACION DE 10 SEGUNDOS --}}
<body class="white-bg" style="height:50%" onLoad="setTimeout('cerrar()',1*1000)">

<div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row" style="height: 120px">
                   <div class="col-sm-4" align="left" >
                        <div class="form-control" align="center" style="height: 79%;" align="left">
                            <img align="center" src="{{asset('img/logos/'.$mi_empresa->foto)}}" style="height: 70px;width: 250px;margin-top: 5px">
                        </div>
                    </div>
                    <div class="col-sm-4" align="center">
                        <div class="form-control" align="center" style="height: 79%;" align="center">
                            <img align="center" src="{{asset('storage/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 70px;width: 250px;margin-top: 5px">
                         </div>
                    </div>
                    <div class="col-sm-4" align="right" >
                        <div class="form-control" align="center" style="height: 79%;" align="right ">
                            <h3 style="">R.U.C {{$mi_empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">GUIA DE INFORME TECNICO</h2>
                            <h5>{{$garantias_informe_tecnico->orden_servicio}}</h5>
                        </div>
                    </div>
                </div>
{{--                 <div class="row">
                    <div class="col-sm-6 text-left" align="left">
                        <address class="col-sm-4" >
                            <img align="left" src="{{asset('storage/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="width: 300px;height: 100px;margin-top: 5px">
                        </address>
                    </div>
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-4" align="right" style="width: 100%">
                            <div class="form-control" align="center" style="height: auto;" align="right">
                                <h3 style="padding-top:10px ">R.U.C {{$mi_empresa->ruc}}</h3>
                                <h2 style="font-size: 19px">GUIA DE INFORME TECNICO</h2>
                                <h5>{{$garantias_informe_tecnico->orden_servicio}}</h5>
                            </div>
                        </div>
                </div> --}}
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <h3>Contacto Cliente</h3>
                            <div align="left">
                                <strong>Señor(es):</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br>
                                <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}} :</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Fecha:</strong> &nbsp;{{$garantias_informe_tecnico->fecha}}<br>
                                <strong>Telefono:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <strong>Correo:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}<br>
                                <strong>Direccion:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}<br>
                                <strong>Contacto:&nbsp;</strong>
                                @if($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contacto_cliente_id == null)
                                <em>Sin Registro</em>
                                @else
                                {{$contacto->where('id','=',$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contacto_cliente_id)->pluck('nombre')->first()}} &nbsp;
                                @endif
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                         <div class="form-control" >
                             <h3>Condiciones Generales</h3>
                             <div align="left">
                                <strong>Ing. Asignado:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <strong>Motivo:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}<br>
                                <strong>Marca :</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}} &nbsp;<br>

                                <strong>Asunto:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                                <br>
                            </div>
                        </div>
                    </div>
                    <br>
                   <div class="col-sm-12" align="center" style="padding-top: 15px;">
                        <div class="form-control" style="height: 100%">
                             <h3>Datos del Equipo</h3>
                             <div class="row" style="padding-bottom: 1px">
                                 <div align="left" class="col-sm-6">
                                    <strong>Modelo:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}<br>
                                    <strong>Número de serie:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}<br>
                                    <strong>Descripcion del Problema:&nbsp;</strong><br>
                                    {!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema)!!}
                                </div>
                                <div align="left" class="col-sm-6">
                                    <strong>Codigo Interno:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}<br>
                                    <strong>Fecha de Compra:</strong> &nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra}}<br>
                                    <strong>Revision y Diagnóstico:&nbsp;</strong>{!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico)!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Estética</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{!! nl2br($garantias_informe_tecnico->estetica)!!}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%"><h3>Revision y diagnóstico:</h3>
                                <div align="left" style="font-size: 13px;" >
                                    <p>{!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!}</p>
                               </div>
                            </div>
                        </div>

                </div>
                <br>
                <div class="row" align="center" style="padding-bottom: 5px">
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Causas del Problema</h3>
                            <div align="left" style="font-size: 13px;">
                                <p> {!! nl2br($garantias_informe_tecnico->causas_del_problema)!!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" style="height: 100%" ><h3>Solución</h3>
                            <div align="left" style="font-size: 13px">
                                <p>{!! nl2br($garantias_informe_tecnico->solucion)!!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
</div>
</body>
<footer style="position:relative;bottom:0;width:100%;height:200%;">
    <div class="container">
        <div class="child1"><br>
            <hr />
            <p style="width:250px;" align="center">Departamento de Servicio Tecnico <br>
            Ing. {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos}}</p>
        </div>
        <div class="child2"><br>
            <hr />
            <p style="width:200px;" align="center">{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br>
                                    ({{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}})</p>
        </div>
    </div>
    <div class="saltopagina">
<div class="row" align="center" style="padding-bottom: 5px;">

    <div class="col-sm-12" align="center">
        <div class="form-control" style="height: 100%"><h3>Imagenes</h3>
            <div align="left" style="font-size: 13px">
                <div class="row" align="center" >
                    @foreach($archivo_informe_tecnico as $archivo)
                    <div class="col-sm-4" style="padding: 50px;padding-left:  70px ;margin: -15px" align="center">
                        <img  src="{{asset('archivos/imagenes/informe_tecnico')}}/{{$archivo->archivos}}" style="width:270px;height: 270px;border-radius: 10px">
                        <br>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</footer>
{{-- <div style=""> --}}

{{-- </div> --}}
{{-- </footer> --}}
<style>
    @media all {
   div.saltopagina{
      display: none;
   }
}

@media print{
   div.saltopagina{
      display:block;
      page-break-before:always;
   }
}
    .form-control{
        border-radius: 7px;
    }

    .cero{
    margin-bottom: 0px;

    }
    .container {
        /* background: #e0e0e0; */
        margin: 1 1 1rem;
        height: 7rem;
        display: flex;
        align-items: start;
    margin-top:10rem;

    }

    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }
    .container {
        /* background: #e0e0e0; */
        margin: 1 1 1rem;
        height: 7rem;
        display: flex;
        align-items: start;
    margin-top:8rem;

    }

    .child1 {
        /* background: #60e0b0; */
        height: 7rem;
        padding: .2rem;
    margin-left: 120px;

    }

    .child2 {
        /* background: #60e0b0; */
        padding: .2rem;
        height: 7rem;
        margin-left: 30%;
    }
</style>



<!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>




<style>
    .cero{
    margin-bottom: 0px;

    }
    .container {
        /* background: #e0e0e0; */
        margin: 1 1 1rem;
        height: 7rem;
        display: flex;
        align-items: start;
    margin-top:10rem;

    }

    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }

</style>



<!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

    <script type="text/javascript">
        window.print();
    </script>


