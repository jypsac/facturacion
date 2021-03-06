<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturesToKardexEntradaRegistro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex_entrada_registro', function (Blueprint $table) {
            $table->foreign('tipo_registro_id')->references('id')->on('tipo_registro')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kardex_entrada_registro', function (Blueprint $table) {
            $table->dropForeign('kardex_entrada_registro_tipo_registro_id_foreign');
            $table->dropColumn('tipo_registro_id');
        });
    }
}
