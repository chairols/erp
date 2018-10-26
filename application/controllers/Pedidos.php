<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'monedas_model',
            'parametros_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Pedido';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/pedidos/js/agregar.js'
        );
        $data['view'] = 'pedidos/agregar';

        $data['dolar'] = $this->monedas_model->get_ultima_cotizacion_por_monedas(1); // 1 es id del dolar
        $data['parametro'] = $this->parametros_model->get_parametros_empresa();
        
        $this->load->view('layout/app', $data);
    }
}

?>