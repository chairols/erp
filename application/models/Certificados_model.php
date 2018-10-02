<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    /*
     *  Certificados/agregar
     */
    public function set($datos) {
        $this->db->insert('certificados', $datos);
        return $this->db->insert_id();
    }
}

?>
