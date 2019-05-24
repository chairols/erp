<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Retenciones/agregar_ajax
     * 
     *  Sueldos/get_where_ajax
     */
    public function get_max_legajo_where($where) {
        $this->db->select_max('idempleado');
        $this->db->from('empleados');
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Empleados/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('empleados', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Empleados/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('empleados', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Empleados/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Empleados/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->like($where);
        $this->db->order_by('idempleado');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Sueldos/agregar
     */
    public function gets_where($where) {
        $this->db->select('*');
        $this->db->from('empleados');
        $this->db->where($where);
        $this->db->order_by('idempleado');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>