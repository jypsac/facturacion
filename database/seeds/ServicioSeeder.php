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
            'codigo_servicio'=>"SERV-00001",
            'codigo_original'=>123,
            'nombre'=>"Formateos",
            'categoria'=>"Servicios",
            'precio'=>100,
            'utilidad'=>50,
            'descuento'=>10,
            'descripcion'=>"instalacion de windows",
            'foto'=>"defecto.png",
            'estado_anular'=>0,
            'estado_activo'=>0,
            'created_at' => date('2019-08-01 00:00:00'),
            'updated_at' => date('2019-08-01 00:00:00')
        ]);
    }

}
