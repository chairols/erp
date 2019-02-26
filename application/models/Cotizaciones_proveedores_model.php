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
    
    /*
     *  Cotizaciones_proveedores/listar_articulos_tabla_ajax
     */
    public function gets_articulos_where($where) {
        $query = $this->db->get_where('cotizaciones_proveedores_items', $where);
        
        return $query->result_array();
    }
    
    /*
     *  Cotizaciones_proveedores/borrar_archivo_ajax
     */
    public function update_archivo($datos, $where) {
        $this->db->update('cotizaciones_proveedores_archivos', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Cotizaciones_proveedores/borrar_articulo_ajax
     */
    public function update_item($datos, $where) {
        $this->db->update('cotizaciones_proveedores_items', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Cotizaciones_proveedores/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('cotizaciones_proveedores.*');
        $this->db->from('cotizaciones_proveedores');
        $this->db->join('monedas', 'cotizaciones_proveedores.idmoneda = monedas.idmoneda');
        $this->db->join('cotizaciones_proveedores_items', 'cotizaciones_proveedores.idcotizacion_proveedor = cotizaciones_proveedores_items.idcotizacion_proveedor');
        $this->db->join('articulos', 'cotizaciones_proveedores_items.idarticulo = articulos.idarticulo');
        $this->db->like($where);
        $this->db->group_by('cotizaciones_proveedores.idcotizacion_proveedor');
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Cotizaciones_proveedores/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('cotizaciones_proveedores.*, monedas.moneda');
        $this->db->from('cotizaciones_proveedores');
        $this->db->join('monedas', 'cotizaciones_proveedores.idmoneda = monedas.idmoneda');
        $this->db->join('cotizaciones_proveedores_items', 'cotizaciones_proveedores.idcotizacion_proveedor = cotizaciones_proveedores_items.idcotizacion_proveedor');
        $this->db->join('articulos', 'cotizaciones_proveedores_items.idarticulo = articulos.idarticulo');
        $this->db->like($where);
        $this->db->group_by('cotizaciones_proveedores.idcotizacion_proveedor');
        $this->db->order_by('cotizaciones_proveedores.idcotizacion_proveedor DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>