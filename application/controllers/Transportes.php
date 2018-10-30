<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transportes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'provincias_model',
            'tipos_responsables_model',
            'transportes_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Transporte';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['css'] = array(
            '/assets/vendors/timepicker/bootstrap-timepicker.min.css'
        );
        $data['javascript'] = array(
            '/assets/vendors/timepicker/bootstrap-timepicker.min.js',
            '/assets/modulos/transportes/js/agregar.js'
        );
        $data['view'] = 'transportes/agregar';

        $data['provincias'] = $this->provincias_model->gets();
        $data['tipos_responsables'] = $this->tipos_responsables_model->gets();

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('transporte', 'Transporte', 'required');
        $this->form_validation->set_rules('direccion', 'Dirección', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $set = array(
                'transporte' => $this->input->post('transporte'),
                'direccion' => $this->input->post('direccion'),
                'codigo_postal' => $this->input->post('codigo_postal'),
                'localidad' => $this->input->post('localidad'),
                'idprovincia' => $this->input->post('idprovincia'),
                'telefono' => $this->input->post('telefono'),
                'idtipo_responsable' => $this->input->post('idtipo_responsable'),
                'cuit' => $this->input->post('cuit'),
                'horario_desde' => $this->input->post('horario_desde'),
                'horario_hasta' => $this->input->post('horario_hasta'),
                'observaciones' => $this->input->post('observaciones'),
                'fecha_creacion' => date("Y-m-d H:i:s"),
                'idcreador' => $session['SID'],
                'actualizado_por' => $session['SID']
            );

            $id = $this->transportes_model->set($set);
            if ($id) {
                $json = array(
                    'status' => 'ok',
                    'data' => 'Se agregó el transporte correctamente'
                );
                echo json_encode($json);
            } else {
                $json = array(
                    'status' => 'error',
                    'data' => 'No se pudo agregar el transporte'
                );
                echo json_encode($json);
            }
        }
    }

}

?>