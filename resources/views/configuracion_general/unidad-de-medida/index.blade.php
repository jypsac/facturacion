@extends('layout')

@section('title', 'Unidad de Medida')
@section('breadcrumb', 'Unidad de Medida')
@section('breadcrumb2', 'Unidad de Medida')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')

<!-- Modal Create  -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Unidad de Medida</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('unidad-medida.store') }}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <fieldset >
                            <legend> Agregar Unidad de Medida </legend>
                            <div>
                                <div class="panel-body" >
                                    <div class="row">
                                        <label class="col-sm-2 col-form-label">Simbolo:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="simbolo">
                                        </div>
                                        <label class="col-sm-2 col-form-label">Medida:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="medida"  >
                                        </div>
                                        <label class="col-sm-2 col-form-label">Unidad:</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="unidad" placeholder="12.00">
                                        </div>
                                        <div class="col-sm-3">
                                         <button class="btn btn-primary" type="submit">Grabar</button>
                                     </div>
                                     <div class="col-sm-2">
                                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                     </div>
                                 </div>
                             </div>
                         </div>

                     </fieldset>
                       {{--  <button class="btn btn-primary" type="submit">Grabar</button>
                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                   </form>
               </div>
           </div>
       </div>
   </div>
</div>
<!-- / Modal Create  -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Unidad de Medida</h5>
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
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Simbolo</th>
                                    <th>Medida</th>
                                    <th>Unidad</th>
                                    <th>Fecha Creada</th>
                                    <th>Fecha Actualizada</th>
                                    <th>Edidar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($unidad_de_medida as $u_medida)
                                <tr class="gradeX">
                                    <td>{{$u_medida->id}}</td>
                                    <td>{{$u_medida->simbolo}}</td>
                                    <td>{{$u_medida->medida}}</td>
                                    <td>{{$u_medida->unidad}}</td>
                                    <td>{{$u_medida->created_at}}</td>
                                    <td>{{$u_medida->updated_at}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$u_medida->id}}">Editar</button>
                                        <div class="modal fade" id="exampleModal{{$u_medida->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Edit Categoría</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('unidad-medida.update',$u_medida->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <legend> Editar Categoría </legend>
                                                                    <div>
                                                                       <div class="panel-body" >
                                                                        <div class="row">
                                                                            <label class="col-sm-2 col-form-label">Simbolo:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="simbolo" value="{{$u_medida->simbolo}}">
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Medida:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="medida" value="{{$u_medida->medida}}"  >
                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Unidad:</label>
                                                                            <div class="col-sm-4">
                                                                                <input type="text" class="form-control" name="unidad" value="{{$u_medida->unidad}}" placeholder="12.00">
                                                                            </div>
                                                                            <div class="col-sm-3">
                                                                             <button class="btn btn-primary" type="submit">Grabar</button>
                                                                         </div>
                                                                         <div class="col-sm-2">
                                                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                         </div>
                                                                     </div>
                                                                 </div>

                                                             </fieldset>

                                                         </form>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                     <!-- / Modal Create  -->
                                 </td>
                             </tr>
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
    .form-control{border-radius: 5px;margin-top: 5px;margin-bottom: 5px;}
    .col-sm-2{ margin-top:8px;}
    .col-sm-3{ margin-top:8px;}

</style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 10,
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
@endsection