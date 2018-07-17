<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listas_de_precios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
    }
    
    /*
     *  Listas_de_precios/importar
     */
    public function set($datos) {
        $this->db->insert('listas_de_precios', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Listas_de_precios/importar
     */
    public function set_item($datos) {
        $this->db->insert('listas_de_precios_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
     */
    public function gets_marcas_por_idlista_de_precios($idlista_de_precios) {
        $this->db->select('listas_de_precios_items.marca as marca_lista, marcas.*');
        $this->db->from('listas_de_precios_items');
        $this->db->join('marcas', 'marcas.marca = listas_de_precios_items.marca', 'left');
        $this->db->where(array('listas_de_precios_items.idlista_de_precios' => $idlista_de_precios));
        $this->db->group_by('listas_de_precios_items.marca');
        

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
     */
    public function update_items($datos, $where) {
        $this->db->update('listas_de_precios_items', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
     */
    public function get_where_item($where) {
        $query = $this->db->get_where('listas_de_precios_items', $where);
        
        return $query->row_array();
    }
}

?>
