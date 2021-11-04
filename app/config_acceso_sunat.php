<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Model\Sale\Document;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Sale\Note;
use DateTime;
use Illuminate\Support\Facades\Storage;

use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

use Luecano\NumeroALetras\NumeroALetras;

class config_acceso_sunat extends Model
{
    public static function facturacion_electronica(){

        $see = new See();
        $pfx = file_get_contents(public_path('certificado/certificado.p12'));
        $password = 'Ndalmaten81';

        $certificate = new X509Certificate($pfx, $password);
        
        $see->setCertificate($certificate->export(X509ContentType::PEM));
        //  $see->setCertificate(file_get_contents(public_path('certificado\certificate.pem')));
        $see->setService(SunatEndpoints::FE_BETA);
        //  $see->setClaveSOL('20000000001', 'MODDATOS', 'moddatos');
        $see->setClaveSOL('20601021081', 'JYPSACPE', '@Claveso1');
        return $see;

    }

    public static function guia_electronica(){

        $see = new See();
        //$see->setCertificate(file_get_contents(public_path('certificado/certificado.p12')));

        $pfx = file_get_contents(public_path('certificado/certificado.p12')); 
        $password = 'Tecnologia20';

        $certificate = new X509Certificate($pfx, $password);

        $see->setCertificate($certificate->export(X509ContentType::PEM));

        // $see->setService(SunatEndpoints::GUIA_PRODUCCION);
        $see->setService(SunatEndpoints::GUIA_BETA);
        $see->setClaveSOL('20545122520', 'JYPSACFA', 'P@@@W0RDs');
        return $see;
    }


    public static function send($see, $invoice){

        $result = $see->send($invoice);

        // Guardar XML firmado digitalmente.
        Storage::disk('facturas_electronicas')->put($invoice->getName().'.xml',$see->getFactory()->getLastXml());

        // Verificamos que la conexión con SUNAT fue exitosa.
        if (!$result->isSuccess()) {
            // Mostrar error al conectarse a SUNAT.
            echo 'Codigo Error: '.$result->getError()->getCode();
            echo 'Mensaje Error: '.$result->getError()->getMessage();
            exit();
        }

        // Guardamos el CDR [pregunats si se guardan las boletas]
        Storage::disk('facturas_electronicas')->put('R-'.$invoice->getName().'.zip', $result->getCdrZip());

        return $result;
    }

    public static function lectura_cdr($cdr){

        $code = (int)$cdr->getCode();

        if ($code === 0) {
            echo 'ESTADO: ACEPTADA'.PHP_EOL;
            if (count($cdr->getNotes()) > 0) {
                echo 'OBSERVACIONES:'.PHP_EOL;
            // Corregir estas observaciones en siguientes emisiones.
                var_dump($cdr->getNotes());
            }
        }else if ($code >= 2000 && $code <= 3999) {
            echo 'ESTADO: RECHAZADA'.PHP_EOL;
        }else{
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            echo 'Excepción';
        }

        return $cdr->getDescription().PHP_EOL;
    }


}
