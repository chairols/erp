<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preordenes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Preordenes/agregar_modificar_item_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('pre_ordenes', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Preordenes/agregar_modificar_item_ajax
     */
    public function set($datos) {
        $this->db->insert('pre_ordenes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Preordenes/agregar_modificar_item_ajax
     */
    public function update($datos, $where) {
        $this->db->update('pre_ordenes', $datos, $where);
        return $this->db->affected_rows();
    }
}

?>