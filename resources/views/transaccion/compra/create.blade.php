@extends('layout')

@section('title', 'Transaccion - Entrada')
@section('breadcrumb', 'Transaccion')
@section('breadcrumb2', 'Transaccion')
@section('href_accion', route('transaccion-compra.index'))
@section('value_accion', 'Agregar')

@section('content')

            {{-- <div class="well well-sm">
                <div class="row">
                    <h1>Provedor</h1>
                </div>
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
            <button>Guardar</button> --}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content m-b-sm border-bottom">
                <div class="p-xs">
                    <div class="float-left m-r-md">
                        <img src="{{asset('img/logos/logo.jpg')}}" style="width: 150px;height: 85px">
                    </div>
                    <form action="" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Provedor:</label>
                                <label class="col-form-label">Ruc:</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="abrev">
                                </div>
                                <label class="col-form-label">Nombre:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="abrev">
                                </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Direccion:</label>
                            <div class="col-sm-11">
                                <input type="text" class="form-control" name="name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Fecha de entrega:</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">Atencion:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">Forma de Pago:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-1 col-form-label">Glosa</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">Moneda:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                            <label class="col-form-label">TC:</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="direccion">
                            </div>
                        </div>
                        <button class="btn btn-primary" name="action">Guardar</button>
                    </form>
                </div>
            </div>
            <div class="ibox-content forum-container">
                <div class="jqGrid_wrapper">
                    <table id="table_list_2"></table>
                    <div id="pager_list_2"></div>
                </div>
            </div>
        </div>
    </div>
</div>



    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>

    <!-- jqGrid -->
    <script src="{{ asset('js/plugins/jqGrid/i18n/grid.locale-en.js') }}"></script>
    <script src="{{ asset('js/plugins/jqGrid/jquery.jqGrid.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>


    <script>
        $(document).ready(function () {


            // Examle data for jqGrid
            var mydata = [
                {id: "1", invdate: "2010-05-24", name: "test", note: "note", tax: "10.00", total: "2111.00"} ,
                {id: "2", invdate: "2010-05-25", name: "test2", note: "note2", tax: "20.00", total: "320.00"},
                {id: "3", invdate: "2007-09-01", name: "test3", note: "note3", tax: "30.00", total: "430.00"},
                {id: "4", invdate: "2007-10-04", name: "test", note: "note", tax: "10.00", total: "210.00"},
                {id: "5", invdate: "2007-10-05", name: "test2", note: "note2", tax: "20.00", total: "320.00"},
                {id: "6", invdate: "2007-09-06", name: "test3", note: "note3", tax: "30.00", total: "430.00"},
                {id: "7", invdate: "2007-10-04", name: "test", note: "note", tax: "10.00", total: "210.00"},
                {id: "8", invdate: "2007-10-03", name: "test2", note: "note2", amount: "300.00", tax: "21.00", total: "320.00"},
                {id: "9", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "11", invdate: "2007-10-01", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "12", invdate: "2007-10-02", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "13", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "14", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "15", invdate: "2007-10-05", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "16", invdate: "2007-09-06", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "17", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "18", invdate: "2007-10-03", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "19", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "21", invdate: "2007-10-01", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "22", invdate: "2007-10-02", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "23", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "24", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "25", invdate: "2007-10-05", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "26", invdate: "2007-09-06", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"},
                {id: "27", invdate: "2007-10-04", name: "test", note: "note", amount: "200.00", tax: "10.00", total: "210.00"},
                {id: "28", invdate: "2007-10-03", name: "test2", note: "note2", amount: "300.00", tax: "20.00", total: "320.00"},
                {id: "29", invdate: "2007-09-01", name: "test3", note: "note3", amount: "400.00", tax: "30.00", total: "430.00"}
            ];

            // Configuration for jqGrid Example 1
            $("#table_list_1").jqGrid({
                data: mydata,
                datatype: "local",
                height: 250,
                autowidth: true,
                shrinkToFit: true,
                rowNum: 14,
                rowList: [10, 20, 30],
                colNames: ['Inv No', 'Date', 'Client', 'Amount', 'Tax', 'Total', 'Notes'],
                colModel: [
                    {name: 'id', index: 'id', width: 60, sorttype: "int"},
                    {name: 'invdate', index: 'invdate', width: 90, sorttype: "date", formatter: "date"},
                    {name: 'name', index: 'name', width: 100},
                    {name: 'amount', index: 'amount', width: 80, align: "right", sorttype: "float", formatter: "number"},
                    {name: 'tax', index: 'tax', width: 80, align: "right", sorttype: "float"},
                    {name: 'total', index: 'total', width: 80, align: "right", sorttype: "float"},
                    {name: 'note', index: 'note', width: 150, sortable: false}
                ],
                pager: "#pager_list_1",
                viewrecords: true,
                caption: "Example jqGrid 1",
                hidegrid: false
            });

            // Configuration for jqGrid Example 2
            $("#table_list_2").jqGrid({
                data: mydata,
                datatype: "local",
                height: 450,
                autowidth: true,
                shrinkToFit: true,
                rowNum: 20,
                rowList: [10, 20, 30],
                colNames:['Inv No','Date', 'Client', 'Amount','Tax','Total','Notes'],
                colModel:[
                    {name:'id',index:'id', editable: true, width:60, sorttype:"int",search:true},
                    {name:'invdate',index:'invdate', editable: true, width:90, sorttype:"date", formatter:"date"},
                    {name:'name',index:'name', editable: true, width:100},
                    {name:'amount',index:'amount', editable: true, width:80, align:"right",sorttype:"float", formatter:"number"},
                    {name:'tax',index:'tax', editable: true, width:80, align:"right",sorttype:"float"},
                    {name:'total',index:'total', editable: true, width:80,align:"right",sorttype:"float"},
                    {name:'note',index:'note', editable: true, width:100, sortable:false}
                ],
                pager: "#pager_list_2",
                viewrecords: true,
                caption: "Tabla",
                add: true,
                edit: true,
                addtext: 'Add',
                edittext: 'Edit',
                hidegrid: false
            });

            // Add selection
            $("#table_list_2").setSelection(4, true);


            // Setup buttons
            $("#table_list_2").jqGrid('navGrid', '#pager_list_2',
                    {edit: true, add: true, del: true, search: true},
                    {height: 200, reloadAfterSubmit: true}
            );

            // Add responsive to jqGrid
            $(window).bind('resize', function () {
                var width = $('.jqGrid_wrapper').width();
                $('#table_list_1').setGridWidth(width);
                $('#table_list_2').setGridWidth(width);
            });


            setTimeout(function(){
                $('.wrapper-content').removeClass('animated fadeInRight');
            },700);

        });

    </script>



@endsection