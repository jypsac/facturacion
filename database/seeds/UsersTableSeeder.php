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
           'email' => 'admin@admin.com',
           'personal_id' => '1',
           'password' => bcrypt('admin@admin.com')
       ]);
        DB::table('users')->insert([
            'id' => 2 ,
            'name' => 'Ventas',
            'email' => 'ventas@ventas.com',
            'personal_id' => '3',
            'password' => bcrypt('ventas@ventas.com')
        ]);
        DB::table('users')->insert([
            'id' => 3 ,
            'name' => 'Soporte',
            'email' => 'soporte@soporte.com',
            'personal_id' => '2',
            'password' => bcrypt('soporte@soporte.com')
        ]);
    }
}
