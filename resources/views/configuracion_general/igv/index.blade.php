@extends('layout')
@section('title', 'Configuracion del IGV')
@section('breadcrumb', 'IGV')
@section('breadcrumb2', 'IGV')


@section('content')
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                    <h5>IGV</h5>
                    </div>
                        <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>IGV</th>
                                    <th>Renta</th>
                                    <th>Fecha Creacion</th>
                                    <th>EDITAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeX">
                                    <td>{{$igv->igv_total}}%</td>
                                    <td>{{$igv->renta}}%</td>
                                    <td>{{$igv->updated_at}}</td>
                                   <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Editar</button>
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> Edit IGV</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('igv.update',$igv->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <legend> Editar IGV </legend>
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                                <label class="col-sm-2 col-form-label">IGV:</label>
                                                                                <div class="col-sm-4">
                                                                                    <input type="text" class="form-control" name="igv_total" value="{{$igv->igv_total}}">
                                                                                </div>
                                                                                <label class="col-sm-2 col-form-label">Renta:</label>
                                                                                <div class="col-sm-4">
                                                                                    <input type="text" name="renta" class="form-control" value="{{$igv->renta}}">
                                                                                </div>
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

                        </tbody>
                    </table>
                </div>
            </div>
                    </div>
                </div>
        </div>
	</div>
	<div class="footer">
            <div class="float-right">
                Visitanos: <a href="http://www.jypsac.com"><strong>JYP</strong></a> <
            </div>
            <div>
                <strong>Copyright</strong> JyP Perifericos &copy; 2019-2020
            </div>
    </div>
<!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script>

    $(document).ready(function () {

        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '200px'
        })

    });

</script>

@endsection