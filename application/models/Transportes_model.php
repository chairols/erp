<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transportes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Transportes/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('transportes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Transportes/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('transportes');
        $this->db->join('provincias', 'transportes.idprovincia = provincias.idprovincia');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Transportes/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('transportes.*, provincias.provincia as jurisdiccion');
        $this->db->from('transportes');
        $this->db->join('provincias', 'transportes.idprovincia = provincias.idprovincia');
        $this->db->like($where);
        $this->db->order_by('transporte');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Clientes/modificar
     * 
     *  Facturacion/pedido_modificar
     */
    public function gets() {
        $this->db->select('transportes.*, provincias.provincia as jurisdiccion');
        $this->db->from('transportes');
        $this->db->join('provincias', 'transportes.idprovincia = provincias.idprovincia');
        $this->db->where(array('transportes.estado' => 'A'));
        $this->db->order_by('transporte');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Clientes/modificar_sucursal_ajax
     * 
     *  Pedidos/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('transportes', $where);
        return $query->row_array();
    }
}

?>