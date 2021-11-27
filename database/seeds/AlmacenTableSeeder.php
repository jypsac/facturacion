<?php


use Illuminate\Database\Seeder;

class AlmacenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('almacen')->insert([
      'id' => 1 ,
      'nombre' => 'Almacen 1',
      'abreviatura' => 'ALM1',
      'direccion' => 'Direccion',
      'responsable' => '1',
      'cod_postal' => '150101',
      'descripcion' => 'Descripcion',
      'estado' => '0',
      'principal' => '1',
      'created_at' => date('2019-08-01 00:00:00'),
      'updated_at' => date('2019-08-01 00:00:00')
      ]);
      DB::table('cod_guia_almacen')->insert([
      'id' => 1 ,
      'almacen_id' => 1,
      'cod_sunat' => '1',
      'serie_factura' => '1',
      'cod_factura' => '0',
      'serie_boleta' => '1',
      'cod_boleta' => '0',
      'serie_remision' => '1',
      'cod_remision' => '0',
      'serie_nota_credito' => '1',
      'cod_nota_credito' => '0',
      'serie_nota_debito' => '1',
      'cod_nota_debito' => '0',
      'created_at' => date('2019-08-01 00:00:00'),
      'updated_at' => date('2019-08-01 00:00:00')
      ]);
      // DB::table('almacen')->insert([
      // 'id' => 2 ,
      // 'nombre' => 'Almacen 2',
      // 'abreviatura' => 'ALM2',
      // 'serie_factura' => '1',
      // 'serie_boleta' => '1',
      // 'serie_remision' => '1',
      // 'codigo_sunat' => '2',
      // 'direccion' => 'Calle Cuzco nr1 Lima-Lima',
      // 'responsable' => '1',
      // 'cod_postal' => '154545',
      // 'descripcion' => 'Almacen de impresoras',
      // 'cod_fac' => '4',
      // 'cod_bol' => '21',
      // 'cod_guia' => '23',
      // 'estado' => '0',
      // 'principal' => '0',
      // 'created_at' => date('2019-08-01 00:00:00'),
      // 'updated_at' => date('2019-08-01 00:00:00')
      // ]);
    //   DB::table('almacen')->insert([
    //   'id' => 3 ,
    //   'nombre' => 'Almacen 3',
    //   'abreviatura' => 'ALM3',
    //   'codigo_sunat' => '3',
    //   'direccion' => 'Calle Cuzco nr1 Lima-Lima',
    //   'responsable' => '1',
    //   'descripcion' => 'Almacen de impresoras',
    //   'cod_fac' => '4',
    //   'cod_bol' => '21',
    //   'cod_guia' => '23',
    //   'estado' => '0',
    //   'principal' => '0',
    //   'created_at' => date('2019-08-01 00:00:00'),
    //   'updated_at' => date('2019-08-01 00:00:00')
    //   ]);
    }
  }
