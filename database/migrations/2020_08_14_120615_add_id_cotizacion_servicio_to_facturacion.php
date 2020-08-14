<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCotizacionServicioToFacturacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturacion', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cotizador_servicio')->after('id_cotizador')->nullable();
            $table->foreign('id_cotizador_servicio')->references('id')->on('cotizacion_servicio')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturacion', function (Blueprint $table) {
            $table->dropForeign(['id_cotizador_servicio']);
            $table->dropColumn('id_cotizador_servicio');
        });

        // Schema::dropIfExists('facturacion');

    }
}
