<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('abreviatura');
            //codigo sunat hara que los codigos de las boleta y facturas sean de diferenstes sucusrsales
            $table->integer('codigo_sunat');
            $table->text('direccion');
            // $table->string('responsable');
            $table->text('descripcion');
            $table->string('cod_fac');
            $table->string('cod_bol');
            $table->string('cod_guia');
            $table->boolean('estado');
<<<<<<< HEAD

            $table->unsignedBigInteger('responsable')->nullable();
            $table->foreign('responsable')->references('id')->on('personal')->onDelete('cascade');
=======
            $table->string('cod_fac');
            $table->string('cod_bol');
            $table->string('cod_guia');
>>>>>>> 4088f19749687ddbc6b05d69d5f53139b1bbb78f
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
        Schema::dropIfExists('almacen');
    }
}
