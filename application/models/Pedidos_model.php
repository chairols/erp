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
     *  Pedidos/listar
     */
    public function gets_articulos_where($where) {
        $query = $this->db->get_where('pedidos_items', $where);
        return $query->result_array();
    }
    
    /*
     *  Pedidos/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('pedidos.*, monedas.moneda, monedas.simbolo');
        $this->db->from('pedidos');
        $this->db->join('pedidos_items', 'pedidos.idpedido = pedidos_items.idpedido');
        $this->db->join('monedas', 'pedidos.idmoneda = monedas.idmoneda');
        $this->db->join('clientes', 'pedidos.idcliente = clientes.idcliente');
        $this->db->join('articulos', 'pedidos_items.idarticulo = articulos.idarticulo');
        $this->db->like($where);
        $this->db->group_by('pedidos.idpedido');
        $this->db->order_by('clientes.cliente');
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Pedidos/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('pedidos.*, monedas.moneda, monedas.simbolo');
        $this->db->from('pedidos');
        $this->db->join('pedidos_items', 'pedidos.idpedido = pedidos_items.idpedido');
        $this->db->join('monedas', 'pedidos.idmoneda = monedas.idmoneda');
        $this->db->join('clientes', 'pedidos.idcliente = clientes.idcliente');
        $this->db->join('articulos', 'pedidos_items.idarticulo = articulos.idarticulo');
        $this->db->like($where);
        $this->db->group_by('pedidos.idpedido');
        $this->db->order_by('clientes.cliente');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Pedidos/borrar_articulo_ajax
     *  Pedidos/modificar_item_ajax
     */
    public function update_item($datos, $where) {
        $this->db->update('pedidos_items', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Pedidos/borrar_articulo_ajax
     */
    public function get_where_item($where) {
        $query = $this->db->get_where('pedidos_items', $where);
        return $query->row_array();
    }
}

?>