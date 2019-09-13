@extends('layout')

@section('title', 'Transaccion - Entrada')
@section('breadcrumb', 'Transaccion')
@section('breadcrumb2', 'Transaccion')
@section('href_accion', route('transaccion-compra.index'))
@section('value_accion', 'Agregar')

@section('content')

            <div class="well well-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <input id="cliente" class="form-control typeahead" type="text" placeholder="Cliente" />
                    </div>
                    <div class="col-xs-2">
                        <input id="ruc" class="form-control" type="text" placeholder="Ruc" />
                    </div>
                    <div class="col-xs-4">
                        <input id="direccion" class="form-control" type="text" placeholder="Dirección"  />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-7">
                    <input id="producto" class="form-control" type="text" placeholder="Nombre del producto" />
                </div>
                <div class="col-xs-2">
                    <input id="cantidad" class="form-control" type="text" placeholder="Cantidad" />
                </div>
                <div class="col-xs-2">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">S/.</span>
                        <input id="precio" class="form-control" type="text" placeholder="Precio"  />
                    </div>
                </div>
                <div class="col-xs-1">
                    <button class="btn btn-primary form-control" id="adicionar">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
                </div>
            </div>

            <hr />

            <p>Elementos en la Tabla:
            <div id="adicionados"></div>
            </p>
            <table id="mytable" class="table table-bordered table-hover ">
              <tr>
                <th>Nobmre</th>
                <th>Apellidos</th>
                <th>C&eacute;dula</th>
                <th>Eliminar</th>

              </tr>
            </table>
            <button>Guardar</button>
            <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
                <script src="{{ asset('js/popper.min.js') }}"></script>
                <script src="{{ asset('js/bootstrap.js') }}"></script>
                <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
                <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

                <!-- Custom and plugin javascript -->
                <script src="{{ asset('js/inspinia.js') }}"></script>
                <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>




            <script type="text/javascript">
            $(document).ready(function() {
            //obtenemos el valor de los input

            $('#adicionar').click(function() {
              var nombre = document.getElementById("cliente").value;
              var apellido = document.getElementById("ruc").value;
              var cedula = document.getElementById("direccion").value;
              var i = 1; //contador para asignar id al boton que borrara la fila
              var fila = '<tr id="row' + i + '"><td>' + nombre + '</td><td>' + apellido + '</td><td>' + cedula + '</td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove">Quitar</button></td></tr>'; //esto seria lo que contendria la fila

              i++;

              $('#mytable tr:first').after(fila);
                $("#adicionados").text(""); //esta instruccion limpia el div adicioandos para que no se vayan acumulando
                var nFilas = $("#mytable tr").length;
                $("#adicionados").append(nFilas - 1);
                //le resto 1 para no contar la fila del header
                document.getElementById("apellido").value ="";
                document.getElementById("cedula").value = "";
                document.getElementById("nombre").value = "";
                document.getElementById("nombre").focus();
              });
            $(document).on('click', '.btn_remove', function() {
              var button_id = $(this).attr("id");
                //cuando da click obtenemos el id del boton
                $('#row' + button_id + '').remove(); //borra la fila
                //limpia el para que vuelva a contar las filas de la tabla
                $("#adicionados").text("");
                var nFilas = $("#mytable tr").length;
                $("#adicionados").append(nFilas - 1);
              });
            });
            </script>


@endsection


