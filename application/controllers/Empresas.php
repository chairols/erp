<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Classname extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        $session = $this->session->all_userdata();
        $this->r_session->check($session);
    }

    function listar($pagina = 0) {
        
    }

}

?>
