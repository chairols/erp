<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transportes extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'provincias_model',
            'tipos_responsables_model'
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
}

?>