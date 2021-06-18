<?php

use Illuminate\Database\Seeder;

class TipoOperacionFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_operacion_fs')->insert([
            'id' => 1,
            'codigo' => "0101",
            'informacion' => "Venta Interna",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 2,
            'codigo' => "0102",
            'informacion' => "Exportación",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 3,
            'codigo' => "0103",
            'informacion' => "No Domiciliados",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 4,
            'codigo' => "0104",
            'informacion' => "Venta Interna - Anticipos",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 5,
            'codigo' => "0105",
            'informacion' => "Venta Itinerante",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 6,
            'codigo' => "0106",
            'informacion' => "Factura Guía",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 7,
            'codigo' => "0107",
            'informacion' => "Venta Arroz Pilado",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 8,
            'codigo' => "0108",
            'informacion' => "Factura - Comprobante de Percepción",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 9,
            'codigo' => "0110",
            'informacion' => "Factura - Guía Remitente",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('tipo_operacion_fs')->insert([
            'id' => 10,
            'codigo' => "0111",
            'informacion' => "Factura - Guía de Transportista",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
