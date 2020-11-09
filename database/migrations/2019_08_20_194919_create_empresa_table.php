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
            $table->string('ruc');
            $table->string('telefono');
            $table->string('movil');
            $table->string('correo');
            $table->string('pais');
            $table->string('region_provincia');
            $table->string('ciudad');
            $table->string('calle');
            $table->string('codigo_postal');
            $table->string('rubro');
            $table->string('moneda_principal');
            $table->text('descripcion');
            $table->text('pagina_web');
            $table->string('foto');
            $table->text('background');
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
