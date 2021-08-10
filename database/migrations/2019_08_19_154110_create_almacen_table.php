<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('abreviatura');
            //codigo sunat hara que los codigos de las boleta y facturas sean de diferenstes sucusrsales -> ANEXO SUNAT
            $table->integer('codigo_sunat');
            // para numero de serie por tipo de documento
            $table->integer('serie_factura')->nullable();
            $table->integer('serie_boleta')->nullable();
            $table->integer('serie_remision')->nullable();
            // F001 - B001 - GR001
            $table->string('cod_postal');
            $table->text('direccion');
            // $table->string('responsable');
            $table->text('descripcion');
            $table->string('cod_fac');
            $table->string('cod_bol');
            $table->string('cod_guia');
            $table->boolean('estado');
            $table->boolean('principal');
            $table->unsignedBigInteger('responsable')->nullable();
            $table->foreign('responsable')->references('id')->on('personal')->onDelete('cascade');

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
        Schema::dropIfExists('almacen');
    }
}
