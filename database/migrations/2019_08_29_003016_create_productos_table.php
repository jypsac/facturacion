<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_producto');
            $table->string('codigo_original')->unique();
            $table->string('nombre');
            $table->integer('utilidad');
            $table->integer('descuento1');
            $table->integer('descuento2');
            $table->integer('descuento_maximo');
            $table->text('descripcion');
            $table->text('origen');
            $table->text('garantia');
            $table->integer('stock_minimo');
            $table->integer('stock_maximo');
            $table->string('foto');
            $table->string('estado_anular');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
