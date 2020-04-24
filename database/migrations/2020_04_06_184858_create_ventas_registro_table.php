            $table->boolean('estado');
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_registro', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->string('numero_cotizacion');
            // $table->string('tipo');
            $table->boolean('estado_aprobado');
            $table->boolean('pago_efectuado');
            $table->string('observacion');
            $table->string('comisionista');

            // estado anulado o activo de la factura
            $table->string('estado_fac');

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
        Schema::dropIfExists('ventas_registro');
    }
}
