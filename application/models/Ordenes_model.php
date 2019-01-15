<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ordenes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Preordenes/generar_orden_ajax
     */
    public function set($datos) {
        $this->db->insert('ordenes', $datos);
        return $this->db->insert_id();
    }
}

?>