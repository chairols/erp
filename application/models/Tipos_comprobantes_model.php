<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos_comprobantes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Retenciones/modificar
     */
    public function gets_where($where) {
        $this->db->select("*");
        $this->db->from("tipos_comprobantes");
        $this->db->where($where);
        $this->db->order_by("tipo_comprobante");
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Proveedores/agregar_ajax
     * 
     *  Retenciones/agregar_item_ajax
     */
    public function get_where($where) {
        $this->db->select("*");
        $this->db->from("tipos_comprobantes");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
}

?>
