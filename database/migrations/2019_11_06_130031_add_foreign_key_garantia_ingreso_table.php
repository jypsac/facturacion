<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyGarantiaIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('garantia_guia_ingreso', function (Blueprint $table) {
            $table->unsignedBigInteger('marca_id');
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('cascade');

            $table->unsignedBigInteger('personal_lab_id');
            $table->foreign('personal_lab_id')->references('id')->on('personal')->onDelete('cascade');

            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');

            $table->unsignedBigInteger('contacto_cliente_id');
            $table->foreign('contacto_cliente_id')->references('id')->on('contactos')->onDelete('cascade');

            // $table->unsignedBigInteger('contacto_id');
            // $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
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
        // Schema::table('garantia_guia_ingreso', function (Blueprint $table) {
        //     // dropIfExists('garantia_guia_ingreso');
        // });

        Schema::dropIfExists('garantia_guia_ingreso');

    }
}
