<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Embarques extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'importaciones_model'
        ));
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }
    
    public function confirmacion() {
        $data['title'] = 'Confirmación de Pedido';
        $data['session'] = $this->session->all_userdata();
        $data['menu'] = $this->r_session->get_menu();
        $data['javascript'] = array();
        $data['view'] = 'embarques/confirmacion';
        
        $datos = array(
            'importaciones_estado' => 'P'
        );
        $data['empresas'] = $this->importaciones_model->gets_where_group_by($datos);
        
        $this->load->view('layout/app', $data);
    }


}

?>
