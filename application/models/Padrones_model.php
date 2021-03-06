<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Padrones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Padrones/jurisdiccion_901
     */
    public function set($datos) {
        $this->db->insert('padrones', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Padrones/jurisdiccion_901
     *  Padrones/jurisdiccion_902
     */
    public function set_item($datos) {
        $this->db->insert('padrones_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Retenciones/agregar_ajax
     */
    public function get_where_items($where) {
        $query = $this->db->get_where('padrones_items', $where);
        return $query->row_array();
    }
    
    /*
     *  Padrones/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('count(*) as cantidad, padrones.fecha_desde, padrones.fecha_hasta, provincias.provincia');
        $this->db->from('padrones');
        $this->db->join('provincias', 'padrones.idjurisdiccion_afip = provincias.idjurisdiccion_afip');
        $this->db->like($where);
        $this->db->group_by("padrones.idpadron");
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Padrones/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('padrones.idpadron, padrones.fecha_desde, padrones.fecha_hasta, provincias.provincia');
        $this->db->from('padrones');
        $this->db->join('provincias', 'padrones.idjurisdiccion_afip = provincias.idjurisdiccion_afip');
        $this->db->like($where);
        $this->db->group_by("padrones.idpadron");
        $this->db->order_by('padrones.fecha_desde DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Retenciones/agregar_ajax
     */
    public function get_where_join($where) {
        $this->db->select("*");
        $this->db->from("padrones");
        $this->db->join("padrones_items", "padrones.idpadron = padrones_items.idpadron");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Padrones/jurisdiccion_902
     */
    public function get_where($where) {
        $this->db->select("*");
        $this->db->from("padrones");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Padrones/listar
     */
    public function get_count_items_where($where) {
        $this->db->select("*");
        $this->db->from("padrones_items");
        $this->db->where($where);
        
        return $this->db->count_all_results();
    }
    
    /*
     *  Padrones/borrar_ajax
     */
    public function borrado_fisico_padron($where) {
        $this->db->delete('padrones_items', $where);
        $this->db->delete('padrones', $where);
        
        return $this->db->affected_rows();
    }
    
    /*
     *  Padrones/jurisdiccion_902
     */
    public function update_item($datos, $where) {
        $this->db->update('padrones_items', $datos, $where);
        return $this->db->affected_rows();
    }
}

?>
