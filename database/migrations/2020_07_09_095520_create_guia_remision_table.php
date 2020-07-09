<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaRemisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_remision', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_guia');
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->string('fecha_emision');
            $table->string('fecha_entrega');

            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');

            $table->string('estado_anulado');
            $table->string('estado_registrado');    
            $table->string('user_id');
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
        Schema::dropIfExists('guia_remision');
    }
}
