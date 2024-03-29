<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_servicio');
            $table->string('codigo_original')->unique();

            $table->unsignedBigInteger('familia_id')->default(1);
            $table->foreign('familia_id')->references('id')->on('familias')->onDelete('cascade');

            $table->unsignedBigInteger('marca_id')->default(1);
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');

            $table->unsignedBigInteger('moneda_id');
            $table->foreign('moneda_id')->references('id')->on('monedas')->onDelete('cascade');

            $table->string('nombre');
            $table->string('categoria');
            $table->string('precio_nacional');
            $table->string('precio_extranjero');
            $table->integer('utilidad');
            $table->integer('descuento');
            $table->text('descripcion');
            $table->string('foto');
            $table->string('estado_anular');
            $table->string('estado_activo');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
