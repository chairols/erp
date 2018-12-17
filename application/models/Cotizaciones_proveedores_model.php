<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_proveedores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Cotizaciones_proveedores/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('cotizaciones_proveedores', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Cotizaciones_proveedores/modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('cotizaciones_proveedores', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Cotizaciones_proveedores/actualizar_cabecera_ajax
     */
    public function update($datos, $where) {
        $this->db->update('cotizaciones_proveedores', $datos, $where);
        return $this->db->affected_rows();
    }
}
?>