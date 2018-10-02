<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'parametros_model',
            'certificados_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);

        require_once('assets/vendors/afip/wsfe-class-ci.php');
    }

    public function agregar() {
        $data['title'] = 'Subir Certificado';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'certificados/agregar';


        $where = array(
            'identificador' => 'ruta_certificados'
        );
        $valor = $this->parametros_model->get_where($where);
        $data['ruta'] = $valor['valor_sistema'];
        /*
          if (substr($data['ruta'], 0, 1) == '/') {
          $data['ruta'] = substr($data['ruta'], 1, strlen($data['ruta']));
          }
         */


        $config['upload_path'] = "." . $data['ruta'];
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        $flag = true;
        if (!$this->upload->do_upload('certificado')) {  // Si no se sube el certificado
            $error = array('error' => $this->upload->display_errors());
            $flag = false;
        } else {  // Si sube el certificado
            $data['certificado'] = $this->upload->data();
            if (!$this->upload->do_upload('clave')) {  // Si no se sube la clave
                $error = array('error' => $this->upload->display_errors());
                $flag = false;
            } else {
                $data['clave'] = $this->upload->data();
                if ($flag) {
                    $datos = array(
                        'nombre' => $this->input->post('nombre'),
                        'certificado' => $data['ruta'] . $data['certificado']['raw_name']. $data['certificado']['file_ext'],
                        'clave' => $data['ruta'] . $data['clave']['raw_name'] . $data['clave']['file_ext'],
                        'fecha_desde' => $this->formatear_fecha($this->input->post('fecha_desde')),
                        'fecha_hasta' => $this->formatear_fecha($this->input->post('fecha_hasta')),
                        'idusuario' => $data['session']['SID']
                    );
                    
                    $resultado = $this->certificados_model->set($datos);
                    
                    if($resultado) {
                        redirect('/certificados/listar/', 'refresh');
                    }
                }
            }
        }

        $this->load->view('layout/app', $data);
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

    private function formatear_fecha($fecha) {
        $aux = '';
        $aux .= substr($fecha, 6, 4);
        $aux .= '-';
        $aux .= substr($fecha, 3, 2);
        $aux .= '-';
        $aux .= substr($fecha, 0, 2);

        return $aux;
    }
}

?>
