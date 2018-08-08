<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobantes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Importar/migrar_comprobantes
     */
    public function set($datos) {
        $this->db->insert('comprobantes', $datos);
        return $this->db->insert_id();
    }
}

?>
