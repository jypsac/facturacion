<?php

use Illuminate\Database\Seeder;

class CodigoLeyendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('codigo_leyendas')->insert([
            'id' => 1,
            'codigo' => "1000",
            'informacion' => "Monto en Letras",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 2,
            'codigo' => "1002",
            'informacion' => "Leyenda 'TRANSFERENCIA GRATUITA DE UN BIEN Y/O SERVICIO PRESTADO GRATUITAMENTE'",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 3,
            'codigo' => "2000",
            'informacion' => "Leyenda 'COMPROBANTE DE RECEPCION'",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 4,
            'codigo' => "2001",
            'informacion' => "Leyenda 'BIENES TRANSFERIDOS A LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 5,
            'codigo' => "2002",
            'informacion' => "Leyenda 'SERVICIOS PRESTADOS EN LA AMAZONÍA REGIÓN SELVA PARA SER CONSUMIDOS EN LA MISMA'",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 6,
            'codigo' => "2003",
            'informacion' => "Leyenda 'CONTRATOS DE CONSTRUCCIÓN EJECUTADOS EN LA AMAZONÍA REGIÓN SELVA' ",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 7,
            'codigo' => "2004",
            'informacion' => "Leyenda 'Agencia de viaje - Paquete Turístico'",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 8,
            'codigo' => "2005",
            'informacion' => "Leyenda 'Venta realizada por emizor itinerante'",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 9,
            'codigo' => "2006",
            'informacion' => "Leyenda 'Operación sujeta a detracción'",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
        DB::table('codigo_leyendas')->insert([
            'id' => 10,
            'codigo' => "3000",
            'informacion' => "Código interno generado por el software de Facturación",
            'estado' => "0",
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }
}
