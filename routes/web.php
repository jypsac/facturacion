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
	//GARANTIA
	Route::resource('/garantia_guia_ingreso','GarantiaGuiaIngresoController');

	Route::resource('/garantia_guia_egreso','GarantiaGuiaEgresoController');
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
