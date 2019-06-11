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

            echo "<pre>";
            foreach ($monedas as $moneda) {
                if ($moneda['codigo_afip'] != 'PES' && $moneda['codigo_afip'] != '') {
                    $cotizacion = $wsfe->getTipoDeCambio($moneda['codigo_afip']);
                    echo "<strong>Cotización del día: </strong><br>";
                    print_r($cotizacion);

                    $where = array(
                        'idmoneda' => $moneda['idmoneda'],
                        'fecha' => $cotizacion->FchCotiz
                    );
                    $resultado = $this->monedas_model->get_where_monedas_historial($where);

                    if (!$resultado) {
                        $datos = array(
                            'idmoneda' => $moneda['idmoneda'],
                            'valor' => $cotizacion->MonCotiz,
                            'Fecha' => $cotizacion->FchCotiz
                        );
                        $this->monedas_model->set_monedas_historial($datos);
                    }
                }
            }
            echo "</pre>";
        }
    }

    public function backup() {
        $this->load->dbutil();
        $prefs = array(
            'tables' => array(),
            'ignore' => array(
                'padrones_items'
            ),
// gzip, zip, txt
            'format' => 'gzip',
// Nombre de archivo - NECESARIO SOLAMENTE CON ARCHIVOS ZIP
            'filename' => 'mybackup.sql.gzip',
// Si agrega sentencias DROP TABLE al archivo de copia de respaldo
            'add_drop' => TRUE,
// Si agrega datos INSERT al archivo de copia de respaldo
            'add_insert' => TRUE,
// Carácter de Nueva Línea usado en el archivo de copia de respaldo
            'newline' => "\n"
        );
        $backup =& $this->dbutil->backup($prefs);

        $this->load->helper('download');
        force_download('Backup '.date("Y-m-d H-i-s").".sql.gzip", $backup);
    }

}

?>
