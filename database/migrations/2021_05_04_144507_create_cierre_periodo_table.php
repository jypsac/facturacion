<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCierrePeriodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cierre_periodo', function (Blueprint $table) {
	    $table->bigIncrements('id');
	    $table->integer('año');
	    $table->integer('mes');
	    $table->text('ruta_pdf');
	    $table->text('ruta_excel');
        $table->unsignedBigInteger('moneda_id');
        $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');
        $table->double('tipo_cambio');

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
        Schema::dropIfExists('cierre_periodo');
    }
}
