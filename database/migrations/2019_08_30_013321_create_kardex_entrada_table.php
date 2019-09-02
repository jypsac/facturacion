<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexEntradaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex_entrada', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');//obtiene el modelo
            $table->integer('precio');//precio de compra
            //los comentarios iran en facturacion
            // $table->integer('precio_venta');//precio de venta
            $table->text('serie_producto');//numero de serie el cual son varios codigos del producto que dependen de la cantidad de productos aingresar; se seprn por un punto y coma
            $table->integer('cantidad');
            $table->string('provedor');
            $table->string('informacion');
            // $table->string('nuevo_costo');//precio costo promedio ;depende del modelo del producto()() //promedio de venta
            $table->string('almacen');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex_entrada');
    }
}
