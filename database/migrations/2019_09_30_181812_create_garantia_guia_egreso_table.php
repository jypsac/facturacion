<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiaGuiaEgresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garantia_guia_egreso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('estado');
            $table->boolean('egresado');
            $table->boolean('informe_tecnico');
            $table->text('descripcion_problema');
            $table->text('diagnostico_solucion');
            $table->text('recomendaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garantia_guia_egreso');
    }
}
