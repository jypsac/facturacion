<?php
// DB::listen(function($query){
// 	echo "<pre>{$query->sql}</pre>";
// });

Route::group(
	[ 'middleware' => 'auth' ],

		function(){

		// Route::view('/' , 'home')->name('inicio');
		Route::get('/' , 'ViewController@home')->name('inicio');

		Route::resource('/almacen','AlmacenController');
		Route::resource('/categoria','CategoriaController');
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

		Route::get('/cotizacion/create_boleta' , 'CotizacionController@create_boleta')->name('cotizacion.create_boleta');
		Route::post('/cotizacion/store_boleta','CotizacionController@store_boleta')->name('cotizacion.store_boleta');
		

		//factura

		// Route::get('cotizacion/fast_print', 'CotizacionController@fast_print')->name('cotizacion.fast_print');
		Route::get('/cotizacion/create_factura' , 'CotizacionController@create_factura')->name('cotizacion.create_factura');
		Route::post('/cotizacion/store_factura','CotizacionController@store_factura')->name('cotizacion.store_factura');
		Route::get('/cotizacion/print_cotizacion/{id}' , 'CotizacionController@print')->name('cotizacion.print');
		Route::get('/cotizacion/facturar/{id}' , 'CotizacionController@facturar')->name('cotizacion.facturar');

		Route::resource('/cotizacion','CotizacionController');



		Route::resource('/credito','CreditoController');
		Route::resource('/debito','DebitoController');
		Route::resource('/documento','DocumentoController');
		Route::resource('/empresa','EmpresaController')->only(['index']);

		Route::get('facturacion/boleta/{id}' , 'FacturacionController@show_boleta')->name('boleta');
		Route::get('facturacion/create_boleta/' , 'FacturacionController@create_boleta')->name('create.boleta');
		Route::resource('/facturacion','FacturacionController');
		
		Route::resource('/familia','FamiliaController');

		//Agregado rapido
		Route::post('agregado_rapido/marcas','AgregadoRapidoController@marcas_store')->name('agregado_rapido.marca_store');
		Route::post('agregado_rapido/cliente','AgregadoRapidoController@cliente_store')->name('agregado_rapido.cliente_store');

		Route::post('agregado_rapido/cliente/cotizacion','AgregadoRapidoController@cliente_cotizado')->name('agregado_rapido.cliente_cotizado');
		
		Route::post('agregado_rapido/personal_store','AgregadoRapidoController@personal_store')->name('agregado_rapido.personal_store');

		//Garantias
		Route::get('garantia_guia_ingreso/pdf/{id}' , 'GarantiaGuiaIngresoController@pdf')->name('pdf_ingreso');
		Route::get('garantia_guia_ingreso/impresionIngreso/{id}' , 'GarantiaGuiaIngresoController@print')->name('impresiones_ingreso');
		Route::put('garantia_guia_ingreso/{guia}', 'GarantiaGuiaIngresoController@actualizar')->name('garantia_guia_ingreso.actualizar');
		Route::resource('/garantia_guia_ingreso','GarantiaGuiaIngresoController');

		Route::get('garantia_guia_egreso/pdf/{id}' , 'GarantiaGuiaEgresoController@pdf')->name('pdf_egreso');
		Route::get('garantia_guia_egreso/impresionEgreso/{id}' , 'GarantiaGuiaEgresoController@print')->name('impresiones_egreso');
		Route::get('garantia_guia_egreso/guias', 'GarantiaGuiaEgresoController@guias')->name('garantia_guia_egreso.guias');
		Route::resource('/garantia_guia_egreso','GarantiaGuiaEgresoController');

		Route::get('garantia_informe_tecnico/pdf/{id}' , 'GarantiaInformeTecnicoController@pdf')->name('pdf_informe');
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

		//Inventarios
		Route::resource('/inventario-inicial','InventarioInicialController');

		Route::post('/autocomplete/fetch', 'KardexEntradaController@fetch')->name('autocomplete.fetch');
		Route::get('autocomplete', 'KardexEntradaController@search');
		Route::get('kardex_entrada_productos','KardexEntradaController@productos');
		Route::resource('/kardex-entrada','KardexEntradaController');
		Route::resource('/kardex-salida','KardexSalidaController');
		Route::resource('/periodo-consulta','PeriodoConsultaController');

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
		Route::resource('/provedor','ProvedorController');

		Route::resource('/servicios','ServiciosController');
		Route::resource('/transaccion-compra','TransaccionCompraController');
		Route::resource('/unidad-medida','UnidadMedidaController');
		Route::resource('/usuario','UsuarioController');
		Route::resource('/venta','VentaController');
		Route::resource('/tipo_cambio','TipoCambioController');

		Route::view('/clasificacion' , 'partials.clasificacion')->name('Clasificacion');

		//Ajax
		Route::get('/inventario.kardex.entrada.create', 'KardexEntradaController@index');
		Route::post('/inventario.kardex.entrada.create/fetcha', 'KardexEntradaController@fetcha')->name('autocomplete.fetcha');

	});
	Auth::routes();

	Route::get('/home', 'HomeController@index')->name('home');
