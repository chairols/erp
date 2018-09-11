<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Retenciones extends CI_Controller {

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
        $data['title'] = 'Agregar Retención';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'retenciones/agregar';
        
        $data['jurisdicciones'] = $this->provincias_model->gets();
        
        $this->load->view('layout/app', $data);
    }

}

?>
