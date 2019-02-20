<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Cotizaciones_clientes/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('cotizaciones_clientes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Cotizaciones_clientes/modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('cotizaciones_clientes', $where);
        return $query->row_array();
    }
}

?>