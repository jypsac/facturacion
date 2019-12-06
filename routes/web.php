<?php
Route::view('/' , 'home')->name('inicio');

	Route::resource('/almacen','AlmacenController');
	Route::resource('/categoria','CategoriaController');

	Route::post('/cliente/contac','ClienteController@storecontact')->name('cliente.storecontact');
	Route::resource('/cliente','ClienteController');
	Route::resource('/compra','CompraController');
	Route::resource('/cotizacion','CotizacionController');
	Route::resource('/credito','CreditoController');
	Route::resource('/debito','DebitoController');
	Route::resource('/documento','DocumentoController');
	Route::resource('/empresa','EmpresaController')->only(['index']);
	Route::resource('/facturacion','FacturacionController');
	Route::resource('/familia','FamiliaController');

	//Agregado rapido
	Route::post('agregado_rapido/marcas','AgregadoRapidoController@marcas_store')->name('agregado_rapido.marca_store');
	Route::post('agregado_rapido/cliente','AgregadoRapidoController@cliente_store')->name('agregado_rapido.cliente_store');
	Route::post('agregado_rapido/personal_store','AgregadoRapidoController@personal_store')->name('agregado_rapido.personal_store');

	//GARANTIAS
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
	//GARANTIAS


	//CONSULTAS
	Route::get('consultas/garantias-guias-ingreso', 'ConsultasController@garantias_guias_ingreso')->name('consultas.garantias.guias_ingreso');
	Route::get('consultas/garantias-guias-egreso', 'ConsultasController@garantias_guias_egreso')->name('consultas.garantias.guias_egreso');
	Route::get('consultas/garantias-informe-tecnico', 'ConsultasController@garantias_informe_tecnico')->name('consultas.garantias.informe_tecnico');
	//CONSULTAS


	Route::get('contacto/{id}', 'ContactoController@index_id')->name('contacto.index_id');
	Route::get('contacto/crear/{id}', 'ContactoController@crear')->name('contacto.crear');
	Route::resource('/contacto','ContactoController');


	Route::resource('/guia','GuiaController');
	Route::resource('/horarios','HorariosController');
	Route::resource('/igv','IgvController')->only(['index','edit','update']);
	Route::resource('/kardex-entrada','KardexEntradaController');
	Route::resource('/kardex-salida','KardexSalidaController');
	Route::resource('/marca','MarcaController');
	Route::resource('/moneda','MonedaController');
	Route::resource('/pagados','PagadosController');
	Route::resource('/pedidos','PedidosController');
	Route::resource('/personal','PersonalController');
	Route::resource('/personal-datos-laborales','PersonalDatosLaboralesController');
	Route::resource('/productos','ProductosController');
	Route::resource('/promedios','PromediosController');

	Route::get('provedorruc', 'ProvedorController@ruc');
	Route::resource('/provedor','ProvedorController');

	Route::resource('/servicios','ServiciosController');
	Route::resource('/transaccion-compra','TransaccionCompraController');
	Route::resource('/unidad-medida','UnidadMedidaController');
	Route::resource('/usuario','UsuarioController');
	Route::resource('/venta','VentaController');


//
	Route::view('/clasificacion' , 'partials.clasificacion')->name('Clasificacion');
//
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
