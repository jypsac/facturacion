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
            //Datos Laborales
            $table->date('fecha_vinculacion')->nullable();
            $table->date('fecha_retiro')->nullable();
            $table->string('forma_pago')->nullable();
            $table->integer('salario')->nullable();
            $table->string('categoria_ocupacional')->nullable();
            $table->string('estado_trabajador')->nullable();
            $table->string('sede')->nullable();
            $table->string('turno')->nullable();
            $table->string('departamento_area')->nullable();
            $table->string('cargo')->nullable();
            $table->string('tipo_trabajador')->nullable();
            $table->string('tipo_contrato')->nullable();
            $table->string('regimen_pensionario')->nullable();
            $table->string('afiliacion_salud')->nullable();
            $table->string('banco_renumeracion')->nullable();
            $table->integer('numero_cuenta')->nullable();
            $table->text('notas')->nullable();
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
