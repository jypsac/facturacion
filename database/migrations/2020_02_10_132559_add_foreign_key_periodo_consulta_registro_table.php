<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyPeriodoConsultaRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('periodo_consulta_registro', function (Blueprint $table) {

            $table->unsignedBigInteger('periodo_consulta_id');
            $table->foreign('periodo_consulta_id')->references('id')->on('periodo_consulta')->onDelete('cascade');

            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->integer('cantidad_inicial');
            $table->double('precio');
            $table->integer('cantidad');
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
        Schema::dropIfExists('periodo_consulta_registro');
    }
}
