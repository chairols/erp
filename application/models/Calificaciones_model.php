<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Calificaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Calificaciones/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('calificaciones', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Calificaciones/ordenar
     *  Empleados/agregar
     */
    public function gets_where($where) {
        $this->db->select("*");
        $this->db->from('calificaciones');
        $this->db->where($where);
        $this->db->order_by("orden");
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Calificaciones/actualizar_orden
     */
    public function update($datos, $where) {
        $this->db->update('calificaciones', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Sueldos/agregar_ajax
     */
    public function get_where($where) {
        $this->db->select("*");
        $this->db->from("calificaciones");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
}

?>