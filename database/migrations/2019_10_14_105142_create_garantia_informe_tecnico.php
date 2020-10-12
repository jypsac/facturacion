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
    public function            up()
    {
        Schema::create('garantia_informe_tecnico', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('orden_servicio');
            $table->boolean('estado');
            $table->date('fecha');
            $table->boolean('egresado');
            $table->boolean('informe_tecnico');

/*            DESCRIPCION DEL PROBLEMA*/
            $table->text('estetica');
            $table->text('revision_diagnostico');
            $table->text('causas_del_problema');
            $table->text('solucion');
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
