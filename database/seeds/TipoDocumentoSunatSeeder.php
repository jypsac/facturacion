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
     //   DB::table('tipo_documento_sunats')->insert([
     //   	'id' => 3,
     //   'codigo' => "02",
     //   'informacion' => "Recibo por Honorarios",
     //   'estado' => "0",
     //   'created_at' => date('2019-08-01 00:00:00'),
     //   'updated_at' => date('2019-08-01 00:00:00')
     // ]);
       DB::table('tipo_documento_sunats')->insert([
       	'id' => 3,
       'codigo' => "03",
       'informacion' => "Boleta de Venta",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     //   DB::table('tipo_documento_sunats')->insert([
     //   	'id' => 4,
     //   'codigo' => "04",
     //   'informacion' => "Liquidacion de compra",
     //   'estado' => "0",
     //   'created_at' => date('2019-08-01 00:00:00'),
     //   'updated_at' => date('2019-08-01 00:00:00')
     // ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 4,
       'codigo' => "07",
       'informacion' => "Nota de crédito",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 5,
       'codigo' => "08",
       'informacion' => "Nota de débito",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 6,
       'codigo' => "09",
       'informacion' => "Guía de remisión - Remitente",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 7,
       'codigo' => "12",
       'informacion' => "Ticket de máquina registradora",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 8,
       'codigo' => "13",
       'informacion' => "Documento emitido por bancos, instituciones financieras, crediticias y de seguros que se encuentren bajo el control de la superintendencia de banca y seguros",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 9,
       'codigo' => "14",
       'informacion' => "Recibo por servicios públicos",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 10,
       'codigo' => "16",
       'informacion' => "Boleto de viaje emitido por las empresas de transporte público interprovincial de pasajeros",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 11,
       'codigo' => "18",
       'informacion' => "Documentos emitidos por las AFP",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 12,
       'codigo' => "20",
       'informacion' => "Comprobante de retención",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 13,
       'codigo' => "31",
       'informacion' => "Guía de Remisión - Transportista",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 14,
       'codigo' => "40",
       'informacion' => "Comprobante de recepción",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 15,
       'codigo' => "41",
       'informacion' => "Comprobante de recepción -  Venta interna (Físico-Formato impreso)",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 16,
       'codigo' => "56",
       'informacion' => "Comprobante de pago SAEA",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 17,
       'codigo' => "71",
       'informacion' => "Guia de remisión remitente complementaria",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
       DB::table('tipo_documento_sunats')->insert([
        'id' => 18,
       'codigo' => "72",
       'informacion' => "Guia de remisión remitente Transportista complementaria",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
        

    }
}
