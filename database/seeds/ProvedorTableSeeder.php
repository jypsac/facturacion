<?php
use App\Provedor;
use Illuminate\Database\Seeder;

class ProvedorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Provedor::class, 10)->create();
    }
}
