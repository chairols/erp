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
    
    /*
     *  Cargos/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('cargos');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Cargos/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('cargos');
        $this->db->like($where);
        $this->db->order_by('cargo');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Clientes/modificar
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('cargos');
        $this->db->order_by('cargo');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>