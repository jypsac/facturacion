<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigFeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_fe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ruc');
            $table->string('usuario');
            $table->string('password');
            $table->string('certificado');
            $table->string('modo');
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
        Schema::dropIfExists('config_fe');
    }
}
