<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos_iva_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Parametros/empresa
     * 
     *  Pedidos/agregar
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('tipos_iva');
        $this->db->order_by('porcentaje');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Pedidos/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('tipos_iva', $where);
        return $query->row_array();
    }
}

?>