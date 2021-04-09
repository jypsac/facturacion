<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturesToKardexEntrada extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex_entrada', function (Blueprint $table) {
            $table->foreign('tipo_registro_id')->references('id')->on('tipo_registro')->onDelete('cascade');
            $table->foreign('almacen_emisor_id')->references('id')->on('almacen')->onDelete('cascade');
            $table->foreign('almacen_receptor_id')->references('id')->on('almacen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kardex_entrada', function (Blueprint $table) {
            $table->dropForeign('kardex_entrada_tipo_registro_id_foreign');
            $table->dropColumn('tipo_registro_id');

            $table->dropForeign('kardex_entrada_almacen_emisor_id_foreign');
            $table->dropColumn('almacen_emisor_id');

            $table->dropForeign('kardex_entrada_almacen_receptor_id_foreign');
            $table->dropColumn('almacen_receptor_id');
        });
    }
}
