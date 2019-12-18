<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioInicialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_inicial', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('almacen');
            $table->string('clasificacion');
            //calasificaion es la tabla categoria fernando gill
            $table->string('codigo');
            $table->string('articulo');
            $table->string('unidad_medida');
            $table->integer('saldo');
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
        Schema::dropIfExists('inventario_inicial');
    }
}
