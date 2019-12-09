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
            $table->string('codigo_original');
            $table->string('nombre');
            $table->integer('utilidad');
            $table->integer('descuento1');
            $table->integer('descuento2');
            $table->integer('descuento_maximo');
           /* $table->string('producto_estado')->default(0);*///activo o desactivado el producto
            $table->text('descripcion');
            $table->text('origen');
            $table->text('precio');
            $table->integer('stock_minimo');
            $table->integer('stock_maximo');
            $table->string('foto');
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
