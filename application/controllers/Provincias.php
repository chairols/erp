<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Provincias extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'provincias_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function get_provincia_ajax() {
        $this->form_validation->set_rules('idprovincia', 'Identificador de Provincia', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idprovincia' => $this->input->post('idprovincia')
            );
            $resultado = $this->provincias_model->get_where($where);
            if ($resultado) {
                $resultado['status'] = 'ok';
                $resultado['data'] = 'Se actualizó correctamente.';
                echo json_encode($resultado);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ocurrió un error inesperado.'
                );
                echo json_encode($json);
            }
        }
    }

}

?>
