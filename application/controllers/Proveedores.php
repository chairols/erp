<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library(array(
            'session',
            'r_session'
        ));
        $this->load->model(array(
            'proveedores_model'
        ));

        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function gets_proveedores_ajax() {

        $where = $this->input->post();

        echo json_encode( $this->proveedores_model->gets_where( $where ) );

    }

}

?>
