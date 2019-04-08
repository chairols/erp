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
    
    /*
     *  Pedidos/modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('pedidos', $where);
        return $query->row_array();
    }
}

?>