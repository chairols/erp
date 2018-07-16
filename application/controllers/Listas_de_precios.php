<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listas_de_precios extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'monedas_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function importar() {
        $data['title'] = 'Importar Lista de Precios';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        
        $data['monedas'] = $this->monedas_model->gets();
        
        $data['view'] = 'listas_de_precios/importar';
        $this->load->view('layout/app', $data);
    }

}

?>
