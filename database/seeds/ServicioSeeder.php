<?php

use Illuminate\Database\Seeder;
use App\Servicios;
class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('servicios')->insert([
            'codigo_servicio'=>"SERV-00000001",
            'codigo_original'=>123,
            'familia_id' =>1,
            'marca_id'=>1,
            'moneda_id'=>1,
            'nombre'=>"Servicios1",
            'categoria'=>"Servicios",
            'precio_nacional'=>100,
            'precio_extranjero'=>23.15,
            'utilidad'=>50,
            'descuento'=>5,
            'descripcion'=>"instalacion de windows",
            'foto'=>"defecto.png",
            'estado_anular'=>0,
            'estado_activo'=>0,
            'tipo_afectacion_id'=>1,
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }

}
