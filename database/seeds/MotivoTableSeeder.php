<?php

use Illuminate\Database\Seeder;

class MotivoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('motivos')->insert([
        //     'nombre' => 'Compras Importadas',
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00'),
        // ]);

        DB::table('motivos')->insert([
            'nombre' => 'Compras Locales',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
        ]);

        // DB::table('motivos')->insert([
        //     'nombre' => 'Conversion',
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00'),
        // ]);

        DB::table('motivos')->insert([
            'nombre' => 'Devolucion Clientes',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
        ]);

        DB::table('motivos')->insert([
            'nombre' => 'Devolucion Guia/Remision',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
        ]);

        DB::table('motivos')->insert([
            'nombre' => 'Inventario Inicial',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
        ]);

        // DB::table('motivos')->insert([
        //     'nombre' => 'Produccion',
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00'),
        // ]);

        // DB::table('motivos')->insert([
        //     'nombre' => 'Transferencia',
        //     'created_at' => date('2019-08-01 00:00:00'),
        //     'updated_at' => date('2019-08-01 00:00:00'),
        // ]);

        DB::table('motivos')->insert([
            'nombre' => 'Traslado de Almacen',
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00'),
        ]);
    }
}
