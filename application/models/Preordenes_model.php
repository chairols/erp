<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preordenes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Preordenes/agregar_modificar_item_ajax
     *  Preordenes/modificar_cantidad_ajax
     *  
     */
    public function get_where($where) {
        $query = $this->db->get_where('pre_ordenes', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Listas_de_precios/ver_comparacion
     * 
     *  Preordenes/agregar_modificar_item_ajax
     */
    public function set($datos) {
        $this->db->insert('pre_ordenes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Preordenes/agregar_modificar_item_ajax
     *  Preordenes/modificar_cantidad_ajax
     */
    public function update($datos, $where) {
        $this->db->update('pre_ordenes', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Preordenes/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('pre_ordenes');
        $this->db->where($where);
        $this->db->group_by('idproveedor');
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Preordenes/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*, sum(cantidad) as cantidad_items, count(*) as cantidad_registros, sum(cantidad*precio) as total');
        $this->db->from('pre_ordenes');
        $this->db->where($where);
        $this->db->group_by('idproveedor');
        $this->db->order_by('proveedor');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Preordenes/modificar
     */
    public function gets_where($where) {
        $query = $this->db->get_where('pre_ordenes', $where);
        
        return $query->result_array();
    }
    
    /*
     *  Preordenes/modificar
     *  Preordenes/modificar_cantidad_ajax
     */
    public function get_total($where) {
        $this->db->select('*, sum(cantidad*precio) as total');
        $this->db->from('pre_ordenes');
        $this->db->where($where);
        $this->db->group_by('idproveedor');
        
        $query = $this->db->get();
        return $query->row_array();
    }
}

?>