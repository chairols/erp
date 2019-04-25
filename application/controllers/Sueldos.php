<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sueldos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'sueldos_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar_concepto() {
        $data['title'] = 'Agregar Concepto';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/sueldos/js/agregar_concepto.js'
        );
        $data['view'] = 'sueldos/agregar_concepto';

        $this->load->view('layout/app', $data);
    }

    public function agregar_concepto_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idsueldo_concepto', 'Número de Concepto', 'required|integer');
        $this->form_validation->set_rules('sueldo_concepto', 'Concepto', 'required');
        $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        $this->form_validation->set_rules('cantidad', 'Cantidad', 'required|integer');
        $this->form_validation->set_rules('unidad', 'Unidad', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idsueldo_concepto' => $this->input->post('idsueldo_concepto')
            );
            $concepto = $this->sueldos_model->get_where_concepto($where);

            if ($concepto) {
                $json = array(
                        'status' => 'error',
                        'data' => 'Ya existe el concepto '.$this->input->post('idsueldo_concepto')
                    );
                    echo json_encode($json);
            } else {
                $set = array(
                    'idsueldo_concepto' => $this->input->post('idsueldo_concepto'),
                    'sueldo_concepto' => $this->input->post('sueldo_concepto'),
                    'tipo' => $this->input->post('tipo'),
                    'cantidad' => $this->input->post('cantidad'),
                    'unidad' => $this->input->post('unidad')
                );

                $idsueldo_concepto = $this->sueldos_model->set_concepto($set);
                if ($idsueldo_concepto) {
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó el concepto ' . $this->input->post('sueldo_concepto')
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo agregar el concepto'
                    );
                    echo json_encode($json);
                }
            }
        }
    }

}

?>