<?php
// DB::listen(function($query){
// 	echo "<pre>{$query->sql}</pre>";
// });

Route::group(
	[ 'middleware' => ['auth','cambio_diario']],
	function(){

		// Route::view('/' , 'home')->name('inicio');
		Route::get('/' , 'ViewController@home')->name('inicio');
		Route::post('/whatsapp','AgregadoRapidoController@send_whatsapp')->name('agregado.whatsapp_send');
		Route::resource('/almacen','AlmacenController');
		Route::resource('/apariencia','ConfigController');
		Route::resource('/cotizacion/otros','CotizacionOtrosController');

		Route::resource('/categoria','CategoriaController')->only(['index','create','store','update']);;
		Route::resource('/vendedores','PersonalVentaController');
		Route::put('vendedores/aprobar/{id}', 'PersonalVentaController@aprobar')->name('vendedores.aprobar');
		Route::put('vendedores/procesado/{id}', 'PersonalVentaController@procesado')->name('vendedores.procesado');

		Route::put('vendedores/estado/{id}', 'PersonalVentaController@estado')->name('vendedores.estado');


		Route::resource('/registros','Ventas_registroController');

		Route::post('/cliente/contac','ClienteController@storecontact')->name('cliente.storecontact');
		Route::resource('/cliente','ClienteController');
		Route::resource('/compra','CompraController');


// COTIZACIONES BOLETA - FACTURA
		//boleta

		Route::post('/cotizacion/create_boleta' , 'CotizacionController@create_boleta')->name('cotizacion.create_boleta');
		Route::post('/cotizacion/create_boleta_ms' , 'CotizacionController@create_boleta_ms')->name('cotizacion.create_boleta_ms');
		Route::put('/cotizacion/store_boleta/{id}','CotizacionController@store_boleta')->name('cotizacion.store_boleta');

		//factura

		// Route::get('cotizacion/fast_print', 'CotizacionController@fast_print')->name('cotizacion.fast_print');
		Route::post('/cotizacion/create_factura' , 'CotizacionController@create_factura')->name('cotizacion.create_factura');
		Route::post('/cotizacion/create_factura_ms' , 'CotizacionController@create_factura_ms')->name('cotizacion.create_factura_ms');

		Route::put('/cotizacion/store_factura/{id}','CotizacionController@store_factura')->name('cotizacion.store_factura');
		Route::get('/cotizacion/print_cotizacion/{id}' , 'CotizacionController@print')->name('cotizacion.print');
		Route::post('/cotizacion/facturar/{id}' , 'CotizacionController@facturar')->name('cotizacion.facturar');
		Route::post('/cotizacion/facturar_store' , 'CotizacionController@facturar_store')->name('cotizacion.facturar_store');
		Route::post('/cotizacion/boletear/{id}' , 'CotizacionController@boletear')->name('cotizacion.boletear');
		Route::post('/cotizacion/boletear_store' , 'CotizacionController@boletear_store')->name('cotizacion.boletear_store');
		Route::get('/cotizacion/print_cotizacion_servicio/{id}' , 'CotizacionServiciosController@print')->name('cotizacion_servicio.print');

		Route::resource('/cotizacion','CotizacionController');
		// Route::put('/cotizacion/store/{id_moneda}','CotizacionController@store')->name('cotizacion.store');
		Route::resource('/empresa/banco','BancoController'); //Banco

//COTIZACIOBNES SERVICIO
		//FACTURA
		Route::post('/cotizacion_servicio/create_factura' , 'CotizacionServiciosController@create_factura')->name('cotizacion_servicio.create_factura');
		Route::post('/cotizacion_servicio/create_factura_ms' , 'CotizacionServiciosController@create_factura_ms')->name('cotizacion_servicio.create_factura_ms');
		Route::put('/cotizacion_servicio/store_factura/{id}','CotizacionServiciosController@store_factura')->name('cotizacion_servicio.store_factura');
		Route::get('/cotizacion_servicio/facturar/{id}' , 'CotizacionServiciosController@facturar')->name('cotizacion_servicio.facturar');
		Route::post('/cotizacion_servicio/facturar_store' , 'CotizacionServiciosController@facturar_store')->name('cotizacion_servicio.facturar_store');

		// boleta
		Route::post('/cotizacion_servicio/create_boleta' , 'CotizacionServiciosController@create_boleta')->name('cotizacion_servicio.create_boleta');
		Route::post('/cotizacion_servicio/create_boleta_ms' , 'CotizacionServiciosController@create_boleta_ms')->name('cotizacion_servicio.create_boleta_ms');
		Route::put('/cotizacion_servicio/store_boleta/{id}','CotizacionServiciosController@store_boleta')->name('cotizacion_servicio.store_boleta');
		Route::get('/cotizacion_servicio/boletear/{id}' , 'CotizacionServiciosController@boletear')->name('cotizacion_servicio.boletear');
		Route::post('/cotizacion_servicio/boletear_store' , 'CotizacionServiciosController@boletear_store')->name('cotizacion_servicio.boletear_store');

		Route::resource('/cotizacion_servicio','CotizacionServiciosController')->except(['store']);
		Route::put('/cotizacion_servicio/store/{id_moneda}','CotizacionServiciosController@store')->name('cotizacion.store');

//FACTURACION SERVICIOS
		Route::post('/facturacion_servicio/create_ms','FacturacionServicioController@create_ms')->name('facturacion_servicio.create_ms');
		Route::post('/facturacion_servicio/create','FacturacionServicioController@create')->name('facturacion_servicio.create');
		Route::resource('/facturacion_servicio','FacturacionServicioController')->except(['create']);

//BOLETA SERVICIOS
		Route::post('/boleta_servicio/create_ms','BoletaServicioController@create_ms')->name('boleta_servicio.create_ms');
		Route::post('/boleta_servicio/create','BoletaServicioController@create')->name('boleta_servicio.create');
		Route::resource('/boleta_servicio','BoletaServicioController')->except(['create']);

//FACTURACION ELECTRONICA

		//factura
		Route::post('/facturacion_electronica_factura','FacturacionElectronicaController@factura')->name('facturacion_electronica.factura_sunat');

		Route::resource('/facturacion_electronica','FacturacionElectronicaController');

		Route::resource('/credito','CreditoController');
		Route::resource('/debito','DebitoController');
		Route::resource('/documento','DocumentoController');
		Route::resource('/empresa','EmpresaController')->only(['index','update']);

		// Route::get('facturacion/boleta/{id}' , 'FacturacionController@show_boleta')->name('boleta');
		// Route::get('facturacion/create_boleta/' , 'FacturacionController@create_boleta')->name('create.boleta');
		Route::get('/facturacion/print/{id}','FacturacionController@print')->name('facturacion.print');
		Route::post('/facturacion/create/ajax','FacturacionController@ajax')->name('facturacion.ajax');
		// Route::post('/facturacion/create/sss','FacturacionController@ajax')->name('facturacion.ajax');
		Route::post('/facturacion/create_ajax','FacturacionController@create_ajax')->name('facturacion.create_ajax');

		Route::post('/facturacion/create_ms','FacturacionController@create_ms')->name('facturacion.create_ms');
		// Route::post('/facturacion/store/{id}','FacturacionController@store')->name('facturacion.store');
		Route::resource('/facturacion','FacturacionController')->except(['store','create']);
		Route::post('/facturacion/create','FacturacionController@create')->name('facturacion.create');
		Route::put('/facturacion/store/{id_moneda}','FacturacionController@store')->name('facturacion.store');

		Route::post('/boleta/create_ms','BoletaController@create_ms')->name('boleta.create_ms');
		Route::get('/boleta/print/{id}','BoletaController@print')->name('boleta.print');
		Route::resource('/boleta','BoletaController')->except(['store','create']);
		Route::post('/boleta/create','BoletaController@create')->name('boleta.create');
		Route::put('/boleta/store/{id_moneda}','BoletaController@store')->name('boleta.store');

		/*Guia Remision*/
		//para guia agregar el store en create_moneda secundaria enviando este una acptacion de 2 variables put en store para la identificaion de la moneda principal o secundaria
		Route::get('/guia_remision/print/{id}' , 'GuiaRemisionController@print')->name('guia_remision.print');

		Route::resource('/guia_remision','GuiaRemisionController');

		Route::post('stock_ajax', 'KardexSalidaController@stock_ajax')->name('stock_ajax');
		Route::post('stock_ajax_distribucion', 'KardexEntradaDistribucionController@stock_ajax_distribucion')->name('stock_ajax_distribucion');
		Route::post('stock_ajax_traslado', 'KardexEntradaTrasladoAlmacenController@stock_ajax_traslado')->name('stock_ajax_traslado');
		Route::post('descripcion_ajax', 'CotizacionController@descripcion_ajax')->name('descripcion_ajax');
		Route::post('descripcion_ajax_serv', 'CotizacionServiciosController@descripcion_ajax_serv')->name('descripcion_ajax_serv');

		Route::post('ajax_periodo', 'PeriodoConsultaController@ajax_periodo')->name('ajax_periodo');
		Route::post('ajax_movimiento', 'Consulta_MovimientoController@ajax_movimiento')->name('ajax_movimiento');

		Route::post('ajax_periodo_ventas', 'PeriodoConsultaController@ajax_periodo_ventas')->name('ajax_periodo_ventas');
		Route::post('ajax_movimiento_ventas', 'Consulta_MovimientoController@ajax_movimiento_ventas')->name('ajax_movimiento_ventas');
		Route::post('ajax_movimiento_ventas_b', 'Consulta_MovimientoController@ajax_movimiento_ventas_b')->name('ajax_movimiento_ventas_b');

		Route::get('guias_remision/seleccionar', 'GuiaRemisionController@seleccionar')->name('guia_remision.seleccionar');
		Route::put('cotizacion/aprobar/{id}', 'CotizacionController@aprobar')->name('cotizacion.aprobar');
		Route::get('/guias_remision/creates/{id}' , 'GuiaRemisionController@cotizacion')->name('guias_remision.create');
		// Route::get('/guia_remision/print/{id}' , 'GuiaRemisionController@print')->name('guias_remision.print');

		/**/
		Route::resource('/vehiculo','VehiculoController');

		Route::resource('/familia','FamiliaController');

		//Agregado rapido
		Route::post('agregado_rapido/marcas','AgregadoRapidoController@marcas_store')->name('agregado_rapido.marca_store');
		Route::post('agregado_rapido/cliente','AgregadoRapidoController@cliente_store')->name('agregado_rapido.cliente_store');

		Route::post('agregado_rapido/cliente/cotizacion','AgregadoRapidoController@cliente_cotizado')->name('agregado_rapido.cliente_cotizado');

		Route::post('agregado_rapido/personal_store','AgregadoRapidoController@personal_store')->name('agregado_rapido.personal_store');

		//MailBox
		Route::resource('/email','EmailBandejaEnviosController');
		Route::resource('/configuracion_email','EmailConfiguracionesController');
		Route::post('/email/config/pdf','EmailConfiguracionesController@store')->name('email.config');
		Route::post('/email/save','EmailBandejaEnviosController@save')->name('email.save');
		Route::post('email/send','EmailBandejaEnviosController@send')->name('email.send');
		Route::post('email/delete','EmailBandejaEnviosController@delete')->name('email.delete');
		Route::get('/trash','EmailBandejaEnviosController@trash')->name('email.trash');
		Route::post('/trash/delete','EmailBandejaEnviosController@destroy')->name('email.destroy');
		Route::post('/email/config','EmailBandejaEnviosController@configstore')->name('email.configstore');
		Route::post('/email/config/{id}','EmailBandejaEnviosController@configupdate')->name('email.configupdate');
		Route::get('/email_backup','EmailConfiguracionesController@email_backup')->name('email_backup');
		Route::post('/email_backup/save','EmailConfiguracionesController@backup_save')->name('backup_save');

		//Garantias
		Route::get('contacto_cliente','GarantiaGuiaIngresoController@contacto_cliente');
		Route::get('contacto_cliente_actualizar','GarantiaGuiaIngresoController@contacto_cliente_actualizar');
		Route::POST('garantia_guia_ingreso/email/enviar','GarantiaGuiaIngresoController@enviar')->name('garantia_ingreso.enviar');
		Route::get('garantia_guia_ingreso/email/{id}','GarantiaGuiaIngresoController@email')->name('guia_ingreso.email');

		Route::get('garantia_guia_ingreso/impresionIngreso/{id}' , 'GarantiaGuiaIngresoController@print')->name('impresiones_ingreso');
		Route::put('garantia_guia_ingreso/{guia}', 'GarantiaGuiaIngresoController@actualizar')->name('garantia_guia_ingreso.actualizar');
		Route::resource('/garantia_guia_ingreso','GarantiaGuiaIngresoController');


		Route::POST('garantia_guia_egreso/email/enviar','GarantiaGuiaEgresoController@enviar')->name('garantia_egreso.enviar');
		Route::get('garantia_guia_egreso/email/{id}','GarantiaGuiaEgresoController@email')->name('guia_egreso.email');

		Route::get('garantia_guia_egreso/impresionEgreso/{id}' , 'GarantiaGuiaEgresoController@print')->name('impresiones_egreso');
		Route::get('garantia_guia_egreso/guias', 'GarantiaGuiaEgresoController@guias')->name('garantia_guia_egreso.guias');
		Route::resource('/garantia_guia_egreso','GarantiaGuiaEgresoController');


		Route::get('garantia_informe_tecnico/impresionInformeTecnico/{id}' , 'GarantiaInformeTecnicoController@print')->name('impresiones_informe');
		Route::get('garantia_informe_tecnico/{id}/actualizar', 'GarantiaInformeTecnicoController@actualizar')->name('garantia_informe_tecnico.actualizar');
		Route::get('garantia_informe_tecnico/guias', 'GarantiaInformeTecnicoController@guias')->name('garantia_informe_tecnico.guias');

		Route::resource('/garantia_informe_tecnico','GarantiaInformeTecnicoController');

		//Consultas
		Route::get('consultas/garantias-guias-ingreso', 'ConsultasController@garantias_guias_ingreso')->name('consultas.garantias.guias_ingreso');
		Route::get('consultas/garantias-guias-egreso', 'ConsultasController@garantias_guias_egreso')->name('consultas.garantias.guias_egreso');
		Route::get('consultas/garantias-informe-tecnico', 'ConsultasController@garantias_informe_tecnico')->name('consultas.garantias.informe_tecnico');

		Route::get('contacto/{id}', 'ContactoController@index_id')->name('contacto.index_id');
		Route::get('contacto/crear/{id}', 'ContactoController@crear')->name('contacto.crear');
		Route::get('contacto/editar/{id}', 'ContactoController@editar')->name('contacto.editar');
		Route::resource('/contacto','ContactoController');

		Route::resource('/guia','GuiaController');
		Route::resource('/horarios','HorariosController');
		Route::resource('/igv','IgvController')->only(['index','edit','update']);
		Route::resource('/fe_configuracion','FEConfigController')->only(['index','edit','update']);

		//Inventarios
		Route::resource('/inventario-inicial','InventarioInicialController');

		// Route::post('/autocomplete/fetch', 'KardexEntradaController@fetch')->name('autocomplete.fetch');
		// Route::get('autocomplete', 'KardexEntradaController@search');
		// Route::get('kardex_entrada_productos','KardexEntradaController@productos');

		Route::resource('/kardex-entrada-Distribucion','KardexEntradaDistribucionController');
		Route::resource('/kardex-entrada','KardexEntradaController');

		Route::post('/kardex-entrada-Traslado-almacen/create','KardexEntradaTrasladoAlmacenController@create')->name('kardex-entrada-Traslado-almacen.create');
		Route::resource('/kardex-entrada-Traslado-almacen','KardexEntradaTrasladoAlmacenController')->except(['create']);

		Route::post('/kardex-salida/create' , 'KardexSalidaController@create')->name('kardex-salida.create');
		Route::resource('/kardex-salida','KardexSalidaController')->except(['create']);
		Route::resource('/periodo-consulta','PeriodoConsultaController');
		Route::resource('/movimiento-consulta','Consulta_MovimientoController');
		Route::resource('/cierre-periodo','CierrePeriodoController');
		Route::get('/cierre-periodo/pdf/{id}','CierrePeriodoController@pdf')->name('cierre-periodo.pdf');

		//Fin de inventarios
		Route::resource('/motivo','MotivoController');
		Route::resource('/marca','MarcaController');
		Route::resource('/moneda','MonedaController');
		Route::resource('/pagados','PagadosController');
		Route::resource('/pedidos','PedidosController');
		Route::resource('/personal','PersonalController');

		Route::get('/personal-laboral/{id}','PersonalDatosLaboralesController@idpersonal')->name('create.laboral');
		Route::resource('/personal-datos-laborales','PersonalDatosLaboralesController');
		Route::resource('/productos','ProductosController');
		Route::resource('/promedios','PromediosController');

		Route::post('/provedor/add','ProvedorController@store_kardex')->name('provedor.store_kardex');

		//Agregado Rapido
		Route::get('provedorruc', 'ProvedorController@ruc');
		Route::get('clienteruc', 'ClienteController@ruc');
		Route::resource('/provedor','ProvedorController');

		Route::resource('/servicios','ServiciosController');
		Route::resource('/transaccion-compra','TransaccionCompraController');
		Route::resource('/unidad-medida','UnidadMedidaController');


		//Usuarios
		Route::get('/usuario/lista','UsuarioController@lista')->name('usuario.lista');
		Route::get('usuario/crear/{id}','UsuarioController@crear')->name('usuario.crear');
		Route::post('usuario/creacion/{guia}', 'UsuarioController@creacion')->name('usuario.creacion');
		Route::post('usuario/envio_codigo/{id}', 'UsuarioController@envio_codigo')->name('usuario.envio_codigo');
		Route::post('usuario/activar/{id}', 'UsuarioController@activar')->name('usuario.activar');
		Route::get('usuario/permiso/{id}','UsuarioController@permiso')->name('usuario.permiso');
		Route::post('usuario/permisos/asignar/{id}','UsuarioController@asignar_permiso')->name('usuario.asignar_permiso');
		Route::post('usuario/permisos/delegar/{id}','UsuarioController@delegar_permiso')->name('usuario.delegar_permiso');
		Route::resource('/usuario','UsuarioController');
		Route::resource('/venta','VentaController');

		Route::resource('/cantidad_precio','CantidadPrecioController');

		Route::view('/configuracion_general' , 'configuracion_general.configuracion_general')->name('Configuracion');


		//Ajax
		// Route::get('/inventario.kardex.entrada.create', 'KardexEntradaController@index');
		// Route::post('/inventario.kardex.entrada.create/fetcha', 'KardexEntradaController@fetcha')->name('autocomplete.fetcha');

	});
Auth::routes();
Route::post('sunat_cambio','TipoCambioController@sunat_cambio');
Route::resource('/tipo_cambio','TipoCambioController')->middleware('auth');
Route::get('garantia_guia_ingreso/pdf/{id}' , 'GarantiaGuiaIngresoController@pdf')->name('pdf_ingreso');
Route::get('garantia_guia_egreso/pdf/{id}' , 'GarantiaGuiaEgresoController@pdf')->name('pdf_egreso');
Route::get('garantia_informe_tecnico/pdf/{id}' , 'GarantiaInformeTecnicoController@pdf')->name('pdf_informe');
Route::get('cotizacion/pdf/{id}' , 'CotizacionController@pdf')->name('pdf_cotizacion');
Route::get('cotizacion_servicio/pdf/{id}' , 'CotizacionServiciosController@pdf')->name('pdf_cotizacion_servicio');
Route::get('guia_remision/pdf/{id}' , 'GuiaRemisionController@pdf')->name('pdf_guia');
Route::get('facturacion/pdf/{id}' , 'FacturacionController@pdf')->name('pdf_fac');
Route::get('boleta/pdf/{id}' , 'BoletaController@pdf')->name('pdf_bol');
Route::post('periodo_consulta/pdf' , 'PeriodoConsultaController@pdf')->name('periodo_consulta_pdf');
Route::post('periodo_consulta/print' , 'PeriodoConsultaController@print')->name('periodo_consulta_print');
Route::get('/home', 'HomeController@index')->name('home');

