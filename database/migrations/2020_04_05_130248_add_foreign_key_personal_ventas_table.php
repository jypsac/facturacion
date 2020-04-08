<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyPersonalVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('personal_ventas', function (Blueprint $table) {

            $table->unsignedBigInteger('id_personal');
            $table->foreign('id_personal')->references('id')->on('personal_datos_laborales')->onDelete('cascade');
            
            $table->string('cod_vendedor');
            $table->string('tipo_comision');
            $table->string('comision');
            $table->string('estado');


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
        //
    }
}
