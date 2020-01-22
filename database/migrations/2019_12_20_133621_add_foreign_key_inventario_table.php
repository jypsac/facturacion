<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inventario_inicial', function (Blueprint $table) {
            $table->unsignedBigInteger('categorias_id');
            $table->foreign('categorias_id')->references('id')->on('categorias')->onDelete('cascade');

            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');

            $table->unsignedBigInteger('articulo_id');
            $table->foreign('articulo_id')->references('id')->on('productos')->onDelete('cascade');

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
        Schema::dropIfExists('inventario_inicial');
    }
}
