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

            $table->unsignedBigInteger('cotizador_id')->nullable();
            $table->foreign('cotizador_id')->references('id')->on('cotizacion')->onDelete('cascade');

            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('facturacion')->onDelete('cascade');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->string('fecha_emision');
            $table->string('fecha_entrega');

            $table->string('conductor_id')->nullable();

            $table->unsignedBigInteger('vehiculo_id')->nullable();
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');

            $table->string('observacion')->nullable();
            $table->string('motivo_traslado')->nullable();

            $table->string('estado_anulado');
            $table->string('estado_registrado');/*cuando la Facturacion ya lo uso- o se vinculó con la fac*/

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
        Schema::dropIfExists('guia_remision');
    }
}
