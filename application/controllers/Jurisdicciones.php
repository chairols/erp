<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jurisdicciones extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function agregar() {
        $data['title'] = 'Agregar Jurisdicción';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['view'] = 'jurisdicciones/agregar';
        
        
        $this->load->view('layout/app', $data);
    }

}

?>
