<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sueldos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Sueldos/agregar_concepto_ajax
     */
    public function set_concepto($datos) {
        $this->db->insert('sueldos_conceptos', $datos);
        return $this->db->affected_rows();
    }

    /*
     *  Sueldos/agregar_concepto_ajax
     */
    public function get_where_concepto($where) {
        $this->db->select("*");
        $this->db->from("sueldos_conceptos");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Sueldos/conceptos_listar
     */
    public function get_cantidad_conceptos_where($where) {
        $this->db->select('*');
        $this->db->from('sueldos_conceptos');
        $this->db->where($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Sueldos/conceptos_listar
     */
    public function gets_where_conceptos_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('sueldos_conceptos');
        $this->db->where($where);
        $this->db->order_by('idsueldo_concepto');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>