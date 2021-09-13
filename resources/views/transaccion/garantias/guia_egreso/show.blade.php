@extends('layout')

@section('title', 'Ver Guia de Egreso')
@section('breadcrumb', 'Ver Guia de Egreso')
@section('breadcrumb2', 'Garantia')
@section('href_accion', route('garantia_guia_egreso.guias'))
@section('value_accion', 'Nueva Guia')
@section('button2', 'Inicio')
@section('config',route('garantia_guia_egreso.index'))

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row ibox-title" style="padding-right: 3.1%;margin: 0;padding-bottom: 0px;" >
        <div class="col-sm-6">
           @if($garantias_guias_egreso->estado == 1 and $garantias_guias_egreso->egresado == 0 )
           <a href="{{ route('garantia_guia_ingreso.edit', $garantia_guia_ingreso->id) }}"><button type="button" class="btn btn-success"><i class="fa fa-edit"></i></button></a>
           @endif
           <a href="#form_egreso" onclick="Formulario_edit()"  id="click" class="btn btn-info"><i class="fa fa-edit"></i></a>
       </div>
       <div class="col-sm-6 tooltip-demo "align="right"  >
        <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_egreso' ,$garantias_guias_egreso->id)}}">
            <input type="text" name="archivo" maxlength="50" value="{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}" oninput="actualizatext()" id="texto2">
            <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
        </form>
        @if(Auth::user()->email_creado == 1)
        <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn" >
            @csrf
            <input type="text" hidden="hidden"  name="tipo" value="App\GarantiaGuiaEgreso"/>
            <input type="text" hidden="hidden"  name="id" value="{{$garantias_guias_egreso->id}}"/>
            <input type="text" hidden="hidden"  name="redict" value="garantias_guias_egreso"/>
            <input type="text" hidden="hidden"  name="cliente" value="{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}"/>
            <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
        </form>
        @endif
        <a href="{{route('impresiones_egreso' ,$garantias_guias_egreso->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i>   </a>
        <div id="auto" onclick="divAuto()">
            <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
        </div>
        <div id="div-mostrar">
            {{-- <br style="width: -1px"> --}}
            <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                @csrf
                <input type="tel" name="numero"  value="{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->celular}}"  />
                <input type="text" name="mensaje" id="texto_orden" hidden="" />
                <input type="text" hidden="" name="url" value="{{route('pdf_ingreso' ,$garantias_guias_egreso->id)}}?archivo=">
                <input type="text" name="name_sin_cambio" hidden="" value="{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}" />
                <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
            </form>
        </div>
    </div>
</div>
{{--  --}}
<div class="row">
    <div class="col-lg-12" style="margin-top: -2px">
        <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
            <div class="row" style="height: 120px">
                <div class="col-sm-4 text-left" align="left">
                    <div class="form-control" align="center" style="height: 79%;" align="left">
                        <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
                    </div>
                </div>
                <div class="col-sm-4" align="center">
                    <div class="form-control" align="center" style="height: 79%;" align="center">
                        <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantias_guias_egreso->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
                    </div>
                </div>
                <div class="col-sm-4" align="right" >
                    <div class="form-control" align="center" style="height: 79%;" align="right">
                        <h3 style="">R.U.C {{$empresa->ruc}}</h3>
                        <h2 style="font-size: 19px">GUIA DE EGRESO</h2>
                        <h5>{{$garantias_guias_egreso->garantia_ingreso_i->orden_servicio}}</h5>
                    </div>
                </div>
            </div>
            <br>
            <div class="row" align="center" style="padding-bottom: 5px">
                <div class="col-sm-6" align="center">
                    <div class="form-control">
                        <h3>Contacto Cliente</h3>
                        <div align="left">
                            <strong>Señor(es):</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->nombre}}<br>
                            <strong>{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->documento_identificacion}} :</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->numero_documento}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Fecha:</strong> &nbsp;{{$garantias_guias_egreso->fecha}}<br>
                            <strong>Telefono:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->telefono}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Correo:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->email}}<br>
                            <strong>Direccion:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->clientes_i->direccion}}<br>
                            <strong>Contacto:&nbsp;</strong>
                            @if($garantias_guias_egreso->garantia_ingreso_i->contacto_cliente_id == null)
                            <em>Sin Registro</em>
                            @else
                            {{$garantias_guias_egreso->garantia_ingreso_i->contactos->nombre }}
                            @endif
                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" align="center">
                 <div class="form-control" >
                     <h3>Condiciones Generales</h3>
                     <div align="left">
                        <strong>Ing. Asignado:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_guias_egreso->garantia_ingreso_i->personal_laborales->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                        <strong>Motivo:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->motivo}}<br>
                        <strong>Marca :</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre}} &nbsp;<br>

                        <strong>Asunto:</strong>&nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
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
                        <strong>Modelo:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->nombre_equipo}}<br>
                        <strong>Número de serie:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->numero_serie}}<br>
                    </div>
                    <div align="left" class="col-sm-6">
                        <strong>Codigo Interno:</strong>&nbsp; {{$garantias_guias_egreso->garantia_ingreso_i->codigo_interno}}<br>
                        <strong>Fecha de Compra:</strong> &nbsp;{{$garantias_guias_egreso->garantia_ingreso_i->fecha_compra}}<br>
                    </div>
                </div>
            </div>
        </div>

    </div><br>
    <div class="row" align="center" style="padding-bottom: 5px" id="vista_egreso">
        <div class="col-sm-4" align="center">
            <div class="form-control" style="height: 100%"><h3>Descripcion del Problema:</h3>
                <div align="left" style="font-size: 13px;" >
                    <p>{{$garantias_guias_egreso->descripcion_problema}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4" align="center">
            <div class="form-control" style="height: 100%" ><h3>Revisión y diagnóstico</h3>
                <div align="left" style="font-size: 13px;">
                    <p>{{$garantias_guias_egreso->diagnostico_solucion}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-4" align="center">
            <div class="form-control" style="height: 100%" ><h3>Recomendaciones</h3>
                <div align="left" style="font-size: 13px">
                    <p>{{$garantias_guias_egreso->recomendaciones}}</p>
                </div>
            </div>
        </div>
    </div>
    {{-- Form --}}
    <form action="{{ route('garantia_guia_egreso.update',$garantias_guias_egreso->id) }}"  enctype="multipart/form-data" method="post">
      @csrf
      @method('PATCH')
      <div class="row" align="center" style="padding-bottom: 5px" id="form_egreso" hidden="hidden" id="ab">
        <div class="col-sm-4" align="center">
            <div class="form-control" style="height: 100%"><h3>Descripcion del Problema:</h3>
                <div align="left" style="font-size: 13px;" >
                    <textarea rows="5" class="form-control" class="" name="descripcion_problema">{{$garantias_guias_egreso->descripcion_problema}}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-4" align="center">
            <div class="form-control" style="height: 100%" ><h3>Revisión y diagnóstico</h3>
                <div align="left" style="font-size: 13px;">
                    <textarea rows="5" class="form-control" class="" name="diagnostico_solucion">{{$garantias_guias_egreso->diagnostico_solucion}}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-4" align="center">
            <div class="form-control" style="height: 100%" ><h3>Recomendaciones</h3>
                <div align="left" style="font-size: 13px">
                    <textarea rows="5" class="form-control" class="" name="recomendaciones">{{$garantias_guias_egreso->recomendaciones}}</textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-12" align="center" style="margin-top:20px">
            <button class="btn btn-info">Guardar</button>
        </div>
    </div>
</form>
{{--  --}}

<br>
<footer style="padding-top: 10px">
  <br>
  <div class="row">
    <div class="col-sm-4">
        <strong><p><u>Centro de Atencion : </strong></u></p>
        <strong>Direccion:</strong> {{$usuario->almacen->direccion}}<br>
        <strong>Telefonos :</strong>  {{$empresa->telefono}} / {{$usuario->celular}} &nbsp;<br>
        <strong>{{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->nombre_empresa}}:</strong> {{$garantias_guias_egreso->garantia_ingreso_i->marcas_i->telefono}}<br>
        <strong>Email:</strong> {{$usuario->email}}<br>
        <strong>Web:</strong> {{$empresa->pagina_web}}<br>
    </div>
    <div class="col-sm-2"></div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3"><br><br>
    </div>
</div>
</footer>
</div>
</div>
</div>

<style>
#auto{
    cursor: pointer;
    box-shadow: 0px 0px 1px #000;
    display: inline-block;
}
#auto:hover{
    opacity: .8;
}

#div-mostrar{
    margin: auto;
    height: 0px;
    transition: height .4s;
    color:white;
    text-align: right;
}
#auto:hover{
    opacity: .8;
}
#auto:hover + #div-mostrar{
    height: 50px;
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
<script  type="text/javascript">
    function actualizatext() {
        let action = document.getElementById("texto2").value;
        document.getElementById("texto_orden").value = action;
    }
</script>
<script>
    function Formulario_edit(){
      var form_egreso = document.getElementById("form_egreso");
      var vista_egreso = document.getElementById("vista_egreso");
      var boton=document.getElementById("click");
      if( form_egreso.hasAttribute("hidden") )
      {
          form_egreso.removeAttribute("hidden", "");
          boton.innerHTML='<i class="fa fa-window-close"></i>';
          vista_egreso.setAttribute("hidden", "");
      }
      else{
          form_egreso.setAttribute("hidden", "");
          boton.innerHTML='<i class="fa fa-edit"></i>';
          vista_egreso.removeAttribute("hidden", "");

      }

  }
</script>

@endsection
