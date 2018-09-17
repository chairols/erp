<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Importar/proveedores
     */
    public function get_where($where) {
        $query = $this->db->get_where('proveedores', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importar/proveedores
     */
    public function set($datos) {
        $this->db->insert('proveedores', $datos);
        return $this->db->insert_id();
    }

}

?>
