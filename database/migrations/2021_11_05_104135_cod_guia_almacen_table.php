<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CodGuiaAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cod_guia_almacen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');
            $table->integer('cod_sunat')->nullable();
            $table->integer('serie_factura')->nullable();
            $table->string('cod_factura')->nullable();
            $table->integer('serie_boleta')->nullable();
            $table->string('cod_boleta')->nullable();
            $table->integer('serie_remision')->nullable();
            $table->string('cod_remision')->nullable();
            $table->integer('serie_nota_credito')->nullable();
            $table->string('cod_nota_credito')->nullable();
            $table->integer('serie_nota_debito')->nullable();
            $table->string('cod_nota_debito')->nullable();
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
        Schema::dropIfExists('cod_guia_almacen');
    }
}
