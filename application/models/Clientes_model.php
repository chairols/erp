<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Importar/clientes
     */
    public function get_where($where) {
        $query = $this->db->get_where('clientes', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importar/clientes
     */
    public function set($datos) {
        $this->db->insert('clientes', $datos);
        return $this->db->insert_id();
    }
}

?>
