<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'pedidos_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function pedidos() {
        $data['title'] = 'Facturación de Pedidos';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/facturacion/js/pedidos.js'
        );
        $data['view'] = 'facturacion/pedidos';

        $this->load->view('layout/app', $data);
    }
    
    public function gets_pedidos_ajax() {
        $where['pedidos.idcliente'] = $this->input->post('idcliente');
        $where['pedidos.estado'] = 'P';
        $group_by = "pedidos.idcliente";
        $order_by = "pedidos.idpedido";
        
        $data['pedidos'] = $this->pedidos_model->gets_where($where, $group_by, $order_by);
        
        foreach($data['pedidos'] as $key => $value) {
            $data['pedidos'][$key]['fecha_formateada'] = $this->formatear_fecha_para_mostrar($value['fecha_creacion']);
        }
        
        $this->load->view('facturacion/gets_pedidos_ajax', $data);
    }
    
    private function formatear_fecha_para_mostrar($fecha) {
        $aux = '';
        $aux .= substr($fecha, 8, 2);
        $aux .= '/';
        $aux .= substr($fecha, 5, 2);
        $aux .= '/';
        $aux .= substr($fecha, 0, 4);

        return $aux;
    }
}

?>