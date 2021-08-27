<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicios', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_afectacion_id')->default(1);
            $table->foreign('tipo_afectacion_id')->references('id')->on('tipo_afectacion')->onDelete('cascade');
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
        Schema::table('servicios', function (Blueprint $table) {
            $table->dropForeign(['tipo_afectacion_id']);
            $table->dropColumn('tipo_afectacion_id');
        });
    }
}
