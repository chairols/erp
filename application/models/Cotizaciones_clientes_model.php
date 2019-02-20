<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_clientes_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Cotizaciones_clientes/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('cotizaciones_clientes', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Cotizaciones_clientes/modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('cotizaciones_clientes', $where);
        return $query->row_array();
    }
    
    /*
     *  Cotizaciones_clientes/actualizar_cabecera_ajax
     */
    public function update($datos, $where) {
        $this->db->update('cotizaciones_clientes', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Cotizaciones_clientes/listar_articulos_tabla_ajax
     */
    public function gets_articulos_where($where) {
        $query = $this->db->get_where('cotizaciones_clientes_items', $where);
        return $query->result_array();
    }
}

?>