<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Archivos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    public function listar() {
        
    }
}

?>
