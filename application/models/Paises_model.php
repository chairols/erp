<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paises_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Proveedores/modificar
     *  Clientes/modificar
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('paises');
        $this->db->order_by('pais');

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Proveedores/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('paises', $where);
        return $query->row_array();
    }
}

?>
