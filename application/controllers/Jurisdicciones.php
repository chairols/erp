<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurisdicciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'provincias_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Jurisdicción';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array(
            '/assets/modulos/jurisdicciones/js/agregar.js'
        );
        $data['view'] = 'jurisdicciones/agregar';
        
        $data['provincias'] = $this->provincias_model->gets();
        
        $this->load->view('layout/app', $data);
    }

    public function agregar_ajax() {
        
    }
}

?>
