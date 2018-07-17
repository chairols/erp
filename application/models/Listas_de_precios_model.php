<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listas_de_precios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
    }
    
    /*
     *  Listas_de_precios/importar
     */
    public function set($datos) {
        $this->db->insert('listas_de_precios', $datos);
        return $this->db->insert_id();
    }
    
    public function set_item($datos) {
        $this->db->insert('listas_de_precios_items', $datos);
        return $this->db->insert_id();
    }
}

?>
