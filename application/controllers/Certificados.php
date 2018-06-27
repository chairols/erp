<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados extends CI_Controller {

    public function __construct() {
        parent::__construct();

        require_once('assets/vendors/afip/wsfe-class-ci.php');
    }

    public function index($numeroFactura = 8) {
        $certificado = "upload/certificados/hernan.crt";
        $clave = "upload/certificados/hernan.privada";


        $CUIT = 33647656779;
        $urlwsaa = URLWSAA;

        $wsfe = new WsFE();
        $wsfe->CUIT = floatval($CUIT);
        $wsfe->setURL(URLWSW);

        $PtoVta = 3;
        $TipoComp = 1;



        if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
            if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
                echo $wsfe->ErrorDesc;
            } else {
                echo "<pre>";
                print_r($wsfe->getUltimoComprobanteAutorizado($PtoVta, $TipoComp));
                print_r($wsfe->getDatosFactura($TipoComp, $PtoVta, $numeroFactura));
                echo "</pre>";
            }
        }
    }

    public function facturar() {
        $certificado = "upload/certificados/hernan.crt";
        $clave = "upload/certificados/hernan.privada";


        $CUIT = 33647656779;
        $urlWsaa = URLWSAA;

        $wsfe = new WsFE();
        $wsfe->CUIT = floatval($CUIT);
        $wsfe->setURL(URLWSW);

        $PtoVta = 3;
        $TipoComp = 1;  // Tipo de Comprobante, ej 1 = Factura A

        if ($wsfe->Login($certificado, $clave, $urlWsaa)) {
            if (!$wsfe->RecuperaLastCMP($PtoVta, $TipoComp)) {
                echo $wsfe->ErrorDesc;
            } else {
                echo "<pre>";
                print_r($wsfe->getUltimoComprobanteAutorizado($PtoVta, $TipoComp));

                $concepto = 1;   //  Concepto 1=Productos / 2=Servicios / 3=Productos y Servicios
                $TipoDoc = 80;   //  80 es CUIT
                $CuitCliente = 20123456789;
                $NumeroFacturaDesde = $wsfe->RespUltNro + 1;
                $NumeroFacturaHasta = $NumeroFacturaDesde;
                $FechaComprobante = date("Ymd");
                $Total = 15262.77;
                $ImpTotConc = 0;  // Total no gravado
                $ImpNeto = 12428.89;   //  Importe Neto gravado
                $ImpOpEx = 0;  //  Importe Exento
                $FchServDesde = "";  // Obligatorio en concepto 2 y 3
                $FchServHasta = "";  // Obligatorio en concepto 2 y 3
                $FchVtoPago = ""; // Obligatorio en concepto 2 y 3
                $MonedaId = "PES";
                $MonedaCotizacion = 1;

                $wsfe->Reset();
                $wsfe->AgregaFactura($concepto, $TipoDoc, $CuitCliente, $NumeroFacturaDesde, $NumeroFacturaHasta, $FechaComprobante, $Total, $ImpTotConc, $ImpNeto, $ImpOpEx, $FchServDesde, $FchServHasta, $FchVtoPago, $MonedaId, $MonedaCotizacion);

                /*
                 *  Agregar IVA
                 */
                $IdIVA = 5;   //  Tipo de IVA, ej 5 = 21%    FEParamGetTiposIVA
                $ImporteIVA = 2610.12;

                $wsfe->AgregaIVA($IdIVA, $ImpNeto, $ImporteIVA);


                /*
                 *  Agregar Tributo
                 */
                $IdTributo = 2;   //  En este caso, 2 = Impuestos Provinciales   FEParamGetTiposTributos
                $TributoDescripcion = "Percepcion IIBB";
                $TributoBaseImponible = $ImpNeto;
                $TributoAlicuota = 3;
                $TributoImporte = 223.76;

                $wsfe->AgregaTributo($IdTributo, $TributoDescripcion, $TributoBaseImponible, $TributoAlicuota, $TributoImporte);


                $auth = false;
                try {
                    if ($wsfe->Autorizar($PtoVta, $TipoComp)) {
                        $auth = true;
                    } else {
                        echo $wsfe->ErrorDesc;
                    }
                } catch (Exception $e) {
                    if ($wsfe->CmpConsultar($TipoComp, $PtoVta, $NumeroFacturaDesde, $cbte)) {
                        $auth = true;
                    } else {
                        //cii
                    }
                }
                if ($auth) {
                    $data['invoice_num'] = sprintf('%04d-', $PtoVta) . sprintf('%08d', $NumeroFacturaDesde);
                    $data['CAE'] = $wsfe->RespCAE;
                    $data['Vto'] = $wsfe->RespVencimiento;
                    $data['barcode'] = $CuitCliente . sprintf('%02d', $TipoComp) . sprintf('%04d', $PtoVta) . $wsfe->RespCAE . $wsfe->RespVencimiento;

                    echo "<pre>";
                    print_r($data);
                    echo "</pre>";
                }






                echo "</pre>";
            }
        }
    }

}

?>
