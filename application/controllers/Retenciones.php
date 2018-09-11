<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Retenciones extends CI_Controller {

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
        $data['title'] = 'Agregar Retención';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        /*$data['javascript'] = array(
            '/assets/vendors/input-mask/jquery.inputmask.js',
            '/assets/vendors/inputmask3/jquery.inputmask.date.extensions.js',
            '/assets/vendors/inputmask3/jquery.inputmask.extensions.js'
        );*/
        $data['view'] = 'retenciones/agregar';
        
        $this->load->view('layout/app', $data);
    }

}

?>
