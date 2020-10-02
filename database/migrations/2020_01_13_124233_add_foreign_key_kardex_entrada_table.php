<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyKardexEntradaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex_entrada', function (Blueprint $table) {


            $table->unsignedBigInteger('motivo_id');
            $table->foreign('motivo_id')->references('id')->on('motivos')->onDelete('cascade');

            $table->unsignedBigInteger('provedor_id');
            $table->foreign('provedor_id')->references('id')->on('provedores')->onDelete('cascade');

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');

            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');

            $table->unsignedBigInteger('moneda_id');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');

            $table->string('guia_remision');
            $table->string('factura');
            $table->string('informacion');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
