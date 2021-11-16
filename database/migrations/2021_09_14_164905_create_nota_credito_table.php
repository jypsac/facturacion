<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaCreditoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_credito', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_n_c');
            $table->unsignedBigInteger('facturacion_id')->nullable();
            $table->foreign('facturacion_id')->references('id')->on('facturacion')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_id')->nullable();
            $table->foreign('boleta_id')->references('id')->on('boleta')->onDelete('cascade');
            $table->string('tipo')->nullable();
            $table->unsignedBigInteger('almacen_id')->nullable();
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');
            $table->string('op_gravada')->default('0');
            $table->string('op_inafecta')->default('0');
            $table->string('op_exonerada')->default('0');
            $table->string('op_gratuita')->default('0');
            $table->string('motivo');
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
        Schema::dropIfExists('nota_credito');
    }
}
