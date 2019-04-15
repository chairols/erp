<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Pedidos/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('pedidos', $datos);
        return $this->db->insert_id();
    }
}

?>