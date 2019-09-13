<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaccionCompraCodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaccion_compra_cod', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identificador_cod');
            $table->string('codigo');
            $table->string('descripcion');
            $table->integer('unidad');
            $table->integer('cantidad');
            $table->integer('precio_unitario');
            $table->integer('descuento');
            $table->integer('importe');
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
        Schema::dropIfExists('transaccion_compra_cod');
    }
}
