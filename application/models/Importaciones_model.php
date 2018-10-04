<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Importaciones_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Importaciones/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('importaciones', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function get_where($where) {
        $query = $this->db->get_where('importaciones', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importaciones/modificar_item
     */
    public function get_where_item($where) {
        $query = $this->db->get_where('importaciones_items', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importaciones/actualizar_cabecera_importacion_ajax
     */
    public function update($datos, $where) {
        $this->db->update('importaciones',$datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Importaciones/agregar_items
     *  Importaciones/borrar_item_confirmado_ajax
     */
    public function update_item($where, $idimportacion_item) {
        $this->db->update('importaciones_items', $where, array('idimportacion_item' => $idimportacion_item));
        return $this->db->affected_rows();
    }
    
    /*
     *  Importaciones/agregar_item_ajax
     */
    public function set_item($datos) {
        $this->db->insert('importaciones_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function gets_items($where) {
        $this->db->select('importaciones_items.*, articulos.articulo, marcas.marca');
        $this->db->from('importaciones_items');
        $this->db->join('articulos', 'importaciones_items.idarticulo = articulos.idarticulo');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->like($where);
        $this->db->order_by('idimportacion_item');
        
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Importaciones/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('importaciones');
        $this->db->join('proveedores', 'importaciones.idproveedor = proveedores.idproveedor');
        $this->db->join('monedas', 'importaciones.idmoneda = monedas.idmoneda');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Importaciones/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('importaciones.*, proveedores.proveedor, monedas.moneda');
        $this->db->from('importaciones');
        $this->db->join('proveedores', 'importaciones.idproveedor = proveedores.idproveedor');
        $this->db->join('monedas', 'importaciones.idmoneda = monedas.idmoneda');
        $this->db->like($where);
        $this->db->order_by('idimportacion DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function get_cantidad_items($idimportacion) {
        $this->db->select('*');
        $this->db->from('importaciones_items');
        $this->db->like(array('idimportacion' => $idimportacion, 'estado' => 'A'));
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Embarques/confirmacion
     */
    public function gets_where_group_by($where) {
        $this->db->select('importaciones.*, empresas.empresa');
        $this->db->from('importaciones');
        $this->db->join('empresas', 'importaciones.idproveedor = empresas.idempresa');
        $this->db->like($where);
        $this->db->order_by('empresas.empresa');
        $this->db->group_by('empresas.empresa');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Importaciones/confirmacion
     */
    public function gets_proveedores_con_items_pendientes() {
        $query = $this->db->query("SELECT *
                                    FROM
                                        importaciones i,
                                        empresas e
                                    WHERE
                                        i.importaciones_estado = 'P' AND
                                        e.idempresa = i.idproveedor
                                    GROUP BY
                                        e.empresa
                                    ORDER BY
                                        e.empresa");
        return $query->result_array();
    }
    
    /*
     *  Importaciones/confirmacion
     */
    public function set_importacion_confirmacion($datos) {
        $this->db->insert('importaciones_confirmaciones', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Importaciones/confirmacion_items
     */
    public function get_confirmacion_where($where) {
        $this->db->select('*');
        $this->db->from('importaciones_confirmaciones');
        $this->db->join('empresas', 'importaciones_confirmaciones.idproveedor = empresas.idempresa');
        $this->db->like($where);
        
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Importaciones/items_backorder_ajax
     */
    public function gets_items_backorder($idproveedor) {
        $this->db->select('importaciones_items.*, importaciones.*, articulos.articulo, marcas.marca');
        $this->db->from('importaciones_items');
        $this->db->join('importaciones', 'importaciones_items.idimportacion = importaciones.idimportacion');
        $this->db->join('articulos', 'importaciones_items.idarticulo = articulos.idarticulo');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->where('importaciones_items.estado', 'A');
        $this->db->where('importaciones_items.cantidad_pendiente >', '0');
        $this->db->where('importaciones.idproveedor', $idproveedor);
        
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Importaciones/confirmar_item_de_pedido_ajax
     */
    public function set_confirmacion_item($datos) {
        $this->db->insert('importaciones_confirmaciones_items', $datos);
        return $this->db->insert_id();
    }
    
    
    public function gets_items_confirmados($idimportacion_confirmacion) {
        $this->db->select('importaciones_confirmaciones_items.*, articulos.articulo, marcas.marca');
        $this->db->from('importaciones_confirmaciones_items');
        $this->db->join('importaciones_items', 'importaciones_confirmaciones_items.idimportacion_item = importaciones_items.idimportacion_item');
        $this->db->join('articulos', 'importaciones_items.idarticulo = articulos.idarticulo');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->where('importaciones_confirmaciones_items.idimportacion_confirmacion', $idimportacion_confirmacion);
        $this->db->where('importaciones_confirmaciones_items.estado', 'A');
        
        /*$this->db->select('importaciones_items.*, importaciones.*, articulos.articulo, marcas.marca');
        $this->db->from('importaciones_items');
        $this->db->join('importaciones', 'importaciones_items.idimportacion = importaciones.idimportacion');
        $this->db->join('articulos', 'importaciones_items.idarticulo = articulos.idarticulo');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->where('importaciones_items.estado', 'A');
        $this->db->where('importaciones_items.cantidad_pendiente >', '0');
        $this->db->where('importaciones.idproveedor', $idproveedor);
        */
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Importaciones/borrar_item_confirmado_ajax
     */
    public function get_where_item_confirmado($where) {
        $query = $this->db->get_where('importaciones_confirmaciones_items', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Importaciones/borrar_item_confirmado_ajax
     */
    public function update_item_confirmado($where, $idimportacion_item) {
        $this->db->update('importaciones_confirmaciones_items', $where, array('idimportacion_confirmacion_item' => $idimportacion_item));
        return $this->db->affected_rows();
    }
    
}

?>
