<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->date('fecha_nacimiento');
            $table->integer('celular');
            $table->integer('telefono');
            $table->string('email')->unique();
            $table->string('genero');
            $table->string('documento_identificacion');
            $table->string('numero_documento');
            $table->string('nacionalidad');
            $table->string('estado_civil');
            $table->string('nivel_educativo');
            $table->string('profesion');
            $table->string('direccion');
            $table->string('foto')->default('perfil.svg');
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
        Schema::dropIfExists('personal');
    }
}
