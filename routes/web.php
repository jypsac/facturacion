<?php
Route::view('/' , 'home')->name('inicio');

	Route::resource('/almacen','AlmacenController');
	Route::resource('/categoria','CategoriaController');
	Route::resource('/cliente','ClienteController');
	Route::resource('/compra','CompraController');
	Route::resource('/cotizacion','CotizacionController');
	Route::resource('/credito','CreditoController');
	Route::resource('/debito','DebitoController');
	Route::resource('/documento','DocumentoController');
	Route::resource('/empresa','EmpresaController')->only(['index']);
	Route::resource('/facturacion','FacturacionController');
	Route::resource('/familia','FamiliaController');
	
	//GARANTIAS
	Route::put('garantia_guia_ingreso/{guia}', 'GarantiaGuiaIngresoController@actualizar')->name('garantia_guia_ingreso.actualizar');
	Route::resource('/garantia_guia_ingreso','GarantiaGuiaIngresoController');

	Route::get('garantia_guia_egreso/guias', 'GarantiaGuiaEgresoController@guias')->name('garantia_guia_egreso.guias');
	Route::resource('/garantia_guia_egreso','GarantiaGuiaEgresoController');

	Route::get('garantia_informe_tecnico/{id}/actualizar', 'GarantiaInformeTecnicoController@actualizar')->name('garantia_informe_tecnico.actualizar');
	Route::get('garantia_informe_tecnico/guias', 'GarantiaInformeTecnicoController@guias')->name('garantia_informe_tecnico.guias');
	
	Route::resource('/garantia_informe_tecnico','GarantiaInformeTecnicoController');
	//GARANTIAS

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
