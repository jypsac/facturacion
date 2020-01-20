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
        $this->call(ClientesSeeder::class);
        $this->call(ProvedorTableSeeder::class);
        $this->call(AlmacenTableSeeder::class);
        $this->call(Personal_laboralTableSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(GarantiaTableSeeder::class);
        $this->call(ProductosTableSeeder::class);
        
        
    }
}
