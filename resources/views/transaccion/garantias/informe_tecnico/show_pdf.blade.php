<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia Informe Tecnico</title>{{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
    <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .form-control, .single-line {
    background-color: #FFFFFF;
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 1px;
    color: inherit;
    display: block;
    padding: 6px 12px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}
</style>
<body class="white-bg">
{{-- <div class="ibox" style=" margin-bottom:0px; width: 100%">
    <div class="table-responsive" >

        <img align="left" src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" style="width:200px;height: 50px ;margin-top: 5px">
    </div>
</div> --}}
    <table style="width: 100%;border-collapse:separate">
        <tr>
            <td style="width: auto;border-color: white" >
                <img align="" src="{{asset('storage/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="width: 300px;height: 100px;margin-top: 5px" />
            </td>
            <td style="width: 30%; ;border: 1px #e5e6e7 solid;border-radius: 4px;" align="right">
                <center>
                    <br>
                    <span style="margin: 5px;font-weight: 200;text-align: center;"> R.U.C {{$mi_empresa->ruc}}</span><br>
                    <span style="margin: 5px;font-size: 15px;text-align: center;" >GUIA DE EGRESO</span><br>
                    <span style="margin: 5px;text-align: center;" >{{$garantias_informe_tecnico->orden_servicio}}</span>
                </center>
            </td>
        </tr>
    </table>


<div class="wrapper wrapper-content animated fadeIn">
<table style="width: 100%;border-collapse:separate">
    <tr >
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 47%" >
            <center><strong style="align-content: center;margin: 5px">Contacto Cliente </strong></center><br>
            <strong>Nombre o Empresa:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br>
            <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}}:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Fecha:</strong>&nbsp;{{$garantias_informe_tecnico->fecha}}<br>
            <strong>Telefono:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Correo:</strong>&nbsp; {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}<br>
            <strong>Direccion:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->direccion}}<br>
            <strong>Contacto:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contactos->nombre}}<br>
        </td>
        <th style="width: 5%;border-color: white"></th>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Condiciones Generales </strong></center><br>
            <strong>Ing. Asignado:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}<br>
            <strong>Motivo:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}<br>
            <strong>Marca:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}}<br>
            <strong>Asunto:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}<br>
        </td>
    </tr>
</table>
<br>
<table style="width: 100%;border-collapse:separate">
    <tr>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Datos del Equipo</strong></center><br>

            <span style="float:left;position:relative;width: 59%">
                <strong>MODELO:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->nombre_equipo}}
           </span>
            <span style="float:left;position:relative">
                 <strong>Codigo Interno:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->codigo_interno}}
            </span>

            <br>
            <span style="float:left;position:relative;width: 59%">
                <strong>Número de Serie:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->numero_serie}}
            </span>
            <span style="float:left;position:relative">
                <strong>Fecha de Compra:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->fecha_compra}}
            </span>
            <br>
            <span style="float:left;position:relative;width: 59%">
                <strong>Descripcion del Problema:</strong><br>
                {!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->descripcion_problema)!!}
            </span>
            <span style="float:left;position:relative">

                <strong>Revision y Diagnistico:</strong>
                {!! nl2br($garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->revision_diagnostico)!!}
            </span>
            <br>
        </td>
    </tr>
</table>
<table style="width: 100%;border-collapse:separate">
    <tr >
         <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Estética:</strong></center><br>
            <span>  {!! nl2br($garantias_informe_tecnico->estetica)!!} </span>
            <br>
        </td>
        <th style="width: 5%;border-color: white"></th>
         <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto" >
            <center><strong style="align-content: center;margin: 5px">Revision y Diagnostico</strong></center><br>
            <span> {!! nl2br($garantias_informe_tecnico->revision_diagnostico)!!} </span>
            <br>
        </td>
        {{-- &nbsp;&nbsp;&nbsp; --}}
    </tr>
    <tr style="border-color: white">
        <td style="border-color: white"> </td>
    </tr>
    <tr>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Causas del Problema:</strong></center><br>
            <span>  {!! nl2br($garantias_informe_tecnico->causas_del_problema)!!}</span>
            <br>
        </td>
         <th style="width: 5%;border-color: white"></th>
        <td colspan="2" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: auto">
            <center><strong style="align-content: center;margin: 5px">Solución:</strong></center><br>
            <span> {!! nl2br($garantias_informe_tecnico->solucion)!!}  </span>
            <br>
        </td>
    </tr>
</table >
</div>
<br>
<footer style="position: absolute;bottom:0;width:100%;height:180px;"> {{-- 250 --}}
    <div style="">
        <table class=" white-bg ">
            <tbody>
                <tr>
                    <td class="blanco"></td>
                    <td class="blanco" style="width: 70px;border-top: none;" ><hr style="width:200px;border-top-width:0.1px"  /> </td>
                    <td class="blanco" style="border-top: none;"></td>
                    <td class="blanco" style="width: 70px; border-top: none;"><hr style="width:200px;border-top-width:0.1px"  /> </td>
                </tr>
                <tr>
                    <td class="blanco"></td>
                    <th class="blanco" style="width: 200px;border-top: none;"><center>    Departamento de Servicio Tecnico <br>Ing. {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}</center></th>
                    <th class="blanco" style="border-top: none;"></th>
                    <th class="blanco" style="width: 200px; border-top: none;"><center>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->nombre}}<br> ({{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->documento_identificacion}}: {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->numero_documento}})  </center></th>
                </tr>
                <tr>
                    <td colspan="6" class="blanco">{{-- <p><b>IMPORTANTE:</b> El plazo para el recojo del equipo es de 15 días calendario. en caso de no recoger el equipo dentro de los plazos, este será trasladado al almacén. debiendo pagar S/.20.00 por cada semana que transcurra por gastos administrativos, seguros y almacenaje. Así mismo pasado los 90 días el cliente pierde el derecho total sobre el equipo. </p> --}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
</footer>

<div style="page-break-after:auto; width: 100%;height: 80%" >
    <div class="table">
         <table style="width: 100%;border-collapse:separate">
          <tr>
              <td colspan="4" style="border: 1px #e5e6e7 solid;border-radius: 4px;width: 100%;">
                <center><strong>Imagenes:</strong> <br></center>
                <div style="padding-top: 50px;padding-left: 25px">

                  @foreach($archivo_informe_tecnico as $archivo)
                    <img  src="{{asset('archivos/imagenes/informe_tecnico')}}/{{$archivo->archivos}}" style="width:200px;height: 200px;border-radius: 10px;padding: 5px">
                @endforeach
                </div>
              </td>
          </tr>
      </table>
  </div>
</div>

<style>
    *{font-size: 8px}
    .cero{
    margin-bottom: 0px;

    }
     .table-bordered .blanco {
    border: none;
}
    .blanco{border: none;
        border: medium transparent;
        }
    .border {
        border-color: #aaaaaa;
        border-width: 1px;
        border-style: solid;
    }

</style>

