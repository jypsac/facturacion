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
       DB::table('tipo_documento_sunats')->insert([
        'id' => 6,
       'codigo' => "07",
       'informacion' => "Nota de crédito",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 7,
       'codigo' => "08",
       'informacion' => "Nota de débito",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 8,
       'codigo' => "09",
       'informacion' => "Guía de remisión - Remitente",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 9,
       'codigo' => "31",
       'informacion' => "Guía de Remisión - Transportista",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 10,
       'codigo' => "87",
       'informacion' => "Nota de Crédito Especial",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 11,
       'codigo' => "88",
       'informacion' => "Nota de Débito Especial",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 12,
       'codigo' => "97",
       'informacion' => "Nota de Crédito - No Domiciliado",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 13,
       'codigo' => "97",
       'informacion' => "Nota de Débito - No Domiciliado",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);

    }
}
