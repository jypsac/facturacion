<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission list
        Permission::create(['name' => 'inicio']);
        Permission::create(['name' => 'transacciones']);
        Permission::create(['name' => 'transacciones-ventas']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones']);
        Permission::create(['name' => 'transacciones-ventas-facturacion']);
        Permission::create(['name' => 'transacciones-ventas-boleta']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision']);
        Permission::create(['name' => 'transacciones-garantias']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico']);
        Permission::create(['name' => 'inventario']);
        Permission::create(['name' => 'inventario-productos_kardex']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial']);
        Permission::create(['name' => 'inventario-toma_de_inventario']);
        Permission::create(['name' => 'planilla']);
        Permission::create(['name' => 'planilla-datos_generales']);
        Permission::create(['name' => 'planilla-vendedores']);
        Permission::create(['name' => 'consultas-garantias']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico']);
        Permission::create(['name' => 'auxiliares']);
        Permission::create(['name' => 'auxiliares-clientes']);
        Permission::create(['name' => 'auxiliares-provedores']);
        Permission::create(['name' => 'maestro']);
        Permission::create(['name' => 'maestro-catalogo']);
        Permission::create(['name' => 'maestro-catalogo-productos']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas']);
        Permission::create(['name' => 'maestro-tablas_generales']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos']);
        Permission::create(['name' => 'maestro-almacenes']);
        Permission::create(['name' => 'maestro-usuarios']);
        Permission::create(['name' => 'maestro-monedas']);
        Permission::create(['name' => 'maestro-tipo_de_cambio']);
        Permission::create(['name' => 'maestro-configuracion_general']);
        Permission::create(['name' => 'maestro-mi_empresa']);
        Permission::create(['name' => 'maestro-unidad_de_medida']);
        Permission::create(['name' => 'maestro-igv']);


        //Admin
        $admin = Role::create(['name' => 'Admin']);

        $admin->givePermissionTo([
            'inicio',
            'transacciones',
            'transacciones-ventas',
            'transacciones-ventas-cotizaciones',
            'transacciones-ventas-facturacion',
            'transacciones-ventas-boleta',
            'transacciones-ventas-guia_remision',
            'transacciones-garantias',
            'transacciones-garantias-guias_ingreso',
            'transacciones-garantias-guias_egreso',
            'transacciones-garantias-informe_tecnico',
            'inventario',
            'inventario-productos_kardex',
            'inventario-productos_kardex-entrada_producto',
            'inventario-productos_kardex-salida_producto',
            'inventario-productos-inventario_inicial',
            'inventario-toma_de_inventario',
            'planilla',
            'planilla-datos_generales',
            'planilla-vendedores',
            'consultas-garantias',
            'consultas-garantias-guia_ingreso',
            'consultas-garantias-guia_egreso',
            'consultas-garantias-informe_tecnico',
            'auxiliares',
            'auxiliares-clientes',
            'auxiliares-provedores',
            'maestro',
            'maestro-catalogo',
            'maestro-catalogo-productos',
            'maestro-catalogo-clasificacion',
            'maestro-catalogo-clasificacion-categorias',
            'maestro-catalogo-clasificacion-familias',
            'maestro-catalogo-clasificacion-marcas',
            'maestro-tablas_generales',
            'maestro-tablas_generales-motivos',
            'maestro-almacenes',
            'maestro-usuarios',
            'maestro-monedas',
            'maestro-tipo_de_cambio',
            'maestro-configuracion_general',
            'maestro-mi_empresa',
            'maestro-unidad_de_medida',
            'maestro-igv'
        ]);
        //$admin->givePermissionTo('products.index');
        //$admin->givePermissionTo(Permission::all());

        //Guest
        $guest = Role::create(['name' => 'Guest']);

        $guest->givePermissionTo([
            'inicio',
        ]);

        //User Admin
        $user = User::find(1);
        $user->assignRole('Admin');
    }
}
