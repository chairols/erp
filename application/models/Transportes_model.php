<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transportes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Transportes/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('transportes', $datos);
        return $this->db->insert_id();
    }
}

?>