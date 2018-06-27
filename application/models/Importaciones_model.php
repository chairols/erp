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
     *  Importaciones/agregar_items
     */
    public function update($where, $idimportacion) {
        $this->db->update('importaciones', $where, array('idimportacion' => $idimportacion));
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
}

?>
