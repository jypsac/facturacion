<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

//DATOS DE PRUEBA
// RUC: 20000000001
// Usuario: MODDATOS
// Contraseña: moddatos

class Config_fe extends Model
{
    protected $table = 'config_fe';

    protected $guarded = [];

    public static function facturacion_electronica(){
        $see = new See();
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setCertificate(file_get_contents(public_path('certificado/certificate.pem')));
        $see->setCredentials('20000000001MODDATOS'/*ruc+usuario*/, 'moddatos');
        return $see;
    }
}

