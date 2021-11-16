<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('personal_id');
            $table->foreign('personal_id')->references('id')->on('personal')->onDelete('cascade');
            $table->unsignedBigInteger('confi_id')->nullable();
            $table->foreign('confi_id')->references('id')->on('configs')->onDelete('cascade');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('celular')->nullable();
            $table->string('numero_validacion')->nullable();
            $table->boolean('estado_validacion')->nullable();
            $table->string('password');
            $table->boolean('estado');
            $table->boolean('email_creado');


            $table->unsignedBigInteger('almacen_id')->nullable();
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');

            $table->string('avatar')->default('defecto_avatar.jpg');
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
        Schema::dropIfExists('users');
    }
}
