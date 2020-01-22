<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyKardexEntradaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex_entrada', function (Blueprint $table) {

            $table->unsignedBigInteger('provedor_id');
            $table->foreign('provedor_id')->references('id')->on('provedores')->onDelete('cascade');
            
            

            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacen')->onDelete('cascade');
            $table->string('guia_remision');
            $table->string('factura');
            $table->string('informacion');
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
        Schema::dropIfExists('kardex_entrada');
    }
}