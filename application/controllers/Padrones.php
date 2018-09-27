<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Padrones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'provincias_model',
            'parametros_model',
            'padrones_model'
        ));
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function importar() {
        $data['title'] = 'Importar Padrón';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/padrones/js/importar.js'
        );
        $data['view'] = 'padrones/importar';

        $data['jurisdicciones'] = $this->provincias_model->gets();

        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);

        $data['archivos'] = opendir("." . $ruta_upload['valor_sistema']);

        $this->load->view('layout/app', $data);
    }

    public function procesar_ajax() {
        $this->form_validation->set_rules('jurisdiccion', 'Jurisdicción', 'required|integer');
        $this->form_validation->set_rules('archivo', 'Archivo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $jurisdiccion = $this->input->post('jurisdiccion');

            switch ($jurisdiccion) {
                case '901':  // CABA
                    $this->jurisdiccion_901($this->input->post('archivo'));
                    break;
                default :
                    $json = array(
                        'status' => 'error',
                        'data' => 'No existe proceso para esta jurisdicción'
                    );
                    echo json_encode($json);
                    break;
            }
        }
    }

    private function jurisdiccion_901($archivo) {  //  CABA
        $where = array(
            'identificador' => 'ruta_upload',
            'estado' => 'A'
        );
        $ruta_upload = $this->parametros_model->get_where($where);

        $url = substr($ruta_upload['valor_sistema'], 1); // Quito el primer caracter
        $fp = fopen($url . $archivo, "r");
        
        while (!feof($fp)) {
            
            $linea = fgets($fp);
            $array = preg_split('/;/', $linea);
            /*
             *  [0] = Fecha publicación
             *  [1] = Fecha desde
             *  [2] = Fecha hasta
             *  [3] = CUIT
             *  [7] = Percepción
             *  [8] = Retención
             *  [11] = Razon Social
             */
            
            $set = array(
                'idjurisdiccion_afip' => 901,
                'fecha_publicacion' => $this->formatear_fecha($array[0]),
                'fecha_desde' => $this->formatear_fecha($array[1]),
                'fecha_hasta' => $this->formatear_fecha($array[2]),
                'cuit' => $array[3],
                'percepcion' => $array[7],
                'retencion' => $array[8],
                'razonsocial' => trim($array[11])
            );
            
            $this->padrones_model->set($set);
            
        }

        $json = array(
            'status' => 'ok',
            'data' => 'Se completó el proceso correctamente'
        );
        echo json_encode($json);
    }
    
    private function formatear_fecha($fecha) {
        $aux = '';
        $aux .= substr($fecha, 4, 4);
        $aux .= '-';
        $aux .= substr($fecha, 2, 2);
        $aux .= '-';
        $aux .= substr($fecha, 0, 2);

        return $aux;
    }
}

?>
