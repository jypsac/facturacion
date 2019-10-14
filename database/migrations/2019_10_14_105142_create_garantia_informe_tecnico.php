<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiaInformeTecnico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garantia_informe_tecnico', function (Blueprint $table) {
            $table->bigIncrements('id');

            //GENERAL
            $table->string('marca');
            $table->string('motivo');
            $table->string('ing_asignado');
            $table->date('fecha');
            $table->string('orden_servicio');
            $table->boolean('estado');
            $table->boolean('egresado');
            $table->boolean('informe_tecnico');
            $table->string('asunto');
            //DATOS DEL CLIENTE
            $table->string('nombre_cliente');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('correo');
            $table->string('contacto');
            //DATOS DEL EQUIPO
            $table->string('nombre_equipo');
            $table->string('numero_serie');
            $table->string('codigo_interno');
            $table->date('fecha_compra');
            //DESCRIPCION DEL PROBLEMA
            $table->text('descripcion_problema');
            //REVISION Y DIAGNOSTICO
            $table->text('revision_diagnostico');
            //TEXTO
            $table->text('informe');

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
        Schema::dropIfExists('garantia_informe_tecnico');
    }
}
