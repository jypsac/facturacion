@extends('layout')
@section('title', 'Email')
@section('breadcrumb', 'Email')
@section('breadcrumb2', 'Email')
@if( $user->email_creado==0)
@section('href_accion', route('configuracion_email.index'))
@section('value_accion', 'Redactar')
@elseif( $user->email_creado==1)
@section('data-toggle', 'modal')
@section('href_accion', '#redactar')
@section('value_accion', 'Redactar')
@endif
@section('content')
<!-- Modal Create  -->
<div class="modal fade" id="redactar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 700px;margin-left: 400px;">
        <div class="modal-content" style="width: 702px;">
            <div class="modal-header" style="width: 700px;padding-left: 0px;padding-right: 0px;">
                {{--  --}}
                <div class="col-lg-10 container animated fadeInRight" style="width: 600px;padding-left: 0px;padding-right: 0px;margin-right: 30px;margin-left: 60px;">
                    <div class="mail-box">

                        <form action ="{{route('email.store')}}" method="POST" enctype="multipart/form-data" >
                            @csrf
                            <div class="mail-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Para:</label>
                                    <div class="col-sm-10">
                                        <input type="email" required="" class="form-control" name="remitente" list="browsers" autocomplete="off" >
                                        <datalist id="browsers">
                                            @foreach($clientes as $cliente )
                                            <option value="{{$cliente->email}}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="form-group row"><label class="col-sm-2 col-form-label">Asunto:</label>
                                        <div class="col-sm-10"><input type="text" required="" class="form-control" name="asunto" ></div>
                                    </div>
                                </div>
                                <div class="mail-text h-200">
                                    <textarea name="mensaje" required="" class="summernote" id="contents" >
                                    </textarea>
                                </div>
                                <br/>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <span class="btn btn-default btn-file" style="left: 20px !important;">
                                        <span class="fileinput-new">Seleccionar</span>
                                        <span class="fileinput-exists">Cambiar</span>
                                        <input  type="file" name="archivos[]" multiple="" />
                                        <input type="file" name="archivo">
                                    </span>
                                    <span class="fileinput-filename" style="padding-left: 30px"></span>
                                    <a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">×</a>
                                </div>
                                <div class="mail-body text-right tooltip-demo">
                                    <button type="submit" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top"   onclick="doAction(this, 'i', 'Loading')">
                                        <i class="fa fa-reply"></i> Enviar
                                    </button>
                                    <input type="text" name="fecha_hora" value="{{ date('Y-m-d H:i:s') }}" hidden="hidden">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <span id="i" hidden="" ><i  class="fa fa-spinner fa-pulse fa-2x fa-fw"  ></i></span>
                                    <span id="Loading" hidden=""><span style="width: 20px" class="sr-only">Loading...</span></span>

                                </div>
                            </form>
                        </div>
                    </div>
                    {{--  --}}

                </div>
            </div>
        </div>
    </div>
    <!-- / Modal Create  -->




      <div class="fh-breadcrumb">
        <div class="fh-column">
            <div class="full-height-scroll">
                <ul class="list-group elements-list">
                    @foreach($mailbox as $row)
                    <li class="list-group-item">
                        <a class="nav-link" data-toggle="tab" href="#tab-{{$row->id}}" style="padding-top: 5px;padding-bottom: 5px;">
                            <span hidden="hidden">{{$mensaje_limitado=$row->mensaje_sin_html}}
                            {{$cate = substr($mensaje_limitado, 0, 10)}}</span>
                            <strong style="font-size: 10px">{{$row->remitente}}</strong>
                            <div class="small m-t-xs">
                                <p class="m-b-xs">
                                  {{$cate}}...
                              </p>
                              <p class="m-b-none">
                                <i class="fa fa-map-marker"></i> Lima,Perú <span class="float-right text-muted">{{$row->fecha_hora}}</span>
                            </p>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="full-height">
        <div class="full-height-scroll white-bg border-left">

            <div class="element-detail-box">

                <div class="tab-content">
                    @foreach($mailbox as $row)
                    <div id="tab-{{$row->id}}" class="tab-pane">

                        <div class="float-right">
                            <div class="tooltip-demo">
                            {{-- <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="left" title="Plug this message"><i class="fa fa-plug"></i> Plug it</button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="Mark as read"><i class="fa fa-eye"></i> </button>
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mark as important"><i class="fa fa-exclamation"></i> </button> --}}
                            <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to trash"><i class="fa fa-trash-o"></i> </button>

                        </div>
                    </div>
                    <div class="small text-muted">
                        <i class="fa fa-clock-o"></i> {{$row->fecha_hora}}
                    </div>
                    <span hidden="hidden">{{$remitente_limi=$row->remitente}}
                    {{$remi = substr($remitente_limi, 0, 1)}}</span>
                    <h1><div class="row">
                        <div class="col-sm-1">
                            <div  class="rounded-circle" style="background: #8D8D8D; width: 50px; height: 50px ;color: white" align="center">{{$str = strtoupper($remi)}}</div>
                        </div>
                        <div class="col-sm-1" style="padding-left: 0px">
                         {{$row->asunto}}
                     </div>

                 </div></h1>
                 {{-- <img alt="image" class="rounded-circle" src=" {{ asset('/profile/images/')}}/@yield('foto', auth()->user()->personal->foto)" style="width: 50px" /> --}}
                 <h5>to: {{$row->remitente}}</h5>
                 <hr>
                 {!!$row->mensaje!!}
                 <p class="small">
                    {{-- Firma --}}
                    <strong>Best regards, Anthony Smith </strong>
                </p>

                <div class="m-t-lg">
                    <p>
                        <span><i class="fa fa-paperclip"></i> 2 attachments </span>
                            {{-- <a href="#">Download all</a>
                            |
                            <a href="#">View all images</a> --}}
                        </p>

                        <div class="attachment">
                            @if(isset($row->archivo) )
                            <div class="file-box">
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>
                                        <div class="icon">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </div>
                                        <div class="file-name">
                                            Document_2014.doc
                                            <br>
                                            <small>Added: Jan 11, 2014</small>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            @endif
                            <div class="file-box">
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>

                                        <div class="icon">
                                            <i class="fa fa-file-pdf-o"></i>
                                        </div>
                                        <div class="file-name">
                                            Seels_2015.xls
                                            <br>
                                            <small>Added: May 13, 2015</small>
                                        </div>
                                    </a>
                                </div>

                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

        </div>

    </div>
</div>

</div>
<!-- Mainly scripts -->

<style>#page-wrapper{height: 500px;}
.note-toolbar-wrapper{
    height: 0% !important;
}
div.note-editable.card-block{
    max-height: 2% !important;
}
table.table.table-bordered{
    border: currentColor; !important;
}
div.form-group.note-form-group.note-group-select-from-files{
    display: none !important;
}
div.fileinput.fileinput-exists{
    left: 25px !important;
}
span.fileinput-filename{
    left: 25px !importants;
}
</style>
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

<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
 <script>
        function doAction(ele, param1, param2) {
          var a = document.getElementById(param1).innerHTML;
          var b = document.getElementById(param2).innerHTML;
          ele.innerHTML = a + " " + b;
      }</script>
<script type="text/javascript">
    $(function() {
      $('.summernote').summernote({
        height: 200,
    });

  });
</script>
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
@endsection
