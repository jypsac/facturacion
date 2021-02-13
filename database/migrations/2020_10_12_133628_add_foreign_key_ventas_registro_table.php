<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyVentasRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ventas_registro', function (Blueprint $table) {

            $table->unsignedBigInteger('comisionista')->nullable();
            $table->foreign('comisionista')->references('id')->on('personal_ventas')->onDelete('cascade');

            $table->unsignedBigInteger('id_coti_produc')->nullable();/* el ID cotizacion prodcuto*/
            $table->foreign('id_coti_produc')->references('id')->on('cotizacion')->onDelete('cascade');

            $table->unsignedBigInteger('id_coti_servicio')->nullable();/*id de cotizacion Sercvicio*/
            $table->foreign('id_coti_servicio')->references('id')->on('cotizacion_servicio')->onDelete('cascade');

            $table->unsignedBigInteger('id_fac')->nullable();/*id de factura */
            $table->foreign('id_fac')->references('id')->on('facturacion')->onDelete('cascade');

            $table->unsignedBigInteger('id_bol')->nullable();/*id de boleta */
            $table->foreign('id_bol')->references('id')->on('boleta')->onDelete('cascade');


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
