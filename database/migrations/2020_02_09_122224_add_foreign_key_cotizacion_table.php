<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyCotizacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion', function (Blueprint $table) {

            
            $table->unsignedBigInteger('aprobado_por')->nullable();
            $table->foreign('aprobado_por')->references('id')->on('users')->onDelete('cascade');
            
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            // $table->string('direccion');
            $table->string('garantia');

            $table->unsignedBigInteger('moneda_id');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');
             // $table->string('atencion');

            $table->unsignedBigInteger('forma_pago_id');
            $table->foreign('forma_pago_id')->references('id')->on('forma_pago')->onDelete('cascade');

            $table->string('validez');

            // $table->string('comisionista_id');
            // $table->string('referencia')->nullable();
            $table->unsignedBigInteger('comisionista_id')->nullable();
            $table->foreign('comisionista_id')->references('id')->on('personal_ventas')->onDelete('cascade');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('observacion')->nullable();


            $table->string('fecha_emision');
            $table->string('fecha_vencimiento');

            $table->string('tipo');

            $table->boolean('estado');

            $table->boolean('estado_vigente');

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
        Schema::dropIfExists('cotizacion');
    }
}
