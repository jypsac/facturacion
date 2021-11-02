<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaCreditoToBoleta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boleta', function (Blueprint $table) {
            $table->string('nota_credito')->default('0')->nullable()->after('op_gratuita');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('boleta', function (Blueprint $table) {
            $table->dropColumn('nota_credito');
        });
    }
}
