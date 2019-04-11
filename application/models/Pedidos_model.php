<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Pedidos/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('pedidos', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Pedidos/modificar
     */
    public function get_where($where) {
        $query = $this->db->get_where('pedidos', $where);
        return $query->row_array();
    }
    
    /*
     *  Pedidos/actualizar_cabecera_ajax
     */
    public function update($datos, $where) {
        $this->db->update('pedidos', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Pedidos/agregar_articulo_ajax
     */
    public function set_item($datos) {
        $this->db->insert('pedidos_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Pedidos/gets_articulos_tabla
     */
    public function gets_articulos_where($where) {
        $query = $this->db->get_where('pedidos_items', $where);
        return $query->result_array();
    }
}

?>