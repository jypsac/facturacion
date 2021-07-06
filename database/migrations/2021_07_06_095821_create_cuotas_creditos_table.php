<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuotasCreditosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuotas_creditos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('facturacion_id')->nullable();
            $table->foreign('facturacion_id')->references('id')->on('facturacion')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_id')->nullable();
            $table->foreign('boleta_id')->references('id')->on('boleta')->onDelete('cascade');
            $table->integer('numero_cuota');
            $table->double('monto',10,2);
            $table->date('fecha_pago');
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
        Schema::dropIfExists('cuotas_creditos');
    }
}
