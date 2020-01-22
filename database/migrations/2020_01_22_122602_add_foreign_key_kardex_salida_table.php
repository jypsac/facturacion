<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyKardexSalidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex_salida', function (Blueprint $table) {

            $table->unsignedBigInteger('motivo_id');
            $table->foreign('motivo_id')->references('id')->on('motivos')->onDelete('cascade');

            $table->text('informacion');

            $table->boolean('estado');

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
        Schema::dropIfExists('kardex_salida');
    }
}
