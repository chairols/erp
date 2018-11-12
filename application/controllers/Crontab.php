<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Crontab extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
    }

    public function monedas() {
        require_once('assets/vendors/afip/wsfe-class-ci.php');
        $this->load->model(array(
            'monedas_model'
        ));
        
        // Certificado REAL
        $certificado = 'upload/certificados/PCAFIP_794703585cef0a60.crt';
        $clave = "upload/certificados/privada_794703585cef0a60";
        
        // Configuración
        $CUIT = 33647656779;
        $urlwsaa = URLWSAA;

        $wsfe = new WsFE();
        $wsfe->CUIT = floatval($CUIT);
        $wsfe->setURL(URLWSW);

        if ($wsfe->Login($certificado, $clave, $urlwsaa)) {
            
            $monedas = $this->monedas_model->gets();
            
            foreach($monedas as $moneda) {
                if($moneda['codigo_afip'] != 'PES' && $moneda['codigo_afip'] != '') {
                    $cotizacion = $wsfe->getTipoDeCambio($moneda['codigo_afip']);
                    
                    $where = array(
                        'idmoneda' => $moneda['idmoneda'],
                        'fecha' => $cotizacion->FchCotiz
                    );
                    $resultado = $this->monedas_model->get_where_monedas_historial($where);
                    
                    if(!$resultado) {
                        $datos = array(
                            'idmoneda' => $moneda['idmoneda'],
                            'valor' => $cotizacion->MonCotiz,
                            'Fecha' => $cotizacion->FchCotiz
                        );
                        $this->monedas_model->set_monedas_historial($datos);
                    }
                    
                }
            }
        }
    }

}

?>
