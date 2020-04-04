<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_vendedor');
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->string('documento_identificacion');
            $table->string('numero_documento');
            $table->string('nacionalidad');
            $table->string('direccion');
            $table->string('celular');
            $table->string('correo');
            $table->string('comision');
            $table->string('estado');
            $table->string('tipo_trabajador');

            $table->string('foto')->nullable();
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
        Schema::dropIfExists('personal_ventas');
    }
}
