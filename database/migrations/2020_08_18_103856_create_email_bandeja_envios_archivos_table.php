<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailBandejaEnviosArchivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_bandeja_envios_archivos', function (Blueprint $table) {
            $table->bigIncrements('id');
             $table->unsignedBigInteger('id_bandeja_envios')->nullable();
            $table->foreign('id_bandeja_envios')->references('id')->on('email_bandeja_envios')->onDelete('cascade');
            $table->string('archivo')->nullable();
            $table->string('imagen')->nullable();
            $table->string('fecha_hora');
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
        Schema::dropIfExists('email_bandeja_envios_archivos');
    }
}
