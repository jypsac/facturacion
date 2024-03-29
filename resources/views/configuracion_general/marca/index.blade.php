 @extends('layout')

 @section('title', 'MARCA')
 @section('breadcrumb', 'Marca')
 @section('breadcrumb2', 'Marca')
 @section('data-toggle', 'modal')
 @section('href_accion', '#exampleModal')
 @section('value_accion', 'Agregar')
 @section('button2', 'Inicio')
@section('config',route('Configuracion'))

 @section('content')


 <!-- Modal Create  -->

 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('marca.store') }}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <fieldset >
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/marca.svg')}}" width="100px"></div>

                                        <label class="col-sm-2 col-form-label">Nombre:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nombre" required="required">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="abreviatura" required="required">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Telefono:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="telefono" >
                                        </div><label class="col-sm-2 col-form-label">Empresa:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nombre_empresa" required="required">
                                        </div><label class="col-sm-2 col-form-label">Descripcion:</label>
                                        <div class="col-sm-10">
                                            <textarea type="text" class="form-control" name="descripcion" placeholder="opcional"></textarea>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Foto:</label>
                                        <div class="col-sm-10">
                                            <input type="file" style="position:absolute;top:0px;left:0px;right:0px;bottom:0px;width:100%;height:100%;opacity: 0  ;" id="archivoInput" name="imagen" onchange="return validarExt()"  />
                                            <span id="visorArchivo">
                                                <!--Aqui se desplegará el fichero-->
                                                <img name="imagen" src="{{asset('img/logos/marca_ejemplo.svg')}}"  width="300px" height="200px" />
                                            </span>
                                        </span>
                                    </div><script type="text/javascript">
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
                '<img name="imagen" src="'+e.target.result+'"width="300px" height="200px"" />';
            };
            visor.readAsDataURL(archivoInput.files[0]);
        }
    }
}
</script>
</div>
</div>
</div>

</fieldset>
<button class="btn btn-primary" type="submit">Grabar</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</form>
</div>
</div>
</div>
</div>
</div>
<!-- / Modal Create  -->

<div class="wrapper wrapper-content animated fadeInRight">
        @if($errors->any())
    <div style="padding-top: 10px">
          <div class="alert alert-danger">
                <a class="alert-link" href="#">
                  @foreach ($errors->all() as $error)
                  <li style="color: red">{{ $error }}</li>
                  @endforeach
                </a>
          </div>
     </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Marcas</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead align="center">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Abreviatura</th>
                                    <th>Empresa</th>
                                    <th>Telefono</th>
                                    <th>codigo</th>
                                    <th>Descripcion</th>
                                    <th>Foto</th>
                                    <th>Estado</th>
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($marcas as $marca)
                                <tr class="gradeX">
                                    <td>{{$marca->id}}</td>
                                    <td>{{$marca->nombre}}</td>
                                    <td>{{$marca->abreviatura}}</td>
                                    <td>{{$marca->nombre_empresa}}</td>
                                    <td>{{$marca->telefono}}</td>
                                    <td>{{$marca->codigo}}</td>
                                    <td>{{$marca->descripcion}}</td>
                                    <td> @if(isset($marca->imagen))
                                        <img src="{{asset('archivos/imagenes/marcas/'.$marca->imagen)}}" style="width: 150px;height:50px">
                                        @else
                                        <img src="{{asset('img/logos/marca_ejemplo.svg')}}" style="width: 150px;height:50px">
                                        @endif
                                    </td>
                                    @if($marca->estado == 0)
                                        <td><center><label class="label label-primary" style="font-size: 14px">ACTIVADO</label></center></td>
                                    @else
                                        <td><center><label class="label label-danger" style="font-size: 14px">DESACTIVADO</label></center></td>
                                    @endif
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$marca->id}}">Editar</button>
                                        <div class="modal fade" id="exampleModal{{$marca->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('marca.update',$marca->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                               <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/marca.svg')}}" width="100px"></div>
                                                                               <label class="col-sm-2 col-form-label">Nombre:</label>
                                                                               <div class="col-sm-10">
                                                                                <input required="required" type="text" class="form-control" value="{{$marca->nombre}}" name="nombre">
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Abreviatura:</label>
                                                                            <div class="col-sm-10">
                                                                                <input required="required" type="text" class="form-control" value="{{$marca->abreviatura}}" name="abreviatura" readonly="">
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Empresa:</label>
                                                                            <div class="col-sm-10">
                                                                                <input required="required" type="text" class="form-control" value="{{$marca->nombre_empresa}}" name="nombre_empresa">
                                                                            </div>
                                                                             <label class="col-sm-2 col-form-label">Telefono:</label>
                                                                            <div class="col-sm-10">
                                                                                <input  type="text" class="form-control" value="{{$marca->telefono}}" name="telefono">
                                                                            </div><label class="col-sm-2 col-form-label">Descripcion:</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea type="text" class="form-control" placeholder="opcional" name="descripcion"> {{$marca->descripcion}}</textarea>
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Estado:</label>
                                                                            <div class="col-sm-10" align="center">
                                                                                <input type="checkbox" class="js-switch_{{$marca->id}}" name="estado"  @if($marca->estado==0) checked="" @endif />
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Foto:</label>
                                                                            <div class="col-sm-10">
                                                                               <input type="file" style="position:absolute;top:0px;left:0px;right:0px;bottom:0px;width:100%;height:100%;opacity: 0  ;" id="archivoInput{{$marca->id}}" name="imagen" onchange="return validarExt{{$marca->id}}()"  />
                                                                               <span id="visorArchivo{{$marca->id}}">
                                                                                <!--Aqui se desplegará el fichero-->

                                                                                @if(isset($marca->imagen))
                                                                                 <img name="imagen" src="{{asset('archivos/imagenes/marcas/'.$marca->imagen)}}" width="300px" height="200px" />
                                                                                @else
                                                                                <img src="{{asset('img/logos/marca_ejemplo.svg')}}" width="300px" height="200px">
                                                                                @endif

                                                                                <input type="text" name="imagenes" hidden="hidden" value="{{$marca->imagen}}">
                                                                            </span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </fieldset>
                                                        <button class="btn btn-primary" type="submit">Grabar</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- / Modal Create  -->
                            </td>
                        </tr>
                        <script type="text/javascript">
                            {{-- Fotooos --}}
                            function validarExt{{$marca->id}}()
                            {
                                var archivoInput{{$marca->id}} = document.getElementById('archivoInput{{$marca->id}}');
                                var archivoRuta = archivoInput{{$marca->id}}.value;
                                var extPermitidas = /(.jpg|.png|.jfif)$/i;
                                if(!extPermitidas.exec(archivoRuta)){
                                    alert('Asegurese de haber seleccionado una Imagen');
                                    archivoInput{{$marca->id}}.value = '';
                                    return false;
                                }

                                else
                                {
        //PRevio del PDF
        if (archivoInput{{$marca->id}}.files && archivoInput{{$marca->id}}.files[0])
        {
            var visor = new FileReader();
            visor.onload = function(e)
            {
                document.getElementById('visorArchivo{{$marca->id}}').innerHTML =
                '<img name="imagen" src="'+e.target.result+'"width="300px" height="200px" />';
            };
            visor.readAsDataURL(archivoInput{{$marca->id}}.files[0]);
        }
    }
}
</script>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
<style>
    .col-sm-10{padding-bottom: 5px;padding-top: 5px;}
    .form-control{border-radius: 5px}
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
 <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<!-- Switchery -->
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
<script>

    $(document).ready(function () {

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '200px'
        })

    });

</script>
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},

            {extend: 'print',
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');

                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        }
        ]

    });

    });

</script>
@foreach($marcas as $marca)
<script>
    var elem_2 = document.querySelector('.js-switch_{{$marca->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@foreach($marcas as $marca)
<script>
    var elem_2 = document.querySelector('.js-switch_vehiculo{{$marca->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@endsection
