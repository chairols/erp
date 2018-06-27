<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Importaciones/agregar
     */
    public function set($datos) {
        $this->db->insert('importaciones', $datos);
        return $this->db->insert_id();
    }
}

?>
