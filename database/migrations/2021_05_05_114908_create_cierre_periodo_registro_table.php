<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCierrePeriodoRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierre_periodo_registro', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cierre_periodo_id');
            $table->foreign('cierre_periodo_id')->references('id')->on('cierre_periodo')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->double('costo_nacional');
            $table->double('costo_extranjero');
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
        Schema::dropIfExists('cierre_periodo_registro');
    }
}
