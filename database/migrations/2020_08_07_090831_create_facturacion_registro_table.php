<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturacionRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturacion_registro', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('facturacion_id')->nullable();
            $table->foreign('facturacion_id')->references('id')->on('facturacion')->onDelete('cascade');

            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');

            $table->string('numero_serie')->nullable();

            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->integer('stock')->nullable();
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
        Schema::dropIfExists('facturacion_registro');
    }
}
