<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('razon_social');
            $table->integer('ruc');
            $table->integer('telefono');
            $table->integer('movil');
            $table->string('correo');
            $table->string('pais');
            $table->string('region_provincia');
            $table->string('ciudad');
            $table->string('calle');
            $table->string('codigo_postal');
            $table->string('rubro');
            $table->string('moneda_principal');
            $table->text('descripcion');
            $table->string('foto');
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
        Schema::dropIfExists('empresa');
    }
}
