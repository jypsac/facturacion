<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConfiguracionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_configuraciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('email_backup');
            $table->string('smtp');
            $table->integer('port');
            $table->string('encryption')->nullable();
            $table->string('firma')->nullable();
            $table->string('ancho_firma')->nullable();
            $table->string('alto_firma')->nullable();
            $table->string('firma_digital')->nullable();
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
        Schema::dropIfExists('email_configuraciones');
    }
}
