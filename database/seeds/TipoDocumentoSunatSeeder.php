<?php

use Illuminate\Database\Seeder;

class TipoDocumentoSunatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('tipo_documento_sunats')->insert([
       	'id' => 1,
       'codigo' => "00",
       'informacion' => "Otros(Especificar)",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
       	'id' => 2,
       'codigo' => "01",
       'informacion' => "Factura",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
       	'id' => 3,
       'codigo' => "02",
       'informacion' => "Recibo por Honorarios",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
       	'id' => 4,
       'codigo' => "03",
       'informacion' => "Boleta de Venta",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
       	'id' => 5,
       'codigo' => "04",
       'informacion' => "Liquidacion de compra",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
    }
}
