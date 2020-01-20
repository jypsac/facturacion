<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyKardexEntradaRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex_entrada_registro', function (Blueprint $table) {

            $table->unsignedBigInteger('kardex_entrada_id');
            $table->foreign('kardex_entrada_id')->references('id')->on('kardex_entrada')->onDelete('cascade');

            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->integer('cantidad');
            $table->double('precio');

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
        Schema::dropIfExists('kardex_entrada_registro');
    }
}
