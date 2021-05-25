<?php

namespace App\Http\Controllers;

use App\Config_fe;
use App\Facturacion;
use DateTime;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturacionElectronicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturacion=Facturacion::all();
        return view('facturacion_electronica.factura.index',compact('facturacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function factura(Request $request)
    {
        $see=Config_fe::facturacion_electronica();

        // Cliente
        $client = (new Client())
        ->setTipoDoc('6')
        ->setNumDoc('20000000001')
        ->setRznSocial('EMPRESA X');

        // Emisor
        $address = (new Address())
        ->setUbigueo('150101')
        ->setDepartamento('LIMA')
        ->setProvincia('LIMA')
        ->setDistrito('LIMA')
        ->setUrbanizacion('-')
        ->setDireccion('Av. Villa Nueva 221')
        ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
        ->setRuc('20123456789')
        ->setRazonSocial('GREEN SAC')
        ->setNombreComercial('GREEN')
        ->setAddress($address);

        // Venta
        $invoice = (new Invoice())
        ->setUblVersion('2.1')
        ->setTipoOperacion('0101') // Venta - Catalog. 51
        ->setTipoDoc('01') // Factura - Catalog. 01 
        ->setSerie('F001')
        ->setCorrelativo('1')
        ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
        ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
        ->setTipoMoneda('PEN') // Sol - Catalog. 02
        ->setCompany($company)
        ->setClient($client)
        ->setMtoOperGravadas(100.00)
        ->setMtoIGV(18.00)
        ->setTotalImpuestos(18.00)
        ->setValorVenta(100.00)
        ->setSubTotal(118.00)
        ->setMtoImpVenta(118.00)
        ;

        $item = (new SaleDetail())
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

        $legend = (new Legend())
        ->setCode('1000') // Monto en letras - Catalog. 52
        ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $invoice->setDetails([$item])
            ->setLegends([$legend]);

            $result = $see->send($invoice);

            // Guardar XML firmado digitalmente.
            file_put_contents($invoice->getName().'.xml',
                              $see->getFactory()->getLastXml());
            
            // Verificamos que la conexión con SUNAT fue exitosa.
            if (!$result->isSuccess()) {
                // Mostrar error al conectarse a SUNAT.
                echo 'Codigo Error: '.$result->getError()->getCode();
                echo 'Mensaje Error: '.$result->getError()->getMessage();
                exit();
            }
            
            // Guardamos el CDR
            file_put_contents('R-'.$invoice->getName().'.zip', $result->getCdrZip());

            Config_fe::lectura_cdr($result->getCdrResponse());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
