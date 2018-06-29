<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Importaciones/agregar
     */
    public function set($datos) {
        $this->db->insert('importaciones', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function get_where($where) {
        $query = $this->db->get_where('importaciones', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importaciones/modificar_item
     */
    public function get_where_item($where) {
        $query = $this->db->get_where('importaciones_items', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function update($where, $idimportacion) {
        $this->db->update('importaciones', $where, array('idimportacion' => $idimportacion));
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function update_item($where, $idimportacion_item) {
        $this->db->update('importaciones_items', $where, array('idimportacion_item' => $idimportacion_item));
        return $this->db->affected_rows();
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function set_item($datos) {
        $this->db->insert('importaciones_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function gets_items($where) {
        $this->db->select('importaciones_items.*, articulos.articulo, marcas.marca');
        $this->db->from('importaciones_items');
        $this->db->join('articulos', 'importaciones_items.idarticulo = articulos.idarticulo');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->like($where);
        $this->db->order_by('idimportacion_item');
        
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Importaciones/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('importaciones');
        $this->db->join('empresas', 'importaciones.idproveedor = empresas.idempresa');
        $this->db->join('monedas', 'importaciones.idmoneda = monedas.idmoneda');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Importaciones/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('importaciones.*, empresas.empresa, monedas.moneda');
        $this->db->from('importaciones');
        $this->db->join('empresas', 'importaciones.idproveedor = empresas.idempresa');
        $this->db->join('monedas', 'importaciones.idmoneda = monedas.idmoneda');
        $this->db->like($where);
        $this->db->order_by('idimportacion DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function get_cantidad_items($idimportacion) {
        $this->db->select('*');
        $this->db->from('importaciones_items');
        $this->db->like(array('idimportacion' => $idimportacion, 'estado' => 'A'));
        
        $query = $this->db->count_all_results();
        return $query;
    }
}

?>
