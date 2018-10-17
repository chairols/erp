<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calificaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Calificaciones/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('calificaciones', $datos);
        return $this->db->insert_id();
    }
}

?>