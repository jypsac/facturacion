<?php

namespace App\Http\Controllers;

use App\Config_fe;
use App\Facturacion;
use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\See;
use Greenter\Ws\Services\SunatEndpoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\facturacion_electronica;


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
        // return $facturacion;

        return view('facturacion_electronica.factura.index',compact('facturacion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function factura(Request $request)
    {
        $id=$request->input('factura_id');
        $factura=Facturacion::find($id);

        // VALIDACION SI LA FACTURA YA HA SIDO ENVIADA
            // CREACION DE NUEVO CAMPO EN MIGRACION PARA DETERMINAR SU ESTADO
        //FINAL DE VALIDACION


        $client=new Client();
        $client->setTipoDoc('6')->setNumDoc('20000000001')->setRznSocial('EMPRESA 1');

        $address = new Address();
        $address->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setDistrito('LIMA')
            ->setUrbanizacion('NONE')
            ->setDireccion('AV LS');

        $company = new Company();
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        // Venta
        $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Catalog. 51
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('1')
            ->setFechaEmision(new DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(100.00)
            ->setMtoIGV(18.00)
            ->setTotalImpuestos(18.00)
            ->setValorVenta(100.00)
            ->setSubTotal(118.00)
            ->setMtoImpVenta(118.00)
            ->setCompany($company);

        $item = (new SaleDetail())
            ->setCodProducto('P001')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PRODUCTO 1')
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18.00) // 18%
            ->setIgv(18.00)
            ->setTipAfeIgv('10')
            ->setTotalImpuestos(18.00)
            ->setMtoValorVenta(100.00)
            ->setMtoValorUnitario(50.00)
            ->setMtoPrecioUnitario(59.00);

        $legend = (new Legend())
            ->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

        $invoice->setDetails([$item])
        ->setLegends([$legend]);

//      $see=facturacion_electronica();
        $see = new See();
        $see->setService(SunatEndpoints::FE_BETA);
        $see->setCertificate(file_get_contents(public_path('certificado/certificate.pem')));
        $see->setCredentials('20000000001MODDATOS'/*ruc+usuario*/, 'moddatos');

        $result = $see->send($invoice);

        // Guardar XML
        file_put_contents($invoice->getName().'.xml',
            $see->getFactory()->getLastXml());
        if (!$result->isSuccess()) {
            var_dump($result->getError());
            exit();
        }

        echo $result->getCdrResponse()->getDescription();
        // Guardar CDR
        file_put_contents('R-'.$invoice->getName().'.zip', $result->getCdrZip());
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
