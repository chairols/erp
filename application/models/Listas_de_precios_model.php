<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Listas_de_precios_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        
    }
    
    /*
     *  Listas_de_precios/importar
     */
    public function set($datos) {
        $this->db->insert('listas_de_precios', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Listas_de_precios/importar
     */
    public function set_item($datos) {
        $this->db->insert('listas_de_precios_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
     */
    public function gets_marcas_por_idlista_de_precios($idlista_de_precios) {
        $this->db->select('listas_de_precios_items.marca as marca_lista, marcas.*');
        $this->db->from('listas_de_precios_items');
        $this->db->join('marcas', 'marcas.marca = listas_de_precios_items.marca', 'left');
        $this->db->where(array('listas_de_precios_items.idlista_de_precios' => $idlista_de_precios));
        $this->db->group_by('listas_de_precios_items.marca');
        

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
     *  Listas_de_precios/borrar_items_lista_de_precios_ajax
     */
    public function update_items($datos, $where) {
        $this->db->update('listas_de_precios_items', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
     *  Listas_de_precios/update_item_articulo_generico
     * 
     *  Preordenes/agregar_modificar_item_ajax
     */
    public function get_where_item($where) {
        $query = $this->db->get_where('listas_de_precios_items', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Listas_de_precios/asociar_generico
     */
    public function get_where($where) {
        $query = $this->db->get_where('listas_de_precios', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Listas_de_precios/asociar_generico
     *  Listas_de_precios/ver_listas
     */
    public function get_cantidad_items_where($where, $like) {
        $this->db->select('*');
        $this->db->from('listas_de_precios_items');
        $this->db->where($where);
        $this->db->like($like);

        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Listas_de_precios/asociar_generico
     */
    public function get_cantidad_items_where_limit($where, $like, $per_page, $pagina) {
        $this->db->select('listas_de_precios_items.*, articulos_genericos.articulo_generico as articulos_genericos_articulo_generico, articulos_genericos.idarticulo_generico as articulos_genericos_idarticulo_generico, marcas.idmarca as marcas_idmarca, marcas.marca as marcas_marca');
        $this->db->from('listas_de_precios_items');
        $this->db->join('marcas', 'listas_de_precios_items.idmarca = marcas.idmarca');
        $this->db->join('articulos_genericos', 'listas_de_precios_items.idarticulo_generico = articulos_genericos.idarticulo_generico', 'left');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->order_by('listas_de_precios_items.idlista_de_precios_item');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/ver_listas
     */
    public function get_cantidad_where($where, $like) {
        $this->db->select('*');
        $this->db->from('listas_de_precios');
        $this->db->where($where);
        $this->db->like($like);

        $query = $this->db->count_all_results();
        return $query;
    }
    
    
    /*
     *  Listas_de_precios/ver_listas
     */
    public function get_cantidad_where_limit($where, $like,$per_page, $pagina) {
        $this->db->select('listas_de_precios.*, monedas.moneda');
        $this->db->from('listas_de_precios');
        $this->db->join('monedas', 'listas_de_precios.idmoneda = monedas.idmoneda', 'left');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->order_by('listas_de_precios.fecha DESC');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function gets_proveedores_con_lista() {
        $this->db->select('*');
        $this->db->from('listas_de_precios');
        $this->db->order_by('proveedor');
        $this->db->group_by('proveedor');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/nueva_comparacion_ajax
     */
    public function set_comparacion($datos) {
        $this->db->insert('listas_de_precios_comparaciones', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Listas_de_precios/nueva_comparacion_ajax
     */
    public function get_ultima_lista($where) {
        $this->db->select_max("fecha");
        $this->db->from("listas_de_precios");
        $this->db->where($where);
        $query = $this->db->get();
        $fecha = $query->row_array();
        
        $where['fecha'] = $fecha['fecha'];
        
        $this->db->select("*");
        $this->db->from("listas_de_precios");
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /*
     *  Listas_de_precios/nueva_comparacion_ajax
     */
    public function gets_items($where) {
        $this->db->select("*");
        $this->db->from("listas_de_precios_items");
        $this->db->where($where);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/nueva_comparacion_ajax
     */
    public function set_comparacion_item($datos) {
        $this->db->insert('listas_de_precios_comparaciones_items', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Listas_de_precios/comparaciones
     */
    public function get_cantidad_comparaciones_where($where, $like) {
        $this->db->select('*');
        $this->db->from('listas_de_precios_comparaciones');
        $this->db->where($where);
        $this->db->like($like);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Listas_de_precios/comparaciones
     */
    public function get_cantidad_comparaciones_where_limit($where, $like, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('listas_de_precios_comparaciones');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->order_by('listas_de_precios_comparaciones.fecha_creacion DESC');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/comparaciones
     */
    public function gets_proveedores_comparaciones($where) {
        $this->db->select("proveedores.proveedor");
        $this->db->from('listas_de_precios_comparaciones_items');
        $this->db->join('listas_de_precios_items', 'listas_de_precios_comparaciones_items.idlista_de_precios_item = listas_de_precios_items.idlista_de_precios_item');
        $this->db->join('listas_de_precios', 'listas_de_precios.idlista_de_precios = listas_de_precios_items.idlista_de_precios');
        $this->db->join('proveedores', 'listas_de_precios.idproveedor = proveedores.idproveedor');
        $this->db->where($where);
        $this->db->group_by('proveedores.idproveedor');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/comparaciones
     */
    public function gets_marcas_comparaciones($where) {
        $this->db->select("marcas.marca");
        $this->db->from('listas_de_precios_comparaciones_items');
        $this->db->join('marcas', 'listas_de_precios_comparaciones_items.idmarca = marcas.idmarca');
        $this->db->where($where);
        $this->db->group_by('marcas.idmarca');
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/ver_comparacion
     */
    public function get_cantidad_comparaciones_items_where($where, $like) {
        $this->db->select('*');
        $this->db->from('listas_de_precios_comparaciones_items');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->group_by('idarticulo_generico');

        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Listas_de_precios/ver_comparacion
     */
    public function get_cantidad_comparaciones_items_where_limit($where, $like, $per_page, $pagina) {
        $this->db->select('listas_de_precios_comparaciones_items.*, articulos_genericos.articulo_generico');
        $this->db->from('listas_de_precios_comparaciones_items');
        $this->db->join('articulos_genericos', 'listas_de_precios_comparaciones_items.idarticulo_generico = articulos_genericos.idarticulo_generico');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->group_by('listas_de_precios_comparaciones_items.idarticulo_generico');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Listas_de_precios/ver_comparacion
     */
    public function gets_comparaciones_items($where) {
        $this->db->select("listas_de_precios.idproveedor, listas_de_precios_comparaciones_items.idlista_de_precios_comparacion_item, listas_de_precios_comparaciones_items.articulo, listas_de_precios_comparaciones_items.precio, listas_de_precios_comparaciones_items.stock, proveedores.proveedor, marcas.marca, marcas.idmarca");
        $this->db->from("listas_de_precios_comparaciones_items");
        $this->db->join("listas_de_precios_items", "listas_de_precios_comparaciones_items.idlista_de_precios_item = listas_de_precios_items.idlista_de_precios_item");
        $this->db->join("listas_de_precios", "listas_de_precios_items.idlista_de_precios = listas_de_precios.idlista_de_precios");
        $this->db->join("proveedores", "listas_de_precios.idproveedor = proveedores.idproveedor");
        $this->db->join("marcas", "listas_de_precios_items.idmarca = marcas.idmarca");
        
        $this->db->where($where);
        $this->db->order_by("listas_de_precios_comparaciones_items.precio");
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Preordenes/agregar_modificar_item_ajax
     */
    public function get_where_comparacion_item($where) {
        $query = $this->db->get_where('listas_de_precios_comparaciones_items', $where);
        
        return $query->row_array();
    }
}

?>
