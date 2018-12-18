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
    
    /*
     *  Cotizaciones_proveedores/listar_archivos_tabla_ajax
     */
    public function gets_archivos_where($where) {
        $query = $this->db->get_where('cotizaciones_proveedores_archivos', $where);
        
        return $query->result_array();
    }
    
    /*
     *  Cotizaciones_proveedores/agregar_archivos_ajax
     */
    public function set_archivos($datos) {
        $this->db->insert('cotizaciones_proveedores_archivos', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Cotizaciones_proveedores/agregar_articulo_ajax
     */
    public function set_item($datos) {
        $this->db->insert('cotizaciones_proveedores_items', $datos);
        return $this->db->insert_id();
    }
}
?>