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
    }
}
