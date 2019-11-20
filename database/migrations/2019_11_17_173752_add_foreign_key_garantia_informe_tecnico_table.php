<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyGarantiaInformeTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('garantia_informe_tecnico', function (Blueprint $table) {
            $table->unsignedBigInteger('garantia_egreso_id');
            $table->foreign('garantia_egreso_id')->references('id')->on('garantia_guia_egreso')->onDelete('cascade');

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
        Schema::dropIfExists('garantia_informe_tecnico');
    }
}
