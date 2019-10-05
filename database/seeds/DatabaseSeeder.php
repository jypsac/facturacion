<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CategoriasTableSeeder::class);
        $this->call(FamiliasTableSeeder::class);
        $this->call(MarcasTableSeeder::class);
        $this->call(PaisesTableSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(IgvSeeder::class);
        $this->call(MonedasSeeder::class);
        $this->call(UnidadMedidaSeeder::class);
        $this->call(PersonalTableSeeder::class);
    }
}
