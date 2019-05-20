<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos_genericos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Articulos_genericos/finalizados
     *  Articulos_genericos/gets_articulos_ajax
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('articulos_genericos');
        $this->db->like($where);

        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Articulos_genericos/finalizados
     */
    public function get_cantidad_where_limit($where, $per_page, $pagina) {
        $this->db->select('articulos_genericos.*, lineas.linea');
        $this->db->from('articulos_genericos');
        $this->db->join('lineas', 'articulos_genericos.idlinea = lineas.idlinea');
        $this->db->like($where);
        $this->db->order_by('articulos_genericos.articulo_generico');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Articulos_genericos/gets_articulos_ajax
     */
    public function gets_where($where)
    {
      $this->db->select('idarticulo_generico as id, articulo_generico as text');
      $this->db->from('articulos_genericos');
      $this->db->like($where);
      $this->db->order_by('articulo_generico');

      $query = $this->db->get();
      return $query->result_array();
    }
    
    
    /*
     *  Listas_de_precios/asociar_importar
     *  Listas_de_precios/update_item_articulo_generico
     */
    public function get_where($where) {
        $query = $this->db->get_where('articulos_genericos', $where);
        
        return $query->row_array();
    }
    
    /*
     *  Articulos_genericos/agregar_ajax
     */
    public function set($datos) {
        $this->db->insert('articulos_genericos', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Articulos_genericos/borrar_ajax
     */
    public function update($datos, $where) {
        $this->db->update('articulos_genericos', $datos, $where);
        return $this->db->affected_rows();
    }
}

?>
