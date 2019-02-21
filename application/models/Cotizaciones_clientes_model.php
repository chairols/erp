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
    
    /*
     *  Cotizaciones_clientes/agregar_articulo_ajax
     */
    public function set_item($datos) {
        $this->db->insert('cotizaciones_clientes_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Cotizaciones_clientes/borrar_articulo_ajax
     */
    public function update_item($datos, $where) {
        $this->db->update('cotizaciones_clientes_items', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Cotizaciones_clientes/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('cotizaciones_clientes.*');
        $this->db->from('cotizaciones_clientes');
        $this->db->join('monedas', 'cotizaciones_clientes.idmoneda = monedas.idmoneda');
        $this->db->join('cotizaciones_clientes_items', 'cotizaciones_clientes.idcotizacion_cliente = cotizaciones_clientes_items.idcotizacion_cliente');
        $this->db->join('articulos', 'cotizaciones_clientes_items.idarticulo = articulos.idarticulo');
        $this->db->like($where);
        $this->db->group_by('cotizaciones_clientes.idcotizacion_cliente');
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Cotizaciones_clientes/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('cotizaciones_clientes.*, monedas.moneda');
        $this->db->from('cotizaciones_clientes');
        $this->db->join('monedas', 'cotizaciones_clientes.idmoneda = monedas.idmoneda');
        $this->db->join('cotizaciones_clientes_items', 'cotizaciones_clientes.idcotizacion_cliente = cotizaciones_clientes_items.idcotizacion_cliente');
        $this->db->join('articulos', 'cotizaciones_clientes_items.idarticulo = articulos.idarticulo');
        $this->db->like($where);
        $this->db->group_by('cotizaciones_clientes.idcotizacion_cliente');
        $this->db->order_by('cotizaciones_clientes.idcotizacion_cliente DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>