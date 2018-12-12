<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_proveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session',
            'form_validation'
        ));
        $this->load->model(array(
            'monedas_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }
    
    public function agregar() {
        $data['title'] = 'Nueva Cotización de Proveedores';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/cotizaciones_proveedores/js/agregar.js'
        );
        $data['view'] = 'cotizaciones_proveedores/agregar';

        $data['monedas'] = $this->monedas_model->gets();
        
        $this->load->view('layout/app', $data);
    }
    
    public function agregar_ajax() {
        $session = $this->session->all_userdata();
        
        $this->form_validation->set_rules('idproveedor', 'Proveedor', 'required|integer');
        $this->form_validation->set_rules('idmoneda', 'Moneda', 'required|integer');
        $this->form_validation->set_rules('fecha', 'Fecha', 'required');
        
        if($this->form_validation->run() == FALSE) {
            $json = array(
                'status' => 'error',
                'data' => validation_errors()
            );
            echo json_encode($json);
        } else {
            
        }
    }
}

?>