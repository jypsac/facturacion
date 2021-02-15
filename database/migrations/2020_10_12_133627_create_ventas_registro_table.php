<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_registro', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('numero_cotizacion');
            // $table->string('tipo');
            $table->boolean('estado_aprobado')->nullable();
            $table->boolean('estado_pagado')->nullable();/*Fue pagado el monto de las guias*/
            $table->string('tipo_moneda')->nullable();
            $table->string('monto_comision')->nullable();
            $table->string('monto_final_fac_bol')->nullable();/*Costo final por cada Guia de boleta o Factura*/
            $table->string('estado_anular_fac_bol')->nullable(); // estado anulado o activo de la factura

            $table->string('observacion')->nullable();

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas_registro');
    }
}
