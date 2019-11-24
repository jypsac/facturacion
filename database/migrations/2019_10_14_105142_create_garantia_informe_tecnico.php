<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGarantiaInformeTecnico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('garantia_informe_tecnico', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('orden_servicio');
            $table->boolean('estado');
            $table->boolean('egresado');
            $table->boolean('informe_tecnico');

/*            DESCRIPCION DEL PROBLEMA*/
            $table->text('estetica');
            $table->text('revision_diagnostico');
            $table->text('causas_del_problema');
            $table->text('solucion');
            //imagenes
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->string('image4');
            $table->string('image5');
            $table->string('image6');
            $table->string('image7');
            $table->string('image8');

            /*$table->timestamps();*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('garantia_informe_tecnico');
    }
}
