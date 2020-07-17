<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletaRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boleta_registro', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('boleta_id');
            $table->foreign('boleta_id')->references('id')->on('boleta')->onDelete('cascade');

            $table->string('numero_serie');

            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->integer('stock');
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
        Schema::dropIfExists('boleta_registro');
    }
}
