@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal-Agregar')
@section('breadcrumb2', 'Personal-Agregar')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<style type="text/css">
 .btn-file{position:relative;overflow:hidden}.btn-file input[type=file]{position:absolute;top:0;right:0;min-width:100%;min-height:100%;font-size:999px;text-align:right;filter:alpha(opacity=0);opacity:0;background:red;cursor:inherit;display:block}.file-caption-disabled{background-color:#eee;cursor:not-allowed;opacity:1}.file-input .btn[disabled],.file-input .btn .disabled{cursor:not-allowed}.file-preview{border-radius:5px;border:1px solid #ddd;padding:5px;width:100%;margin-bottom:5px}.file-preview-frame{display:table;margin:8px;height:160px;border:1px solid #ddd;box-shadow:1px 1px 5px 0 #a2958a;padding:6px;float:left;text-align:center}.file-preview-frame:hover{background-color:#eee;box-shadow:2px 2px 5px 0 #333}.file-preview-image{height:150px;vertical-align:text-center}.file-preview-text{display:table-cell;width:150px;height:150px;color:#428bca;font-size:11px;vertical-align:middle;text-align:center}.file-preview-other{display:table-cell;width:150px;height:150px;font-family:Monaco,Consolas,monospace;font-size:11px;vertical-align:middle;text-align:center}.file-input-new .file-preview,.file-input-new .close,.file-input-new .glyphicon-file,.file-input-new .fileinput-remove-button,.file-input-new .fileinput-upload-button{display:none}.loading{background:transparent url('../img/loading.gif') no-repeat scroll center center content-box!important}.wrap-indicator{font-weight:bold;color:#245269;cursor:pointer}.fondo{background: red}
    	
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox">
				<div class="ibox-title">
                    <h5>Datos Personales</h5>
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
					{{-- <form action="{{ route('personal.store') }}"  enctype="multipart/form-data" id="form" class="wizard-big" method="post">
						@csrf
						<h1>Datos Personales</h1>
						<fieldset>
							<h2>Informacion I</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Nombres</label>
										<input type="text" class="form-control" name="nombres" class="form-control required">
									</div>

									<div class="form-group">
										<label>Fecha de Nacimiento</label>
										<input type="text" class="form-control" name="fecha_nacimiento" class="form-control required">
									</div>

									<div class="form-group">
										<label>Telefono</label>
										<input type="text" class="form-control" name="telefono" class="form-control required">
									</div>


								</div>

								<div class="col-lg-6">
									<div class="form-group">
										<label>Apellidos</label>
										<input type="text" class="form-control" name="apellidos" class="form-control required">
									</div>

									<div class="form-group">
										<label>Celular *</label>
										<input type="text" class="form-control" name="celular" class="form-control required">
									</div>
									<div class="form-group">
										<label>Correo</label>
										<input type="text" class="form-control" name="email" class="form-control required">
									</div>
								</div>


							</div>

						</fieldset>
						<h1>Informacion</h1>
						<fieldset>
							<h2>Informacion II</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Genero</label>
										<select class="form-control m-b" name="genero" class="form-control required">
										<option value="masculino">masculino</option>
										<option value="femenino">femenino</option>
										</select>
									</div>

									<div class="form-group">
										<label>Empresas *</label>
										<input type="text" class="form-control" name="empresa" class="form-control required">
									</div>
									<div class="form-group">
										<label>Empresas *</label>
										<input type="text" class="form-control" name="empresa" class="form-control required">
									</div>
								</div>

								<div class="col-lg-6">

									<div class="form-group">
										<label>correo *</label>
										<input id="email" name="email" type="text" class="form-control required email">
									</div>

									<div class="form-group">
										<label>Telefono *</label>
										<input type="number" class="form-control" name="telefono" class="form-control required">
									</div>
									<div class="form-group">
										<label>Empresas *</label>
										<input type="text" class="form-control" name="empresa" class="form-control required">
									</div>

								</div>

							</div>
						</fieldset>
						<h1>Contacto</h1>
						<fieldset>
							<h2>Informacion I</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Nombre *</label>
										<input id="name" name="nombre_contacto" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Cargo *</label>
										<input id="surname" name="cargo_contacto" type="text" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>	Telefono *</label>
										<input id="email" name="telefono_contacto" type="text" class="form-control required">
									</div>
									<div class="form-group">
										<label>Celular *</label>
										<input id="address" name="celular_contacto" type="text" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>	Correo *</label>
										<input id="email" name="email_contacto" type="text" class="form-control required email">
									</div>
								</div>
							</div>
						</fieldset>



					</form> --}}
					<form action="{{ route('personal.store') }}"  enctype="multipart/form-data" method="post">
						@csrf
						<div class="row">
						<div class="col-lg-12">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                General
	                            </div>
	                            <div class="panel-body">
									 
									 	<div class="form-group row">
									 		<label class="col-sm-1 col-form-label">Nombre:</label>
							                    <div class="col-sm-5">
							                     	<input type="text" class="form-control" name="nombres">
							                    </div>

											<label class="col-sm-1 col-form-label">Fecha Nacimiento:</label>
												<div class="col-sm-5">
													<input type="date" class="form-control" name="nombres">
							                    </div>


							                    
						                </div>
						                <div class="form-group row">
										<label class="col-sm-1 col-form-label">Apellidos:</label>
												<div class="col-sm-5">
													<input type="text" class="form-control" name="apellidos">
							                    </div>
							                    <label class="col-sm-1 col-form-label">Genero:</label>
												<div class="col-sm-5">
													<select class="form-control m-b" name="genero">
														<option value="masculino">masculino</option>
														<option value="femenino">femenino</option>
													</select>
							                    </div>
						                </div>
						                <div class="form-group row">

											<label class="col-sm-1 col-form-label">Tipo de Documento:</label>
												<div class="col-sm-5">
												<select class="form-control m-b" name="documento_identificacion">
										 				<option>Seleccione</option>
									  					<option value="Soltero">DNI</option>
									  					<option value="Casado">Pasaporte</option>
									  				</select>
							                    </div>

							                    <label class="col-sm-1 col-form-label">Celular:</label>
							                    <div class="col-sm-5">
							                     	<input type="telefono" class="form-control" name="celular">
							                    </div>

						                </div>
						                 <div class="form-group row">

											<label class="col-sm-1 col-form-label">N° de Documento:</label>
												<div class="col-sm-5">
												<input type="text" class="form-control" name="numero_documento">
							                    </div>


							                    <label class="col-sm-1 col-form-label">Correo:</label>
												<div class="col-sm-5">
													<input type="email" class="form-control" name="email">
							                    </div>
						                </div>

	                            </div>
	                        </div>
	                    </div>
	                    <div class="col-lg-6">
	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                               Otro Datos
	                            </div>
	                            <div class="panel-body">

									 	<div class="form-group row ">

							                <label class="col-sm-2 col-form-label">Estado civil:</label>
												<div class="col-sm-10">
									  				<select class="form-control m-b" name="estado_civil">
										 				<option>Seleccione</option>
									  					<option value="Soltero">Soltero</option>
									  					<option value="Casado">Casado</option>
									  					<option value="Casado">Viudo con hijos</option>
									  					<option value="Casado">Viudo sin hijos</option>

									  				</select>
							                    </div>

							              
						                </div>
						                <div class="form-group row ">

							                <label class="col-sm-2 col-form-label">Estado civil:</label>
												<div class="col-sm-10">
									  				<select class="form-control m-b" name="estado_civil">
										 				<option>Seleccione</option>
									  					<option value="Soltero">Soltero</option>
									  					<option value="Casado">Casado</option>
									  					<option value="Casado">Viudo con hijos</option>
									  					<option value="Casado">Viudo sin hijos</option>

									  				</select>
							                    </div>

							              
						                </div>

						                <div class="form-group row">
									 		<label class="col-sm-2 col-form-label">Profesion:</label>
							                    <div class="col-sm-10">
							                     	<input type="text" class="form-control" name="profesion">
							                    </div>

						                </div>
						                 <div class="form-group row">
									 		

							                    <label class="col-sm-2 col-form-label">Nivel Educativo:</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" name="nivel_educativo">
							                    </div>
						                </div>
						                  <div class="form-group row">
									 		<label class="col-sm-2 col-form-label">Direccion:</label>
							                    <div class="col-sm-10">
							                    	<input type="text" class="form-control" name="direccion">
							                    </div>

							                    
						                </div>
						                 <div class="form-group row">
									 		 <label class="col-sm-2 col-form-label">Pais:</label>
												<div class="col-sm-10">
									  			<select class="form-control m-b" name="nacionalidad">
										  <option>Seleccione</option>
										  @foreach($paises as $pais)
										<option value="{{ $pais->nombre }}">{{ $pais->nombre }}</option>
										@endforeach
										</select>
							                    </div>

							                    
						                </div>
						                 

						        </div>

	                           </div>
	                        </div>
	                        <div class="col-lg-6">

	                        <div class="panel panel-primary">
	                            <div class="panel-heading">
	                                Foto Perfil
	                            </div>
	                            <div class="panel-body">
									 
									 
	                        	
							                    <label class=" col-form-label">Foto De Perfil:</label>
												<div >
													<input id="file-1" type="file" class="file" name="foto" value="Foto">
							                    </div>
	                        </div>
	                        </div>

		                

                		<button class="btn btn-primary" type="submit">Grabar</button>
</div>
					</form>

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

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
	<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

	<!-- Jquery Validate -->
	<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

	<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>

<script>
		function readURL(input) {
		  if (input.files && input.files[0]) {
			var reader = new FileReader();
			
			reader.onload = function(e) {
			  $('#blah').attr('src', e.target.result);
			}
			
			reader.readAsDataURL(input.files[0]);
		  }
		}
		
		$("#imgInp").change(function() {
		  readURL(this);
		});
		</script>

    <script>
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
					// ¡Siempre permita retroceder incluso si el paso actual contiene campos no válidos!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Prohibir suprimir el paso "Advertencia" si el usuario es demasiado joven
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Limpie si el usuario retrocedió antes
                    if (currentIndex < newIndex)
                    {
                        // Para eliminar estilos de error
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Deshabilite la validación en los campos que están deshabilitados u ocultos.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Iniciar validación; Evite avanzar si es falso
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suprima (omita) el paso "Advertencia" si el usuario tiene edad suficiente.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suprima (omita) el paso "Advertencia" si el usuario tiene la edad suficiente y quiere el paso anterior.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

					// Deshabilita la validación en los campos que están deshabilitados.
                    // En este punto, se recomienda hacer una verificación general (significa ignorar solo los campos deshabilitados)
                    form.validate().settings.ignore = ":disabled";

                    // Iniciar validación; Evitar el envío del formulario si es falso
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Enviar entrada de formulario
                    form.submit();
                }
            }).validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
                    });
       });
    </script>
    
    <script type="text/javascript">
    	(function ($) {
    var MAIN_TEMPLATE_1 = '{preview}\n' +
        '<div class="input-group {class}" >\n' +
        '   {caption}\n' +
        '   <div class="input-group-btn">\n' +     
        '       {browse}\n' +
        '   </div>\n' +
        '</div>';

    var MAIN_TEMPLATE_2 = '{preview}\n{browse}\n';

    var PREVIEW_TEMPLATE = '<div class="file-preview {class}">\n' +
        '   <div class="file-preview-status text-center text-success"></div>\n' +
        '   <div class="close fileinput-remove text-right">&times;</div>\n' +
        '   <div class="file-preview-thumbnails"></div>\n' +
        '   <div class="clearfix"></div>' +
        '</div>';

    var CAPTION_TEMPLATE = '<div class="form-control file-caption  {class}">\n' +
        '   <span class="glyphicon glyphicon-file"></span> <span class="file-caption-name"></span>\n' +
        '</div>';

    var MODAL_TEMPLATE = '<div id="{id}" class="modal fade">\n' +
        '  <div class="modal-dialog modal-lg">\n' +
        '    <div class="modal-content">\n' +
        '      <div class="modal-header">\n' +
        '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>\n' +
        '        <h3 class="modal-title">Detailed Preview <small>{title}</small></h3>\n' +
        '      </div>\n' +
        '      <div class="modal-body">\n' +
        '        <textarea class="form-control" style="font-family:Monaco,Consolas,monospace; height: {height}px;" readonly>{body}</textarea>\n' +
        '      </div>\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</div>\n';

    var isEmpty = function (value, trim) {
        return value === null || value === undefined || value == []
            || value === '' || trim && $.trim(value) === '';
    };
    var getValue = function (options, param, value) {
        return (isEmpty(options) || isEmpty(options[param])) ? value : options[param];
    };
    var isImageFile = function (type, name) {
        return (typeof type !== "undefined") ? type.match('image.*') : name.match(/\.(gif|png|jpe?g)$/i);
    };
    var isTextFile = function (type, name) {
        return (typeof type !== "undefined") ? type.match('text.*') : name.match(/\.(txt|md|csv|htm|html|php|ini)$/i);
    };
    var uniqId = function () {
        return Math.round(new Date().getTime() + (Math.random() * 100));
    };
    var FileInput = function (element, options) {
        this.$element = $(element);
        this.showCaption = options.showCaption;
        this.showPreview = options.showPreview;
        this.showRemove = options.showRemove;
        this.showUpload = options.showUpload;
        this.captionClass = options.captionClass;
        this.previewClass = options.previewClass;
        this.mainClass = options.mainClass;
        if (isEmpty(options.mainTemplate)) {
            this.mainTemplate = this.showCaption ? MAIN_TEMPLATE_1 : MAIN_TEMPLATE_2;
        }
        else {
            this.mainTemplate = options.mainTemplate;
        }
        this.previewTemplate = (this.showPreview) ? options.previewTemplate : '';        
        this.captionTemplate = options.captionTemplate;
        this.browseLabel = options.browseLabel;
        this.browseIcon = options.browseIcon;
        this.browseClass = options.browseClass;
        this.removeLabel = options.removeLabel;
        this.removeIcon = options.removeIcon;
        this.removeClass = options.removeClass;
        this.uploadLabel = options.uploadLabel;
        this.uploadIcon = options.uploadIcon;
        this.uploadClass = options.uploadClass;
        this.uploadUrl = options.uploadUrl;
        this.msgLoading = options.msgLoading;
        this.msgProgress = options.msgProgress;
        this.msgSelected = options.msgSelected;
        this.previewFileType = options.previewFileType;
        this.wrapTextLength = options.wrapTextLength;
        this.wrapIndicator = options.wrapIndicator;
        this.isDisabled = this.$element.attr('disabled') || this.$element.attr('readonly');
        if (isEmpty(this.$element.attr('id'))) {
            this.$element.attr('id', uniqId());
        }
        this.$container = this.createContainer();
        /* Initialize plugin option parameters */
        this.$captionContainer = getValue(options, 'elCaptionContainer', this.$container.find('.file-caption'));
        this.$caption = getValue(options, 'elCaptionText', this.$container.find('.file-caption-name'));
        this.$previewContainer = getValue(options, 'elPreviewContainer', this.$container.find('.file-preview'));
        this.$preview = getValue(options, 'elPreviewImage', this.$container.find('.file-preview-thumbnails'));
        this.$previewStatus = getValue(options, 'elPreviewStatus', this.$container.find('.file-preview-status'));
        this.$name = this.$element.attr('name') || options.name;
        this.$hidden = this.$container.find('input[type=hidden][name="' + this.$name + '"]');
        if (this.$hidden.length === 0) {
            this.$hidden = $('<input type="hidden" />');
            this.$container.prepend(this.$hidden);
        }
        this.original = {
            preview: this.$preview.html(),
            hiddenVal: this.$hidden.val()
        };
        this.listen()
    };

    FileInput.prototype = {
        constructor: FileInput,
        listen: function () {
            var self = this;
            self.$element.on('change', $.proxy(self.change, self));
            $(self.$element[0].form).on('reset', $.proxy(self.reset, self));
            self.$container.find('.fileinput-remove').on('click', $.proxy(self.clear, self));
        },
        trigger: function (e) {
            var self = this;
            self.$element.trigger('click');
            e.preventDefault();
        },
        clear: function (e) {
            var self = this;
            if (e) {
                e.preventDefault();
            }

            self.$hidden.val('');
            self.$hidden.attr('name', self.name);
            self.$element.attr('name', '');
            self.$element.val('');
            if (e !== false) {
                self.$element.trigger('change');
                self.$element.trigger('fileclear');
            }
            self.$preview.html('');
            self.$caption.html('');
            self.$container.removeClass('file-input-new').addClass('file-input-new');
        },
        reset: function (e) {
            var self = this;
            self.clear(false);
            self.$hidden.val(self.original.hiddenVal);
            self.$preview.html(self.original.preview);
            self.$container.find('.fileinput-filename').text('');
            self.$element.trigger('filereset');
        },
        change: function (e) {
            var self = this;
            var elem = self.$element, files = elem.get(0).files, numFiles = files ? files.length : 1,
                label = elem.val().replace(/\\/g, '/').replace(/.*\//, ''), preview = self.$preview,
                container = self.$previewContainer, status = self.$previewStatus, msgLoading = self.msgLoading,
                msgProgress = self.msgProgress, msgSelected = self.msgSelected, tfiles,
                fileType = self.previewFileType, wrapLen = parseInt(self.wrapTextLength),
                wrapInd = self.wrapIndicator;

            if (e.target.files === undefined) {
                tfiles = e.target && e.target.value ? [
                    {name: e.target.value.replace(/^.+\\/, '')}
                ] : [];
            }
            else {
                tfiles = e.target.files;
            }
            if (tfiles.length === 0) {
                return;
            }
            preview.html('');
            var total = tfiles.length, self = self;
            for (var i = 0; i < total; i++) {
                (function (file) {
                    var caption = file.name;
                    var isImg = isImageFile(file.type, file.name);
                    var isTxt = isTextFile(file.type, file.name);
                    if (preview.length > 0 && (fileType == "any" ? (isImg || isTxt) : (fileType == "text" ? isTxt : isImg)) && typeof FileReader !== "undefined") {
                        var reader = new FileReader();
                        status.html(msgLoading);
                        container.addClass('loading');
                        reader.onload = function (theFile) {
                            var content = '', modal = "";
                            if (isTxt) {
                                var strText = theFile.target.result;
                                if (strText.length > wrapLen) {
                                    var id = uniqId(), height = window.innerHeight * .75,
                                        modal = MODAL_TEMPLATE.replace("{id}", id).replace("{title}", caption).replace("{body}", strText).replace("{height}", height);
                                    wrapInd = wrapInd.replace("{title}", caption).replace("{dialog}", "$('#" + id + "').modal('show')");
                                    strText = strText.substring(0, (wrapLen - 1)) + wrapInd;
                                }
                                content = '<div class="file-preview-frame"><div class="file-preview-text" title="' + caption + '">' + strText + '</div></div>' + modal;
                            }
                            else {
                                content = '<div class="file-preview-frame" style="margin-left: 15%;"> <img src="' + theFile.target.result + '" class="file-preview-image" title="' + caption + '" alt="' + caption + '" name="foto" style="width:300px ;height:200px ;"></div>';
                            }
                            preview.append("\n" + content);
                            if (i >= total - 1) {
                                container.removeClass('loading');
                                status.html('');
                            }
                        };
                        reader.onprogress = function (data) {
                            if (data.lengthComputable) {
                                var progress = parseInt(((data.loaded / data.total) * 100), 10);
                                var msg = msgProgress.replace('{percent}', progress).replace('{file}', file.name);
                                status.html(msg);
                            }
                        };
                        if (isTxt) {
                            reader.readAsText(file);
                        }
                        else {
                            reader.readAsDataURL(file);
                        }
                    }
                    else {
                        preview.append("\n" + '<div class="file-preview-frame"><div class="file-preview-other"><h2><i class="glyphicon glyphicon-file"></i></h2>' + caption + '</div></div>');
                    }
                })(tfiles[i]);
            }
            var log = numFiles > 1 ? msgSelected.replace('{n}', numFiles) : label;
            self.$caption.html(log);
            self.$container.removeClass('file-input-new');
            elem.trigger('fileselect', [numFiles, label]);
        },
        createContainer: function () {
            var self = this;
            var container = $(document.createElement("div")).attr({"class": 'file-input file-input-new'}).html(self.renderMain());
            self.$element.before(container);
            container.find('.btn-file').append(self.$element);
            return container;
        },
        renderMain: function () {
            var self = this;
            var preview = self.previewTemplate.replace('{class}', self.previewClass);
            var css = self.isDisabled ? self.captionClass + ' file-caption-disabled' : self.captionClass;
            var caption = self.captionTemplate.replace('{class}', css);
            return self.mainTemplate.replace('{class}', self.mainClass).
                replace('{preview}', preview).
                replace('{caption}', caption).
                replace('{upload}', self.renderUpload()).
                replace('{remove}', self.renderRemove()).
                replace('{browse}', self.renderBrowse());
        },
        renderBrowse: function () {
            var self = this, css = self.browseClass + ' btn-file', status = '';
            if (self.isDisabled) {
                status = ' disabled ';
            }
            return '<div class="' + css + '"' + status + '> ' + self.browseIcon + self.browseLabel + ' </div>';
        },
        renderRemove: function () {
            var self = this, css = self.removeClass + ' fileinput-remove fileinput-remove-button', status = '';
            if (!self.showRemove) {
                return '';
            }
            if (self.isDisabled) {
                status = ' disabled ';
            }
            return '<button type="button" class="' + css + '"' + status + '>' + self.removeIcon + self.removeLabel + '</button>';
        },
        renderUpload: function () {
            var self = this, content = '', status = '';
            if (!self.showUpload) {
                return '';
            }
            if (self.isDisabled) {
                status = ' disabled ';
            }
            if (isEmpty(self.uploadUrl)) {
                content = '<button type="submit" class="' + self.uploadClass + '"' + status + '>' + self.uploadIcon + self.uploadLabel + '</button>';
            }
            else {
                content = '<a href="' + self.uploadUrl + '" class="' + self.uploadClass + '"' + status + '>' + self.uploadIcon + self.uploadLabel + '</a>';
            }
            return content;
        },
    }

    $.fn.fileinput = function (options) {
        return this.each(function () {
            var $this = $(this), data = $this.data('fileinput')
            if (!data) {
                $this.data('fileinput', (data = new FileInput(this, options)))
            }
            if (typeof options == 'string') {
                data[options]()
            }
        })
    };

    //FileInput plugin definition
    $.fn.fileinput = function (option) {
        var args = Array.apply(null, arguments);
        args.shift();
        return this.each(function () {
            var $this = $(this),
                data = $this.data('fileinput'),
                options = typeof option === 'object' && option;

            if (!data) {
                $this.data('fileinput', (data = new FileInput(this, $.extend({}, $.fn.fileinput.defaults, options, $(this).data()))));
            }

            if (typeof option === 'string') {
                data[option].apply(data, args);
            }
        });
    };

    $.fn.fileinput.defaults = {
        showCaption: true,
        showPreview: true,
        showRemove: true,
        showUpload: true,
        captionClass: '',
        previewClass: '',
        mainClass: '',
        mainTemplate: null,
        previewTemplate: PREVIEW_TEMPLATE,
        captionTemplate: CAPTION_TEMPLATE,
        browseLabel: 'Seleccione ',
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i> &nbsp;',
        browseClass: 'btn btn-primary',
        removeLabel: 'Remove',
        removeIcon: '<i class="glyphicon glyphicon-ban-circle"></i> ',
        removeClass: 'btn btn-default',
        uploadLabel: 'Upload',
        uploadIcon: '<i class="glyphicon glyphicon-upload"></i> ',
        uploadClass: 'btn btn-default',
        uploadUrl: null,
        msgLoading: 'Loading &hellip;',
        msgProgress: 'Loaded {percent}% of {file}',
        msgSelected: '{n} files selected',
        previewFileType: 'image',
        wrapTextLength: 250,
        wrapIndicator: ' <span class="wrap-indicator" title="{title}" onclick="{dialog}">[&hellip;]</span>',
        elCaptionContainer: null,
        elCaptionText: null,
        elPreviewContainer: null,
        elPreviewImage: null,
        elPreviewStatus: null
    };

    /**
     * Convert automatically file inputs with class 'file'
     * into a bootstrap fileinput control.
     */
    $(function () {
        var $element = $('input.file[type=file]');
        if ($element.length > 0) {
            $element.fileinput();
        }

    });

})(window.jQuery);
    </script>
@stop