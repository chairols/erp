<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Lineas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Lineas/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('lineas');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    
    /*
     *  Lineas/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('lineas');
        $this->db->like($where);
        $this->db->order_by('linea');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Artículos/agregar_ajax
     *  Artículos/agregar_full_ajax
     *  Artículos/get_where_json
     * 
     *  Articulos_genericos/agregar_ajax
     *  
     *  Cotizaciones_proveedores/listar
     * 
     *  Lineas/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('lineas', $where);
        return $query->row_array();
    }
    
    /*
     *  Lineas/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('lineas', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Lineas/gets_lineas_ajax
     */
    public function gets_where_para_ajax($where) {
        $this->db->select('idlinea as id, linea as text');
        $this->db->from('lineas');
        $this->db->like($where);
        $this->db->order_by('linea');

        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     *  Articulos/listar
     *  Articulos/modificar
     */
    public function gets_where($where) {
        $this->db->select('*');
        $this->db->from('lineas');
        $this->db->like($where);
        $this->db->order_by('linea');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Lineas/modificar_ajax
     */
    public function update($datos, $where) {
        $this->db->update('lineas', $datos, $where);
        return $this->db->affected_rows();
    }
}

?>
