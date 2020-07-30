<?php

use Illuminate\Database\Seeder;

class ConfiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('configs')->insert([
    		'id' => 1 ,
    		'fondo_perfil' => 'paisaje_noche.jpg',
    		'borde_foto' =>"3px" ,
    		'color_borde_foto' => '#ffffff',
    		'foto_icono' => "defecto.png" ,
    		'foto_perfil' => "0" ,
    		'letra' => "none" ,
    		'tamano_letra' => " " ,
    		'tamano_letra_perfil' => "12px " ,
    		'color_sombra_nombre' => "#000000 " ,
    		'color_nombre' => "#ffffff " ,
    		'created_at' => '2019-10-30 11:36:57',
    		'updated_at' => "2019-10-30 11:36:57" ,
    	]);
    	DB::table('configs')->insert([
    		'id' => 2,
    		'fondo_perfil' => 'paisaje_noche.jpg',
    		'borde_foto' =>"3px" ,
    		'color_borde_foto' => '#ffffff',
    		'foto_icono' => "defecto.png" ,
    		'foto_perfil' => "0" ,
    		'letra' => "none" ,
    		'tamano_letra' => " " ,
    		'tamano_letra_perfil' => "12px " ,
    		'color_sombra_nombre' => "#000000 " ,
    		'color_nombre' => "#ffffff " ,
    		'created_at' => '2019-10-30 11:36:57',
    		'updated_at' => "2019-10-30 11:36:57" ,
    	]);
    	DB::table('configs')->insert([
    		'id' => 3,
    		'fondo_perfil' => 'paisaje_noche.jpg',
    		'borde_foto' =>"3px" ,
    		'color_borde_foto' => '#ffffff',
    		'foto_icono' => "defecto.png" ,
    		'foto_perfil' => "0" ,
    		'letra' => "none" ,
    		'tamano_letra' => " " ,
    		'tamano_letra_perfil' => "12px " ,
    		'color_sombra_nombre' => "#000000 " ,
    		'color_nombre' => "#ffffff " ,
    		'created_at' => '2019-10-30 11:36:57',
    		'updated_at' => "2019-10-30 11:36:57" ,
    	]);
    }
}
