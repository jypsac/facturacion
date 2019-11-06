<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiaGuiaIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garantia_guia_ingreso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('motivo');
            $table->date('fecha');
            $table->string('orden_servicio');
            $table->boolean('estado');
            $table->boolean('egresado');
            $table->string('asunto');
            $table->string('nombre_equipo');
            $table->string('numero_serie');
            $table->string('codigo_interno');
            $table->date('fecha_compra');
            $table->text('descripcion_problema');
            $table->text('revision_diagnostico');
            $table->text('estetica');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garantia_guia_ingreso');
    }
}
