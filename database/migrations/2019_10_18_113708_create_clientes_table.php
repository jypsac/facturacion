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
            $table->string('nombre')->unique();
            $table->string('direccion');
            $table->string('email')->unique();
            $table->string('telefono');
            $table->string('celular');
            $table->string('empresa')->nullable();;
            $table->string('documento_identificacion');
            $table->string('numero_documento');
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
