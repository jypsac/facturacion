<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

$see = new See();
$see->setService(SunatEndpoints::FE_BETA);
$see->setCertificate(file_get_contents(public_path('certificado/certificate.pem'));
$see->setCredentials('20000000001MODDATOS'/*ruc+usuario*/, 'moddatos');

return $see;
