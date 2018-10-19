<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empleados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Retenciones/agregar_ajax
     */
    public function get_max_legajo_where($where) {
        $this->db->select_max('idempleado');
        $this->db->from('empleados');
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Empleados/agregar_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('empleados', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Empleados/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('empleados', $datos);
        return $this->db->insert_id();
    }
}

?>