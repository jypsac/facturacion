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
