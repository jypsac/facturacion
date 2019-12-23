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
            $table->unsignedBigInteger('categorias');
            $table->foreign('categorias')->references('id')->on('categorias')->onDelete('cascade');

            $table->unsignedBigInteger('almacen');
            $table->foreign('almacen')->references('id')->on('almacen')->onDelete('cascade');

            /*$table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');*/

            // $table->unsignedBigInteger('contacto_id');
            // $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
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
        //
    }
}
