<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Plan_de_cuentas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'plan_de_cuentas_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Cuenta';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'plan_de_cuentas/agregar';

        $this->load->view('layout/app', $data);
    }
    
    public function gets_cuentas_json() {
        $like = array(
            "concat_ws(' - ', idplan_de_cuenta, plan_de_cuenta)" => $this->input->post('plan')
        );
        
        echo json_encode($this->plan_de_cuentas_model->gets_like($like));
    }
}

?>