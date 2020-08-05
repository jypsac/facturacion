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
        $servicio=new Servicios;
        $servicio->codigo_servicio="SERV-00001";
        $servicio->codigo_original =123;
        $servicio->nombre="Formateos";
        $servicio->categoria="Servicios";
        $servicio->precio=100;
        $servicio->utilidad=50;
        $servicio->descuento=10;
        $servicio->descripcion="instalacion de windows";
        $servicio->foto="defecto.png";
        $servicio->estado_anular=0;
        $servicio->estado_activo=0;
        $servicio->save();
    }
}
