<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'id' => 1 ,
           'name' => 'Administrador',
           'email' => 'desarrollo@jypsac.com',
           'personal_id' => '1',
           'password' => bcrypt('123'),
           'estado' => 1,
           'confi_id' => 1,
           'email_creado' => 0,
           'almacen_id' => 1
       ]);
       //   DB::table('users')->insert([
       //     'id' => 2 ,
       //     'name' => 'Administrador',
       //     'email' => 'hidro2@hidromaxsac.com',
       //     'personal_id' => '2',
       //     'password' => bcrypt('123'),
       //     'estado' => 1,
       //     'confi_id' => 2,
       //     'email_creado' => 0,
       //     'almacen_id' => 1
       // ]);
       //   DB::table('users')->insert([
       //     'id' => 3 ,
       //     'name' => 'Colaborador',
       //     'email' => 'admin@admin.com',
       //     'personal_id' => '3',
       //     'password' => bcrypt('admin@admin.com'),
       //     'estado' => 1,
       //     'confi_id' =>3,
       //     'email_creado' => 0,
       //     'almacen_id' => 1
       // ]);


    }
}
