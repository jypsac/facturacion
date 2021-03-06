<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeaturesToBoleta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boleta', function (Blueprint $table) {
            $table->foreign('tipo_operacion_id')->references('id')->on('tipo_operacion_fs')->onDelete('cascade');
            $table->foreign('tipo_documento_id')->references('id')->on('tipo_documento_sunats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boleta', function (Blueprint $table) {
            $table->dropForeign('cotizacion_tipo_operacion_id_foreign');
            $table->dropColumn('tipo_operacion_id');

            $table->dropForeign('cotizacion_tipo_documento_id_foreign');
            $table->dropColumn('tipo_documento_id');
        });
    }
}
