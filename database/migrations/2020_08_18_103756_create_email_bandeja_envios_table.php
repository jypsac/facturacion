<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailBandejaEnviosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_bandeja_envios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->string('destinatario');
            $table->string('remitente');
            $table->string('asunto');
            $table->text('mensaje');
            $table->text('mensaje_sin_html');
            $table->string('archivo')->nullable();
            $table->string('pdf')->nullable();
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
        Schema::dropIfExists('email_bandeja_envios');
    }
}
