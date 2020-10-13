<?php

use Illuminate\Database\Seeder;

class MotivoTrasladoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     DB::table('motivo_traslado')->insert([
       'id' => 1 ,
       'nombre' => "Venta",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' => 2 ,
       'nombre' => "Venta sujeta a confirmación del comprobador ",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' => 3 ,
       'nombre' => "Compra",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' => 4 ,
       'nombre' => "Consignación ",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>5 ,
       'nombre' => "Devolución ",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>6 ,
       'nombre' => "traslado entre Establecimiento de la misma Empresa",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>7 ,
       'nombre' => "Traslado de bienes para Transformación ",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>8 ,
       'nombre' => "Recojo de bienes",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
      'id' =>9 ,
       'nombre' => "Traslado por bienes itinerante  de comprobante de pago",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>10 ,
       'nombre' => "Traslado zona primaria ",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>11 ,
       'nombre' => "Importación ",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>12 ,
       'nombre' => "Exportación",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>13 ,
       'nombre' => "Venta con entrega a terceros",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);
     DB::table('motivo_traslado')->insert([
       'id' =>14 ,
       'nombre' => "Otros",
       'estado' => "0",
       'created_at' => date('2019-08-01 00:00:00'),
       'updated_at' => date('2019-08-01 00:00:00')
     ]);

   }
 }
