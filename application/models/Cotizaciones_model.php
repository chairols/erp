<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Cotizaciones/proveedores_internacionales
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('cotizaciones');
        $this->db->join('empresas', 'cotizaciones.idempresa = empresas.idempresa');
        $this->db->join('monedas', 'cotizaciones.idmoneda = monedas.idmoneda');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }

    /*
     *  Cotizaciones/proveedores_internacionales
     */
    public function get_cantidad_where_limit($where, $per_page, $pagina) {
        $this->db->select('*, CONCAT(monedas.simbolo, " ", cotizaciones.total) as total_formateado');
        $this->db->from('cotizaciones');
        $this->db->join('empresas', 'cotizaciones.idempresa = empresas.idempresa');
        $this->db->join('monedas', 'cotizaciones.idmoneda = monedas.idmoneda');
        $this->db->like($where);
        $this->db->order_by('idcotizacion DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Cotizaciones/proveedores_internacionales
     */
    public function gets_items_where($where) {
        $this->db->select('*');
        $this->db->from('cotizaciones_items');
        $this->db->like($where);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>