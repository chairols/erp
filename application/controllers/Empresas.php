<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    function todas($pagina = 0) {
        $data['title'] = 'Listado de Empresas';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        
        
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/menu');
        $this->load->view('empresas/todas');
        $this->load->view('layout/footer');
    }

}

?>