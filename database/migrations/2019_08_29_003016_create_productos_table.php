<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            // $table->integer('precio');//la compra al provedor pero sin igv (precio de compra al provedor 118 pero sin igv es 100 soles)
            $table->integer('utilidad');
            $table->integer('descuento');
            $table->integer('descuento2');
            $table->string('categoria');
            $table->string('marca');
            $table->string('modelo');
            $table->string('unidad_medida');
            $table->boolean('producto_estado')->default(0);//activo o desactivado el producto

            //$table->string('codigo_barras');
            $table->string('foto');
            $table->text('descripcion');
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
        Schema::dropIfExists('productos');
    }
}
