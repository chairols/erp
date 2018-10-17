<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calificaciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'calificaciones_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Calificación';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/calificaciones/js/agregar.js'
        );
        $data['view'] = 'calificaciones/agregar';



        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('calificacion', 'Calificación', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'calificacion' => $this->input->post('calificacion'),
                'orden' => 0,
                'padre' => 0
            );

            $id = $this->calificaciones_model->set($set);

            if ($id) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se creó la calificación '.$this->input->post('calificacion').' correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo crear la calificación'
                );
                echo json_encode($json);
            }
        }
    }

}

?>