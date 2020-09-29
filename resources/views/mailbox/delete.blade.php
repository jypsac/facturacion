@extends('layout')
@section('title', 'Papelera Email')
@section('breadcrumb', 'Papelera')
@section('breadcrumb2', 'Papelera')
@section('data-toggle', '#')
@section('href_accion', '#')
@section('value_accion', '#')
@section('content') 
       
<div class="fh-breadcrumb">
    @if($count == 0)
    <div class="fh-column">        
    </div>
     <div class="full-height">
        <div class="full-height-scroll white-bg border-left">
        <h2 style="align-content: center;"><center>No hay elementos en la Papelera</center></h2>
        </div>
     </div>
    @else
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
                            <form action="{{route('email.destroy')}}" method="post">    
                                @csrf
                                <input type="hidden" name="id" value="{{$row->id}}" /> 
                                <button class="btn btn-white btn-xs" data-toggle="tooltip" data-placement="top" title="" data-original-title="Move to trash"><i class="fa fa-trash-o"></i> </button>
                            </form>
                            </div>
                        </div>
                        <div class="small text-muted">
                            <i class="fa fa-clock-o"></i> {{$row->fecha_hora}}
                        </div>
                        <span hidden="hidden">{{$remitente_limi=$row->remitente}}
                        {{$remi = substr($remitente_limi, 0, 1)}}</span>
                        <h1><div class="row">
                            <div class="col-sm-1" style=" padding-right: 0px;">
                            <div  class="rounded-circle" style="background: #8D8D8D; width: 50px; height: 50px ;color: white" align="center">{{$str = strtoupper($remi)}}</div>
                            </div>
                            <div class="col-sm-3" style="padding-left: 0px">
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
                            <span><i class="fa fa-paperclip"></i> Archivos </span>
                                {{-- <a href="#">Download all</a>
                                |
                                <a href="#">View all images</a> --}}
                            <div class="attachment">
                                @foreach($mailbox_file as $mailbox_files)
                                @if($mailbox_files->id_bandeja_envios ==  $row->id)
                                @if( isset($mailbox_files->archivo) )
                                <div class="file-box">
                                    <div class="file">
                                        <a href="" download="{{$mailbox_files->archivo}}">
                                            <span class="corner"></span>
                                            <div class="icon">
                                                <i class="fa fa-file-pdf-o"></i>
                                            </div>
                                            <div class="file-name">
                                                {{$mailbox_files->archivo}}
                                                <br>
                                                <small>Añadido: {{$mailbox_files->fecha_hora}}</small>
                                            </div>
                                        </a>

                                    </div>
                                </div>
                                @endif
                                @endif
                                @endforeach

                                @foreach($mailbox_file as $mailbox_files)
                                    @if($mailbox_files->id_bandeja_envios ==  $row->id)
                                        @if( isset($mailbox_files->imagen) )
                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <div class="icon">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                    </div>
                                                    <div class="file-name">
                                                       {{$mailbox_files->imagen}}
                                                        <br>
                                                            <small>Añadido: {{$mailbox_files->fecha_hora}}</small>
                                                    </div>
                                                </a>
                                            </div>

                                        </div>
                                        @endif
                                    @endif
                                @endforeach
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<!-- Mainly scripts -->

<style>
/*#page-wrapper{height: 500px;}*/
.note-toolbar-wrapper{
    height: 0% !important;
}
div.note-editable.card-block{
    max-height: 2% !important;
}
 table.table.table-bordered, td, th {
  border: 1px solid black !important;
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
