<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyCotizacionServicioFacturaRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion_servicio_factura_r', function (Blueprint $table) {

            $table->unsignedBigInteger('cotizacion_servicio_id');
            $table->foreign('cotizacion_servicio_id')->references('id')->on('cotizacion_servicio')->onDelete('cascade');

            $table->unsignedBigInteger('servicio_id');
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');

            // $table->integer('stock'); STOCK INFINITO
            $table->double('promedio_original',17,2);
            $table->double('precio',17,2);
            $table->integer('cantidad');
            $table->integer('descuento');
            $table->double('precio_unitario_desc',17,2);
            $table->integer('comision');
            $table->double('precio_unitario_comi',17,2);

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
        Schema::dropIfExists('cotizacion_servicio_factura_r');
    }
}
