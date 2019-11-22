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
            $table->string('cod_producto');
            $table->string('cod_alternativo');
            $table->string('nombre');
            $table->integer('utilidad');
            $table->integer('descuento');
           /* $table->string('producto_estado')->default(0);*///activo o desactivado el producto
            $table->text('descripcion');
            $table->text('origen');
            $table->text('precio');

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
