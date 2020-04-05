<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('cod_vendedor');
            // $table->string('tipo_comision');
            // $table->string('comision');
            // $table->string('estado');
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
        Schema::dropIfExists('personal_ventas');
    }
}
