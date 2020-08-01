<?php

namespace App;

use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

// CLAVE SOL utilizada.
// Ruc: 20000000001
// Usuario: MODDATOS
// Contraseña: moddatos

     function facturacion_electronica(){
        $see = new See();
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setCertificate(file_get_contents(public_path('certificado/certificate.pem')));
        $see->setCredentials('20000000001MODDATOS'/*ruc+usuario*/, 'moddatos');
        return $see;
    }



