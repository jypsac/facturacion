<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre') ;
            $table->string('direccion');
            $table->string('email');
            $table->string('telefono')->nullable();
            $table->string('anexo')->nullable();
            $table->string('celular')->nullable();
            $table->string('empresa')->nullable();
            $table->string('documento_identificacion');
            $table->string('numero_documento')->unique();
            // Nuevo
            $table->string('ciudad')->nullable();
            $table->string('departamento')->nullable();
            $table->string('pais')->nullable();
            $table->string('tipo_cliente')->nullable();
            $table->string('cod_postal')->nullable();
            $table->string('aniversario')->nullable();
            $table->string('fecha_registro')->nullable();
            //
            $table->timestamps();
        });

        Schema::create('contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('primer_contacto')->default('0');
            $table->string('nombre');
            $table->string('cargo');
            $table->string('telefono');
            $table->string('celular');
            $table->string('email');
            $table->unsignedBigInteger('clientes_id');
            $table->foreign('clientes_id')->references('id')->on('clientes')->onDelete('cascade');
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
        Schema::dropIfExists('contactos');
        Schema::dropIfExists('clientes');
    }
}
