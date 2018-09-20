<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Retenciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Retenciones/agregar_ajax
     */
    public function get_max_numero_where($where) {
        $this->db->select_max('numero');
        $this->db->from('retenciones');
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Retenciones/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('retenciones', $datos);
        return $this->db->insert_id();
    }

    /*
     *  Retenciones/modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('retenciones', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Retenciones/update_ajax
     */
    public function update($datos, $where) {
        $this->db->update('retenciones', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Retenciones/gets_items_table_body_ajax
     */
    public function gets_items_where($where) {
        $this->db->select('*');
        $this->db->from('retenciones_items');
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Retenciones/agregar_item_ajax
     */
    public function set_item($datos) {
        $this->db->insert('retenciones_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Retenciones/borrar_item
     */
    public function update_item($datos, $where) {
        $this->db->update('retenciones_items', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Retenciones/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('retenciones');
        $this->db->join('provincias', 'retenciones.idjurisdiccion_afip = provincias.idjurisdiccion_afip');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Retenciones/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('retenciones.*, provincias.provincia as jurisdiccion');
        $this->db->from('retenciones');
        $this->db->join('provincias', 'retenciones.idjurisdiccion_afip = provincias.idjurisdiccion_afip');
        $this->db->like($where);
        $this->db->order_by('idretencion DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>
