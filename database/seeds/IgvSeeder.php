<?php

use Illuminate\Database\Seeder;

class IgvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('igv')->insert([
            'id' => 1 ,
            'igv_total' => 18,
            'renta' => 18,
            'created_at' => date('2019-08-01 00:00:00'),
           	'updated_at' => date('2019-08-01 00:00:00')
		]);
    }
}
