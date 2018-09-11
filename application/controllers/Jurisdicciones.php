<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurisdicciones extends CI_Controller {

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

    public function actualizar() {
        $data['title'] = 'Actualizar Jurisdicción';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/jurisdicciones/js/actualizar.js'
        );
        $data['view'] = 'jurisdicciones/actualizar';

        $data['provincias'] = $this->provincias_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function actualizar_ajax() {
        $this->form_validation->set_rules('idprovincia', 'ID de Provincia', 'required|numeric');
        $this->form_validation->set_rules('idjurisdiccion', 'ID Jurisdicción AFIP', 'required|numeric');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $datos = array(
                'idjurisdiccion_afip' => $this->input->post('idjurisdiccion')
            );
            $where = array(
                'idprovincia' => $this->input->post('idprovincia')
            );
            $resultado = $this->provincias_model->update($datos, $where);
            if ($resultado) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'La jurisdicción se actualizó correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'Ocurrió un error inesperado'
                );
                echo json_encode($json);
            }
        }
    }

}

?>
