<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'cargos_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar($pagina = 0) {
        
    }

    public function agregar() {
        $data['title'] = 'Agregar Cargo';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cargos/js/agregar.js'
        );
        $data['view'] = 'cargos/agregar';

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('cargo', 'Cargo', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'cargo' => $this->input->post('cargo')
            );

            $cargo = $this->cargos_model->get_where($where);

            if ($cargo) {  // Si el cargo ya existe
                $json = array(
                    'status' => 'error',
                    'data' => 'El cargo ' . $this->input->post('cargo') . ' ya existe'
                );
                echo json_encode($json);
            } else {  // Si no existe el cargo
                $set = array(
                    'cargo' => $this->input->post('cargo'),
                    'fecha_creacion' => date("Y-m-d H:i:s"),
                    'idcreador' => $session['SID'],
                    'actualizado_por' => $session['SID']
                );

                $resultado = $this->cargos_model->set($set);

                if ($resultado) { // Si se agregó correctamente
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó el cargo ' . $this->input->post('cargo')
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

}

?>