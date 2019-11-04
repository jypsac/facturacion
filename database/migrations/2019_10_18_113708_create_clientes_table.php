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
            $table->string('nombre')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('empresa')->nullable();
            $table->string('documento_identificacion')->nullable();
            $table->string('numero_documento')->nullable();
            $table->timestamps();
        });

        Schema::create('contactos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('cargo');
            $table->string('telefono');
            $table->string('celular');
            $table->string('email');
            $table->unsignedBigInteger('clientes_id');
            $table->foreign('clientes_id')->references('id')->on('clientes');
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
