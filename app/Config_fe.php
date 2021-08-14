<?php
namespace App;

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

use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Luecano\NumeroALetras\NumeroALetras;
use App\Empresa;
use App\Igv;
use App\Cuotas_Credito;
use App\Guia_remision;
use App\TransportePublico;


// DATOS DE PRUEBA
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

    public static function guia_electronica(){

        $see = new See();
        $see->setCertificate(file_get_contents(public_path('certificado\certificate.pem')));
        $see->setService(SunatEndpoints::GUIA_BETA);
        $see->setClaveSOL('20000000001', 'MODDATOS', 'moddatos');
        // ...

        // $pfx = file_get_contents('mycert.pfx');
        // $password = 'YOUR-PASSWORD';

        // $certificate = new X509Certificate($pfx, $password);

        // $see->setCertificate($certificate->export(X509ContentType::PEM));

// ...

        return $see;
    }

    public static function factura($factura,$facturas_registros,$guia){

        //libro: https://cpe.sunat.gob.pe/sites/default/files/inline-files/guia%2Bxml%2Bfactura%2Bversion%202-1%2B1%2B0%20%282%29_0.pdf
        // return $guia;
        if($guia==1){
            $guiaRemision = (new Document())
            ->setTipoDoc('09') // Guia de Remision remitente: 09, catalogo 01
            ->setNroDoc($factura->guia_remision); // Serie y correlativo de la guia de remision
            
        }

        $empresa=Empresa::first();
        $igv=Igv::first();

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


        $igv_f=0;
        $gravada=0;
        $precio=0;
        

        foreach($facturas_registros as $cont => $factura_registro){
            $item[$cont] = (new SaleDetail())
            ->setCodProducto($factura_registro->producto->codigo_producto)//codigo del producto
            ->setUnidad('NIU') // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
            ->setCantidad($factura_registro->cantidad)
            ->setMtoValorUnitario($factura_registro->precio)
            ->setDescripcion($factura_registro->producto->nombre)
            ->setMtoBaseIgv($factura_registro->precio*$factura_registro->cantidad)
            ->setPorcentajeIgv($igv->igv_total) // 18%
            ->setIgv($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100))
            ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
            ->setMtoValorVenta($factura_registro->precio*$factura_registro->cantidad)
            ->setMtoPrecioUnitario($factura_registro->precio+($factura_registro->precio*(($igv->igv_total)/100)))
            ;
            //sumatorias
            $igv_f=$factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
            $precio=$factura_registro->precio*$factura_registro->cantidad+$precio;
            if($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)!=0){
                $gravada=$gravada+$factura_registro->precio*$factura_registro->cantidad;
            }
        }
        $total=$igv_f+$precio;
        // return $gravada;

        //codigo factura
        $codigo_factura=$factura->codigo_fac;
        $serie=explode("-",$codigo_factura);

        $correlativo=$serie[1];
        $serie=$serie[0];

        if($factura->forma_pago_id==1){
            // Venta - contado
            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie 
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            
            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02
            
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            if($guia==1){
                $invoice->setGuias([
                    $guiaRemision // Incluir guia remision.
                ]);
            }


            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');
            
            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);
            
            $invoice->setDetails($item)
            ->setLegends([$legend]);
            
            return $invoice;
        }else{
            // Venta - credito
            $cuotas=Cuotas_Credito::where('facturacion_id',$factura->id)->get();

            foreach ($cuotas as $key => $cuota) {
                # code...
                $cuotas_credito[$key]=(new Cuota())
                ->setMonto($cuota->monto)
                ->setFechaPago(new DateTime('+7days'));
            }

            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie 
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoCredito()) // FormaPago: credito
            ->setCuotas(
                $cuotas_credito
            )
            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            if($guia==1){
                $invoice->setGuias([
                    $guiaRemision // Incluir guia remision.
                ]);
            }
            

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');
            
            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);
            
            $invoice->setDetails($item)
            ->setLegends([$legend]);
            
            return $invoice;
        }
    }
    
    public static function factura_servicio($factura,$facturas_registros,$guia){
        
        $empresa=Empresa::first();
        $igv=Igv::first();
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


        $igv_f=0;
        $gravada=0;
        $precio=0;
        

        foreach($facturas_registros as $cont => $factura_registro){
            $item[$cont] = (new SaleDetail())
            ->setCodProducto($factura_registro->servicio->codigo_servicio)//codigo del producto
            ->setUnidad('ZZ') // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
            ->setCantidad($factura_registro->cantidad)
            ->setMtoValorUnitario($factura_registro->precio)
            ->setDescripcion($factura_registro->servicio->nombre)
            ->setMtoBaseIgv($factura_registro->precio*$factura_registro->cantidad)
            ->setPorcentajeIgv($igv->igv_total) // 18%
            ->setIgv($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100))
            ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
            ->setMtoValorVenta($factura_registro->precio*$factura_registro->cantidad)
            ->setMtoPrecioUnitario($factura_registro->precio+($factura_registro->precio*(($igv->igv_total)/100)))
            ;
            //sumatorias
            $igv_f=$factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
            $precio=$factura_registro->precio*$factura_registro->cantidad+$precio;
            if($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)!=0){
                $gravada=$gravada+$factura_registro->precio*$factura_registro->cantidad;
            }
        }
        $total=$igv_f+$precio;
        // return $gravada;

        //codigo factura
        $codigo_factura=$factura->codigo_fac;
        $serie=explode("-",$codigo_factura);

        $correlativo=$serie[1];
        $serie=$serie[0];

        if($factura->forma_pago_id==1){
            // Venta - contado
            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie 
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            
            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02
            
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;


            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');
            
            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);
            
            $invoice->setDetails($item)
            ->setLegends([$legend]);
            
            return $invoice;
        }else{
            // Venta - credito
            $cuotas=Cuotas_Credito::where('facturacion_id',$factura->id)->get();

            foreach ($cuotas as $key => $cuota) {
                # code...
                $cuotas_credito[$key]=(new Cuota())
                ->setMonto($cuota->monto)
                ->setFechaPago(new DateTime('+7days'));
            }

            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie 
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoCredito()) // FormaPago: credito
            ->setCuotas(
                $cuotas_credito
            )
            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');
            
            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);
            
            $invoice->setDetails($item)
            ->setLegends([$legend]);
            
            return $invoice;
        }
        
    }

    public static function boleta($boleta,$boletas_registros){

        $empresa=Empresa::first();
        $igv=Igv::first();

        // Cliente
        $client = (new Client())
        ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
        ->setNumDoc($boleta->cliente->numero_documento) //ruc del receptor
        ->setRznSocial($boleta->cliente->empresa); //nombre empresa

        // Emisor
        $address = new Address();
        $address->setUbigueo('150101')
        ->setDepartamento($empresa->region_provincia)
        ->setProvincia($empresa->region_provincia)
        ->setDistrito($empresa->ciudad)
        ->setUrbanizacion('-')
        ->setDireccion($empresa->calle);

        $company = (new Company())
        ->setRuc($empresa->ruc)
        ->setRazonSocial($empresa->razon_social)
        ->setNombreComercial($empresa->nombre)
        ->setAddress($address);

        $igv_f=0;
        $gravada=0;
        $precio=0;


        $igv_f=0;
        $gravada=0;
        $precio=0;
        
        foreach($boletas_registros as $cont => $boleta_registro){
            $item[$cont] = (new SaleDetail())
            ->setCodProducto($boleta_registro->producto->codigo_producto)//codigo del producto
            ->setUnidad('NIU') // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
            ->setCantidad($boleta_registro->cantidad)
            ->setMtoValorUnitario($boleta_registro->precio)
            ->setDescripcion($boleta_registro->producto->nombre)
            ->setMtoBaseIgv($boleta_registro->precio*$boleta_registro->cantidad)
            ->setPorcentajeIgv($igv->igv_total) // 18%
            ->setIgv($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100))
            ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
            ->setMtoValorVenta($boleta_registro->precio*$boleta_registro->cantidad)
            ->setMtoPrecioUnitario($boleta_registro->precio+($boleta_registro->precio*(($igv->igv_total)/100)))
            ;
            //sumatorias
            $igv_f=$boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
            $precio=$boleta_registro->precio*$boleta_registro->cantidad+$precio;
            if($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100)!=0){
                $gravada=$gravada+$boleta_registro->precio*$boleta_registro->cantidad;
            }
        }
        $total=$igv_f+$precio;
        // return $gravada;

        //codigo factura
        $codigo_boleta=$boleta->codigo_boleta;
        $serie=explode("-",$codigo_boleta);

        $correlativo=$serie[1];
        $serie=$serie[0];

        if($boleta->forma_pago_id==1){
            //contado
            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('03') // boleta - Catalog. 03  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie 
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
            
            ->setTipoMoneda($boleta->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($boleta->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');
            
            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);
            
            $invoice->setDetails($item)
            ->setLegends([$legend]);
            
            return $invoice;
        }else{
            //credito
            $cuotas=Cuotas_Credito::where('boleta_id',$boleta->id)->get();

            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('03') // boleta - Catalog. 03  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie 
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
            ->setFormaPago(new FormaPagoCredito()) // FormaPago: credito
            ->setCuotas([
                // $cuotas_credito
                (new Cuota()) //->                   meterlo en un foreach exlusivo de array
                ->setMonto(59)
                ->setFechaPago(new DateTime('+7days'))
            ])
            ->setTipoMoneda($boleta->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($boleta->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');
            
            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);
            
            $invoice->setDetails($item)
            ->setLegends([$legend]);
            
            return $invoice;
        }
    }

    //llenado guia de remision
    public static function guia_remision($guia, $guias_registros,$tipo_transporte){
        
        //$util = Util::getInstance();
        $empresa=Empresa::first();

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

        //$rel = new Document();
        //$rel->setTipoDoc('02') // Tipo: Numero de Orden de Entrega
        //->setNroDoc('213123'); //Buscar ayuda sobre ello


        if($tipo_transporte==1){ //TRASNPORTE PUBLICO
            $vehiculo_trasporte=TransportePublico::where('id',$guia->vehiculo_publico)->first();
            $transp = new Transportist();
            $transp->setTipoDoc('6')
            ->setNumDoc($vehiculo_trasporte->ruc)          //falta documentacion del conductor
            ->setRznSocial($vehiculo_trasporte->nombre); //nombre de la conduccion

        }elseif($tipo_transporte==2){   //TRASPORTE PRIVADO
            $empleado=Personal::where('id',$guia->conductor_id)->first();
            $transp = new Transportist();
            $transp->setTipoDoc('6')
            ->setNumDoc($empresa->ruc)          //falta documentacion del conductor
            ->setRznSocial($empresa->razon_social) //nombre de la conduccion
            ->setPlaca($guia->vehiculo->placa)   
            ->setChoferTipoDoc('1')     //ayuda
            ->setChoferDoc($empleado->numero_documento);         //doc chofer
        }
        

        //obtencion del peso total
        $peso_total=0;
        foreach($guias_registros as $guia_electronica){
            $peso_total=$peso_total + $guia_electronica->peso;
        }

        if($tipo_transporte==0){
            $envio = new Shipment();
            $envio
                ->setCodTraslado('01') // Cat.20
                ->setDesTraslado('VENTA')
                ->setModTraslado('01') // Cat.18
                ->setFecTraslado(new DateTime())
                // ->setCodPuerto('123')
                ->setIndTransbordo(false)
                ->setPesoTotal($peso_total)
                ->setUndPesoTotal('KGM')    //unidad de medida
                // ->setNumContenedor('XD-2232')
                ->setLlegada(new Direction($guia->cliente->cod_postal, $guia->cliente->direccion))   //arreglar el ubigeo de llegada  salida
                ->setPartida(new Direction($guia->almacen->cod_postal, $guia->almacen->direccion));    //arreglar el ubigeo de llegada  salida
            }else{
                $envio = new Shipment();
                $envio
                ->setCodTraslado('01') // Cat.20
                ->setDesTraslado('VENTA')
                ->setModTraslado('01') // Cat.18
                ->setFecTraslado(new DateTime())
                // ->setCodPuerto('123')
                ->setIndTransbordo(false)
                ->setPesoTotal($peso_total)
                ->setUndPesoTotal('KGM')    //unidad de medida
                // ->setNumContenedor('XD-2232')
                ->setLlegada(new Direction($guia->cliente->cod_postal, $guia->cliente->direccion))    //arreglar el ubigeo de llegada  salida
                ->setPartida(new Direction($guia->almacen->cod_postal, $guia->almacen->direccion))    //arreglar el ubigeo de llegada  salida
                ->setTransportista($transp);
            }

        //codigo correlaativo
            $codigo_guia=$guia->cod_guia;
            $serie=explode("-",$codigo_guia);

            $correlativo=$serie[1];
            $serie_g=$serie[0];


            $despatch = new Despatch();
            $despatch->setTipoDoc('09')
            ->setSerie($serie_g)      //cambiar codigo de guia
            ->setCorrelativo($correlativo)
            ->setFechaEmision(new DateTime())
            ->setCompany($company)
            ->setDestinatario((new Client())
                ->setTipoDoc('6')
                ->setNumDoc($guia->cliente->numero_documento)
                ->setRznSocial($guia->cliente->empresa))
            ->setObservacion($guia->observacion)
            //->setRelDoc($rel)
            ->setEnvio($envio);

            foreach($guias_registros as $cont => $guia_registro){
                $detail[$cont] = new DespatchDetail();
                $detail[$cont]->setCantidad(2)
                ->setUnidad('ZZ')
                ->setDescripcion($guia_registro->producto->nombre)
                ->setCodigo($guia_registro->producto->codigo_producto)
                ->setCodProdSunat($guia_registro->producto->codigo_producto);
            }

            $despatch->setDetails($detail);

            return $despatch;
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
            } else if ($code >= 2000 && $code <= 3999) {
                echo 'ESTADO: RECHAZADA'.PHP_EOL;
            } else {
                /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
                /*code: 0100 a 1999 */
                echo 'Excepción';
            }

            return $cdr->getDescription().PHP_EOL;
        }
    }

