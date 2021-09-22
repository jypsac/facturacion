@extends('layout')

@section('title', 'Ver Informe Tecnico')
@section('breadcrumb', 'Ver informe Tecnico')
@section('breadcrumb2', 'Informe Tecnico')
@section('href_accion', route('garantia_informe_tecnico.guias') )
@section('value_accion', 'Nueva Guia')

@section('button2', 'Inicio')
@section('config',route('garantia_informe_tecnico.index'))

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row ibox-title" style="padding-right: 3.1%;margin: 0;" >
        <div class="col-sm-6">
           <a href="#punto" onclick="Formulario_edit()"  id="click" class="btn btn-info"><i class="fa fa-edit"></i></a>
       </div>
       <div class="col-sm-6">
           <div class="tooltip-demo" align="right">
            <form class="btn" style="text-align: none;padding: 0 0 0 0" action="{{route('pdf_informe' ,$garantias_informe_tecnico->id)}}">
                <input type="text" name="archivo" maxlength="50" value="{{$garantias_informe_tecnico->orden_servicio}}" oninput="actualizatext()" id="texto2">
                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar PDF" ><i class="fa fa-file-pdf-o fa-lg"></i>  </button>
            </form>
            @if(Auth::user()->email_creado ==1)
            <form action="{{route('email.save')}}" method="post" style="text-align: none;padding-right: 0;padding-left: 0;" class="btn">
                @csrf
                <input type="text" hidden="hidden" name="tipo" value="App\GarantiaInformeTecnico"/>
                <input type="text" hidden="hidden" name="id" value="{{$garantias_informe_tecnico->id}}"/>
                <input type="text" hidden="hidden" name="redict" value="garantias_informe_tecnico">
                <input type="text" hidden="hidden" name="cliente" value="{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->email}}">
                <button type="submit" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por correo"><i class="fa fa-envelope fa-lg"  ></i> </button>
            </form>
            @endif
            <a href="{{route('impresiones_informe' ,$garantias_informe_tecnico->id)}}" target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Imprimir"><i class="fa fa-print fa-lg" ></i>   </a>
            <div id="auto" onclick="divAuto()">
                <a class="btn  btn-success" style="background: green;border-color: green;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-whatsapp fa-lg" style="color: white"></i>  </a>
            </div>
            <div id="div-mostrar">
                {{-- <br style="width: -1px"> --}}
                <form action="{{route('agregado.whatsapp_send')}}" method="post" class="btn" style="text-align: none;padding-right: 0;padding-left: 0;">
                    @csrf
                    <input type="tel" name="numero"  value="{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->clientes_i->celular}}"  />
                    <input type="text" name="mensaje" id="texto_orden" hidden="" />
                    <input type="text" hidden="" name="url" value="{{route('pdf_informe' ,$garantias_informe_tecnico->id)}}?archivo=">
                    <input type="text" name="name_sin_cambio" hidden="" value="{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->orden_servicio}}" />
                    <button type="submit" class="btn  btn-success" style="background: green;border-color: green;" formtarget="_blank" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar por Whatsapp"><i class="fa fa-send fa-lg"></i>  </button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="margin-top: -2px">
        <div class="ibox-content p-xl" style=" margin-bottom: 2px;padding-bottom: 50px;">
            <div class="row" style="height: 120px">
                <div class="col-sm-4 text-left" align="left">
                    <div class="form-control" align="center" style="height: 79%;" align="left">
                        <img align="center" src="{{asset('img/logos/'.$empresa->foto)}}" style="height: 70px;width: 90%;margin-top: 5px">
                    </div>
                </div>
                <div class="col-sm-4" align="center">
                    <div class="form-control" align="center" style="height: 79%;" align="center">
                        <img align="center" src="{{asset('archivos/imagenes/marcas/'.$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->imagen)}}" style="height: 70px;width: 90%;margin-top: 5px">
                    </div>
                </div>
                <div class="col-sm-4" align="right" >
                    <div class="form-control" align="center" style="height: 79%;" align="right">
                        <h3 style="">R.U.C {{$empresa->ruc}}</h3>
                        <h2 style="font-size: 19px">GUIA DE INFORME TECNICO</h2>
                        <h5>{{$garantias_informe_tecnico->orden_servicio}}</h5>
                    </div>
                </div>
            </div>
            <br>
            <div class="row" align="center" style="padding-bottom: 5px">
                <div class="col-sm-6" align="center">
                    <div class="form-control" style="height: 90%">
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
                            <em>Sin Contacto</em>
                            @else
                            {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->contactos->nombre }}
                            @endif<br> &nbsp;
                            <br>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" align="center">
                 <div class="form-control" style="height: 90%" >
                     <h3>Condiciones Generales</h3>
                     <div align="left">
                        <strong>Ing. Asignado:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{-- {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->nombres}} {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->personal_laborales->personal_l->apellidos}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --}}<br>
                        <strong>Motivo:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->motivo}}<br>
                        <strong>Marca :</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre}} &nbsp;<br>

                        <strong>Asunto:</strong>&nbsp;{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->asunto}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-sm-12" align="center" style="padding-top: 15px;" id="punto">
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
    <div id="vista_update">
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
    </div>
    {{-- Formulario Update --}}
    <div id="form_update" hidden="">
      <form action="{{ route('garantia_informe_tecnico.update',$garantias_informe_tecnico->id) }}"  enctype="multipart/form-data" method="post">
          @csrf
          @method('PATCH')
          <div class="row" align="center" style="padding-bottom: 5px">
            <div class="col-sm-6" align="center">
                <div class="form-control" style="height: 100%" ><h3>Estética</h3>
                    <div align="left" style="font-size: 13px">
                        <textarea name="estetica" class="form-control">{{$garantias_informe_tecnico->estetica}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-6" align="center">
                <div class="form-control" style="height: 100%"><h3>Revision y diagnóstico:</h3>
                    <div align="left" style="font-size: 13px;" >
                       <textarea name="revision_diagnostico" class="form-control">{{$garantias_informe_tecnico->revision_diagnostico}}</textarea>
                   </div>
               </div>
           </div>

       </div>
       <br>
       <div class="row" align="center" style="padding-bottom: 5px">
        <div class="col-sm-6" align="center">
            <div class="form-control" style="height: 100%" ><h3>Causas del Problema</h3>
                <div align="left" style="font-size: 13px;">
                   <textarea name="causas_del_problema" class="form-control">{{$garantias_informe_tecnico->causas_del_problema}}</textarea>
               </div>
           </div>
       </div>
       <div class="col-sm-6" align="center">
        <div class="form-control" style="height: 100%" ><h3>Solución</h3>
            <div align="left" style="font-size: 13px">
             <textarea name="solucion" class="form-control">{{$garantias_informe_tecnico->solucion}}</textarea>
         </div>
     </div>
 </div>
 <div class="col-sm-12" align="center" style="margin-top:20px">
    <button class="btn btn-info">Guardar</button>
</div>
</div>
</form>
</div>
{{-- Formulario Update --}}
<br>
<div class="row" align="center" style="padding-bottom: 5px">
    <div class="col-sm-12" align="center">
        <div class="form-control" style="height: 100%"><h3>Imagenes</h3>
            <div align="left" style="font-size: 13px">
                <div class="row">
                    @foreach($archivo_informe_tecnico as $archivo)
                    <div class="col-sm-4">
                        <img  src="{{asset('archivos/imagenes/informe_tecnico')}}/{{$archivo->archivos}}" style="width:270px;height: 270px;border-radius: 10px">
                        <p></p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div>
</div>
<br>
<footer style="padding-top: 10px">
  <br>
  <div class="row">
   <div class="col-sm-4">
    <strong><p><u>Centro de Atencion : </strong></u></p>
    <strong>Direccion:</strong> {{$usuario->almacen->direccion}}<br>
    <strong>Telefonos :</strong>  {{$empresa->telefono}} / {{$usuario->celular}} &nbsp;<br>
    <strong>{{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->nombre_empresa}}:</strong> {{$garantias_informe_tecnico->garantia_egreso_i->garantia_ingreso_i->marcas_i->telefono}}<br>
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
<script type="text/javascript">
    {{-- Fotooos --}}
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
                '<img name="firma" src="'+e.target.result+'"width="390px" height="200px" />';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
</script>
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
    var clic = 1;
    function divAuto(){
       if(clic==1){
           document.getElementById("div-mostrar").style.height = "50px";
           clic = clic + 1;
       } else{
        document.getElementById("div-mostrar").style.height = "0px";
        clic = 1;
    }
}
</script>
<script>
    function Formulario_edit(){
      var form_update = document.getElementById("form_update");
      var vista_update = document.getElementById("vista_update");
      var boton=document.getElementById("click");
      if( form_update.hasAttribute("hidden") )
      {
          form_update.removeAttribute("hidden", "");
          boton.innerHTML='<i class="fa fa-window-close"></i>';
          vista_update.setAttribute("hidden", "");
          boton.setAttribute("href", "#punto");
      }
      else{
          form_update.setAttribute("hidden", "");
          boton.innerHTML='<i class="fa fa-edit"></i>';
          vista_update.removeAttribute("hidden", "");
          boton.removeAttribute("href", "");

      }

  }
</script>
@endsection
