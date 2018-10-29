<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'clientes_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function gets_clientes_ajax() {

        $where = $this->input->post();

        echo json_encode($this->clientes_model->gets_where($where));
    }

    public function gets_sucursales_select() {
        $where = array(
            'idcliente' => $this->input->post('idcliente')
        );
        $data['sucursales'] = $this->clientes_model->gets_sucursales($where);
        
        $this->load->view('clientes/gets_sucursales_select', $data);
    }
}

?>