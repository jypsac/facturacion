<?php
namespace App;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

use App\Empresa;

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
        $see->setCertificate(file_get_contents(public_path('certificado\certificate.pem')));
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setClaveSOL('20000000001', 'MODDATOS', 'moddatos');
        return $see;
    }

    public static function factura($factura,$facturas_registros){

        //libro: https://cpe.sunat.gob.pe/sites/default/files/inline-files/guia%2Bxml%2Bfactura%2Bversion%202-1%2B1%2B0%20%282%29_0.pdf

        // return $factura->moneda->nombre;
        $empresa=Empresa::first();
        // return $empresa;

        // Cliente
        $client = (new Client())
        ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
        ->setNumDoc($factura->cliente->numero_documento) //ruc del receptor
        ->setRznSocial($factura->cliente->empresa); //nombre empresa

        // Emisor
        $address = (new Address())
        ->setUbigueo('150101')
        ->setDepartamento($empresa->region_provincia)
        ->setProvincia($empresa->region_provincia)
        ->setDistrito($empresa->ciudad)
        ->setUrbanizacion('-')
        ->setDireccion($empresa->calle)
        ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
        ->setRuc($empresa->ruc)
        ->setRazonSocial($empresa->razon_social)
        ->setNombreComercial($empresa->nombre)
        ->setAddress($address);

        // Venta
        $invoice = (new Invoice())
        ->setUblVersion('2.1')
        ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
        ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
        ->setSerie('F001')// numero de serie 
        ->setCorrelativo('1') // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
        ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
        ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
        ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02
        ->setCompany($company)
        ->setClient($client)
        ->setMtoOperGravadas(200.00)
        ->setMtoIGV(36.00)
        ->setTotalImpuestos(36.00)
        ->setValorVenta(200.00)
        ->setSubTotal(236.00)
        ->setMtoImpVenta(236.00)
        ;

        foreach($facturas_registros as $cont => $factura_registro){
            $item[$cont] = (new SaleDetail())
            ->setCodProducto('P001')
            ->setUnidad('NIU') // Unidad - Catalog. 03
            ->setCantidad(2)
            ->setMtoValorUnitario(50.00)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18.00) // 18%
            ->setIgv(18.00)
            ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos(18.00) // Suma de impuestos en el detalle
            ->setMtoValorVenta(100.00)
            ->setMtoPrecioUnitario(59.00)
            ;

            
        }

        $item[1] = (new SaleDetail())
        ->setCodProducto('P0011')
        ->setUnidad('NIU') // Unidad - Catalog. 03
        ->setCantidad(2)
        ->setMtoValorUnitario(50.00)
        ->setDescripcion('PRODUCTO 21')
        ->setMtoBaseIgv(100)
        ->setPorcentajeIgv(18.00) // 18%
        ->setIgv(18.00)
        ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
        ->setTotalImpuestos(18.00) // Suma de impuestos en el detalle
        ->setMtoValorVenta(100.00)
        ->setMtoPrecioUnitario(59.00)
        ;

        $legend = (new Legend())
        ->setCode('1000') // Monto en letras - Catalog. 52
        ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $invoice->setDetails($item)
            ->setLegends([$legend]);

        return $invoice;
    }

    public static function factura_servicio(){

    }

    public static function boleta(){

    }

    public static function boleta_servicio(){

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
        // Guardamos el CDR
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
        } else if ($code >= 2000 && $code <= 3999) {
            echo 'ESTADO: RECHAZADA'.PHP_EOL;
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            echo 'Excepción';
        }

        echo $cdr->getDescription().PHP_EOL;
    }
}

