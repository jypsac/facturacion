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
        //Lista de permisos
        Permission::create(['name' => 'inicio']);
        Permission::create(['name' => 'transacciones']);
        Permission::create(['name' => 'transacciones-ventas']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones.index']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones.create']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones.store']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones.show']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones.edit']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones.update']);
        Permission::create(['name' => 'transacciones-ventas-cotizaciones.destroy']);
        Permission::create(['name' => 'transacciones-ventas-facturacion.index']);
        Permission::create(['name' => 'transacciones-ventas-facturacion.create']);
        Permission::create(['name' => 'transacciones-ventas-facturacion.store']);
        Permission::create(['name' => 'transacciones-ventas-facturacion.show']);
        Permission::create(['name' => 'transacciones-ventas-facturacion.edit']);
        Permission::create(['name' => 'transacciones-ventas-facturacion.update']);
        Permission::create(['name' => 'transacciones-ventas-facturacion.destroy']);
        Permission::create(['name' => 'transacciones-ventas-boleta.index']);
        Permission::create(['name' => 'transacciones-ventas-boleta.create']);
        Permission::create(['name' => 'transacciones-ventas-boleta.store']);
        Permission::create(['name' => 'transacciones-ventas-boleta.show']);
        Permission::create(['name' => 'transacciones-ventas-boleta.edit']);
        Permission::create(['name' => 'transacciones-ventas-boleta.update']);
        Permission::create(['name' => 'transacciones-ventas-boleta.destroy']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision.index']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision.create']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision.store']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision.show']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision.edit']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision.update']);
        Permission::create(['name' => 'transacciones-ventas-guia_remision.destroy']);
        Permission::create(['name' => 'transacciones-garantias']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso.index']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso.create']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso.store']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso.show']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso.edit']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso.update']);
        Permission::create(['name' => 'transacciones-garantias-guias_ingreso.destroy']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso.index']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso.create']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso.store']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso.show']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso.edit']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso.update']);
        Permission::create(['name' => 'transacciones-garantias-guias_egreso.destroy']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico.index']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico.create']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico.store']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico.show']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico.edit']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico.update']);
        Permission::create(['name' => 'transacciones-garantias-informe_tecnico.destroy']);
        Permission::create(['name' => 'inventario']);
        Permission::create(['name' => 'inventario-productos_kardex']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto.index']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto.create']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto.store']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto.show']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto.edit']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto.update']);
        Permission::create(['name' => 'inventario-productos_kardex-entrada_producto.destroy']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto.index']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto.create']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto.store']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto.show']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto.edit']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto.update']);
        Permission::create(['name' => 'inventario-productos_kardex-salida_producto.destroy']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial.index']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial.create']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial.store']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial.show']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial.edit']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial.update']);
        Permission::create(['name' => 'inventario-productos-inventario_inicial.destroy']);
        Permission::create(['name' => 'inventario-toma_de_inventario.index']);
        Permission::create(['name' => 'inventario-toma_de_inventario.create']);
        Permission::create(['name' => 'inventario-toma_de_inventario.store']);
        Permission::create(['name' => 'inventario-toma_de_inventario.show']);
        Permission::create(['name' => 'inventario-toma_de_inventario.edit']);
        Permission::create(['name' => 'inventario-toma_de_inventario.update']);
        Permission::create(['name' => 'inventario-toma_de_inventario.destroy']);
        Permission::create(['name' => 'planilla']);
        Permission::create(['name' => 'planilla-datos_generales.index']);
        Permission::create(['name' => 'planilla-datos_generales.create']);
        Permission::create(['name' => 'planilla-datos_generales.store']);
        Permission::create(['name' => 'planilla-datos_generales.show']);
        Permission::create(['name' => 'planilla-datos_generales.edit']);
        Permission::create(['name' => 'planilla-datos_generales.update']);
        Permission::create(['name' => 'planilla-datos_generales.destroy']);
        Permission::create(['name' => 'planilla-vendedores.index']);
        Permission::create(['name' => 'planilla-vendedores.create']);
        Permission::create(['name' => 'planilla-vendedores.store']);
        Permission::create(['name' => 'planilla-vendedores.show']);
        Permission::create(['name' => 'planilla-vendedores.edit']);
        Permission::create(['name' => 'planilla-vendedores.update']);
        Permission::create(['name' => 'planilla-vendedores.destroy']);
        Permission::create(['name' => 'consultas']);
        Permission::create(['name' => 'consultas-garantias']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso.index']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso.create']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso.store']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso.show']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso.edit']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso.update']);
        Permission::create(['name' => 'consultas-garantias-guia_ingreso.destroy']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso.index']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso.create']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso.store']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso.show']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso.edit']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso.update']);
        Permission::create(['name' => 'consultas-garantias-guia_egreso.destroy']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico.index']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico.create']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico.store']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico.show']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico.edit']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico.update']);
        Permission::create(['name' => 'consultas-garantias-informe_tecnico.destroy']);
        Permission::create(['name' => 'auxiliares']);
        Permission::create(['name' => 'auxiliares-clientes.index']);
        Permission::create(['name' => 'auxiliares-clientes.create']);
        Permission::create(['name' => 'auxiliares-clientes.store']);
        Permission::create(['name' => 'auxiliares-clientes.show']);
        Permission::create(['name' => 'auxiliares-clientes.edit']);
        Permission::create(['name' => 'auxiliares-clientes.update']);
        Permission::create(['name' => 'auxiliares-clientes.destroy']);
        Permission::create(['name' => 'auxiliares-provedores.index']);
        Permission::create(['name' => 'auxiliares-provedores.create']);
        Permission::create(['name' => 'auxiliares-provedores.store']);
        Permission::create(['name' => 'auxiliares-provedores.show']);
        Permission::create(['name' => 'auxiliares-provedores.edit']);
        Permission::create(['name' => 'auxiliares-provedores.update']);
        Permission::create(['name' => 'auxiliares-provedores.destroy']);
        Permission::create(['name' => 'maestro']);
        Permission::create(['name' => 'maestro-catalogo']);
        Permission::create(['name' => 'maestro-catalogo-productos.index']);
        Permission::create(['name' => 'maestro-catalogo-productos.create']);
        Permission::create(['name' => 'maestro-catalogo-productos.store']);
        Permission::create(['name' => 'maestro-catalogo-productos.show']);
        Permission::create(['name' => 'maestro-catalogo-productos.edit']);
        Permission::create(['name' => 'maestro-catalogo-productos.update']);
        Permission::create(['name' => 'maestro-catalogo-productos.destroy']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias.index']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias.create']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias.store']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias.show']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias.edit']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias.update']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-categorias.destroy']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias.index']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias.create']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias.store']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias.show']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias.edit']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias.update']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-familias.destroy']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas.index']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas.create']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas.store']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas.show']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas.edit']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas.update']);
        Permission::create(['name' => 'maestro-catalogo-clasificacion-marcas.destroy']);
        Permission::create(['name' => 'maestro-tablas_generales']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos.index']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos.create']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos.store']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos.show']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos.edit']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos.update']);
        Permission::create(['name' => 'maestro-tablas_generales-motivos.destroy']);
        Permission::create(['name' => 'maestro-almacenes.index']);
        Permission::create(['name' => 'maestro-almacenes.create']);
        Permission::create(['name' => 'maestro-almacenes.store']);
        Permission::create(['name' => 'maestro-almacenes.show']);
        Permission::create(['name' => 'maestro-almacenes.edit']);
        Permission::create(['name' => 'maestro-almacenes.update']);
        Permission::create(['name' => 'maestro-almacenes.destroy']);
        Permission::create(['name' => 'maestro-usuarios.index']);
        Permission::create(['name' => 'maestro-usuarios.create']);
        Permission::create(['name' => 'maestro-usuarios.store']);
        Permission::create(['name' => 'maestro-usuarios.show']);
        Permission::create(['name' => 'maestro-usuarios.edit']);
        Permission::create(['name' => 'maestro-usuarios.update']);
        Permission::create(['name' => 'maestro-usuarios.destroy']);
        Permission::create(['name' => 'maestro-monedas.index']);
        Permission::create(['name' => 'maestro-monedas.create']);
        Permission::create(['name' => 'maestro-monedas.store']);
        Permission::create(['name' => 'maestro-monedas.show']);
        Permission::create(['name' => 'maestro-monedas.edit']);
        Permission::create(['name' => 'maestro-monedas.update']);
        Permission::create(['name' => 'maestro-monedas.destroy']);
        Permission::create(['name' => 'maestro-tipo_de_cambio.index']);
        Permission::create(['name' => 'maestro-tipo_de_cambio.create']);
        Permission::create(['name' => 'maestro-tipo_de_cambio.store']);
        Permission::create(['name' => 'maestro-tipo_de_cambio.show']);
        Permission::create(['name' => 'maestro-tipo_de_cambio.edit']);
        Permission::create(['name' => 'maestro-tipo_de_cambio.update']);
        Permission::create(['name' => 'maestro-tipo_de_cambio.destroy']);
        Permission::create(['name' => 'maestro-configuracion_general']);
        Permission::create(['name' => 'maestro-configuracion_general.mi_empresa.index']);
        Permission::create(['name' => 'maestro-configuracion_general.mi_empresa.create']);
        Permission::create(['name' => 'maestro-configuracion_general.mi_empresa.store']);
        Permission::create(['name' => 'maestro-configuracion_general.mi_empresa.show']);
        Permission::create(['name' => 'maestro-configuracion_general.mi_empresa.edit']);
        Permission::create(['name' => 'maestro-configuracion_general.mi_empresa.update']);
        Permission::create(['name' => 'maestro-configuracion_general.mi_empresa.destroy']);
        Permission::create(['name' => 'maestro-configuracion_general.unidad_de_medida.index']);
        Permission::create(['name' => 'maestro-configuracion_general.unidad_de_medida.create']);
        Permission::create(['name' => 'maestro-configuracion_general.unidad_de_medida.store']);
        Permission::create(['name' => 'maestro-configuracion_general.unidad_de_medida.show']);
        Permission::create(['name' => 'maestro-configuracion_general.unidad_de_medida.edit']);
        Permission::create(['name' => 'maestro-configuracion_general.unidad_de_medida.update']);
        Permission::create(['name' => 'maestro-configuracion_general.unidad_de_medida.destroy']);
        Permission::create(['name' => 'maestro-configuracion_general.igv.index']);
        Permission::create(['name' => 'maestro-configuracion_general.igv.create']);
        Permission::create(['name' => 'maestro-configuracion_general.igv.store']);
        Permission::create(['name' => 'maestro-configuracion_general.igv.show']);
        Permission::create(['name' => 'maestro-configuracion_general.igv.edit']);
        Permission::create(['name' => 'maestro-configuracion_general.igv.update']);
        Permission::create(['name' => 'maestro-configuracion_general.igv.destroy']);


        //Admin
        $admin = Role::create(['name' => 'Admin']);

        $admin->givePermissionTo([
            'inicio',
            'transacciones',
            'transacciones-ventas',
            'transacciones-ventas-cotizaciones.index',
            'transacciones-ventas-facturacion.index',
            'transacciones-ventas-boleta.index',
            'transacciones-ventas-guia_remision.index',
            'transacciones-garantias',
            'transacciones-garantias-guias_ingreso.index',
            'transacciones-garantias-guias_egreso.index',
            'transacciones-garantias-informe_tecnico.index',
            'inventario',
            'inventario-productos_kardex',
            'inventario-productos_kardex-entrada_producto.index',
            'inventario-productos_kardex-salida_producto.index',
            'inventario-productos-inventario_inicial.index',
            'inventario-toma_de_inventario.index',
            'planilla',
            'planilla-datos_generales.index',
            'planilla-vendedores.index',
            'consultas-garantias',
            'consultas-garantias-guia_ingreso.index',
            'consultas-garantias-guia_egreso.index',
            'consultas-garantias-informe_tecnico.index',
            'auxiliares',
            'auxiliares-clientes.index',
            'auxiliares-provedores.index',
            'maestro',
            'maestro-catalogo',
            'maestro-catalogo-productos.index',
            'maestro-catalogo-clasificacion',
            'maestro-catalogo-clasificacion-categorias.index',
            'maestro-catalogo-clasificacion-familias.index',
            'maestro-catalogo-clasificacion-marcas.index',
            'maestro-tablas_generales',
            'maestro-tablas_generales-motivos.index',
            'maestro-almacenes.index',
            'maestro-usuarios.index',
            'maestro-monedas.index',
            'maestro-tipo_de_cambio.index',
            'maestro-configuracion_general',
            'maestro-configuracion_general.mi_empresa.index',
            'maestro-configuracion_general.unidad_de_medida.index',
            'maestro-configuracion_general.igv.index'
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
