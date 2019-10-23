<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provedores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ruc');//ruc de la empresa
            $table->string('empresa');//nombre de la empresa
            $table->string('direccion');//direccion de la empresa
            $table->string('telefonos');//telefonos de la empresa
            $table->string('email');//telefono de la empresa
            //datos del provedor a contactar
            $table->string('contacto_provedor');//nombre de la persona a contacto
            $table->string('celular_provedor');//celular del contacto
            $table->string('email_provedor');//celular del contacto
            $table->text('observacion');//notas o datos
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
        Schema::dropIfExists('provedores');
    }
}
