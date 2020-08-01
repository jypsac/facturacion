<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fondo_perfil');//imagen de su fondo
            $table->string('borde_foto');// Borde gruesor foto de Perfil
            $table->string('color_borde_foto');// Color Borde foto de Perfil
            $table->string('foto_icono');//Favicon
            $table->string('foto_perfil');//foto de perfil
            $table->string('letra');
            $table->string('tamano_letra')->nullable();//font-size
            $table->string('tamano_letra_perfil')->nullable();//font-size
            $table->string('color_sombra_nombre')->nullable();//sombra tiene color
            $table->string('color_nombre')->nullable();//color del titulo del nombre


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
        Schema::dropIfExists('configs');
    }
}
