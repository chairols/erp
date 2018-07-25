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
     */
    public function update_items($datos, $where) {
        $this->db->update('listas_de_precios_items', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Listas_de_precios/asociar_marcas
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
    public function get_cantidad_items_where_limit($where, $like,$per_page, $pagina) {
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
        $this->db->select('listas_de_precios.*, empresas.empresa, monedas.moneda');
        $this->db->from('listas_de_precios');
        $this->db->join('empresas', 'listas_de_precios.idempresa = empresas.idempresa');
        $this->db->join('monedas', 'listas_de_precios.idmoneda = monedas.idmoneda', 'left');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->order_by('listas_de_precios.fecha DESC');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
}

?>
