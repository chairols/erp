<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prueba extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        $this->load->view('layout/header');
        $this->load->view('layout/menu');
        $this->load->view('prueba/index');
        $this->load->view('layout/footer');
    }

}

?>
