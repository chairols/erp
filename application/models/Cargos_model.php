<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cargos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Cargos/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('cargos', $where);

        return $query->row_array();
    }
    
    /*
     *  Cargos/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('cargos', $datos);
        return $this->db->insert_id();
    }
}

?>