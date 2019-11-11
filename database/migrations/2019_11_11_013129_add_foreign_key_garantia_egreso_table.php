<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyGarantiaEgresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garantia_guia_egreso', function (Blueprint $table) {
            $table->unsignedBigInteger('garantia_ingreso_id');
            $table->foreign('garantia_ingreso_id')->references('id')->on('garantia_guia_ingreso')->onDelete('cascade');

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
        Schema::table('garantia_guia_egreso', function (Blueprint $table) {
            //
            Schema::dropIfExists('garantia_guia_egreso');
        });
    }
}
