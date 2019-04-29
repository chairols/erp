<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_de_cuentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'plan_de_cuentas_model',
            'parametros_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Cuenta';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/plan_de_cuentas/js/agregar.js'
        );
        $data['view'] = 'plan_de_cuentas/agregar';

        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        $session = $this->session->all_userdata();

        $this->form_validation->set_rules('idplan_de_cuenta', 'Número', 'required|integer');
        $this->form_validation->set_rules('plan_de_cuenta', 'Cuenta', 'required');
        $this->form_validation->set_rules('idpadre', 'Depende de', 'required|integer');
        $this->form_validation->set_rules('imputa_caja', 'Imputa Caja', 'required');
        $this->form_validation->set_rules('imputa_mayor', 'Imputa Mayor', 'required');
        $this->form_validation->set_rules('ajuste', 'Ajuste', 'required');

        if ($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            $where = array(
                'idplan_de_cuenta' => $this->input->post('idplan_de_cuenta')
            );
            $cuenta = $this->plan_de_cuentas_model->get_where($where);

            if ($cuenta) {
                $json = array(
                    'status' => 'error',
                    'data' => 'La cuenta '.$this->input->post('idplan_de_cuenta').' ya existe'
                );
                echo json_encode($json);
            } else {
                $set = $this->input->post();

                $resultado = $this->plan_de_cuentas_model->set($set);

                if ($resultado) {
                    $json = array(
                        'status' => 'ok',
                        'data' => 'Se agregó la cuenta '.$this->input->post('plan_de_cuenta').' correctamente'
                    );
                    echo json_encode($json);
                } else {
                    $json = array(
                        'status' => 'error',
                        'data' => 'No se pudo agregar la cuenta '.$this->input->post('plan_de_cuenta')
                    );
                    echo json_encode($json);
                }
            }
        }
    }

    public function gets_cuentas_json() {
        $like = array(
            "concat_ws(' - ', idplan_de_cuenta, plan_de_cuenta)" => $this->input->post('plan')
        );

        echo json_encode($this->plan_de_cuentas_model->gets_like($like));
    }

    public function listar() {
        $data['title'] = 'Listado de Plan de Cuentas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['css'] = array(
            '/assets/modulos/plan_de_cuentas/css/listar.css'
        );
        $data['javascript'] = array(
            '/assets/vendors/Nestable-master/jquery.nestable.js',
            '/assets/modulos/plan_de_cuentas/js/listar.js'
        );

        $data['cuentas'] = $this->gets_hijos(0);
        
        $data['view'] = 'plan_de_cuentas/listar';
        $this->load->view('layout/app', $data);
    }
    
    private function gets_hijos($idplan_de_cuenta) {
        $where = array(
            'idpadre' => $idplan_de_cuenta,
            'estado' => 'A'
        );
        $hijos = $this->plan_de_cuentas_model->gets_where($where);
        
        foreach($hijos as $key => $value) {
            $hijos[$key]['hijos'] = $this->gets_hijos($value['idplan_de_cuenta']);
        }
        
        return $hijos;
    }
}

?>