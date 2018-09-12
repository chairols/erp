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
}

?>
