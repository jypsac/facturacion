<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccion_compra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('proveedor');
            $table->integer('direccion');
            $table->string('fecha_entrega');
            $table->string('atencion');
            $table->string('forma_pago');

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
        Schema::dropIfExists('transaccion_compra');
    }
}
