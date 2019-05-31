<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Articulos/listar
     */
    public function get_cantidad_where($where, $like) {
        $this->db->select('*');
        $this->db->from('articulos');
        $this->db->join('lineas', 'articulos.idlinea = lineas.idlinea');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->join('articulos_genericos', 'articulos.idarticulo_generico = articulos_genericos.idarticulo_generico', 'left');
        $this->db->where($where);
        $this->db->like($like);

        $query = $this->db->count_all_results();
        return $query;
    }

    /*
     *  Articulos/listar
     */
    public function gets_where_limit($where, $like, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('articulos');
        $this->db->join('lineas', 'articulos.idlinea = lineas.idlinea');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->join('articulos_genericos', 'articulos.idarticulo_generico = articulos_genericos.idarticulo_generico', 'left');
        $this->db->where($where);
        $this->db->like($like);
        $this->db->order_by('articulos.numero_orden, articulos.articulo');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }


    /*
     *  Articulos/agregar_ajax
     *  Artículos/get_where_json
     *  Artículos/modificar
     * 
     *  Cotizaciones_proveedores/agregar_articulo_ajax
     *  Cotizaciones_proveedores/listar
     *  Cotizaciones_proveedores/listar_articulos_tabla_ajax
     * 
     *  Importaciones/modificar_item
     *
     *  Importar/actualizar_articulos
     *
     *  Listas_de_precios/importar
     * 
     *  Preordenes/generar_orden_ajax
     */
    public function get_where($where) {
        $query = $this->db->get_where('articulos', $where);

        return $query->row_array();
    }
    
    /*
     *  Articulos/agregar_ajax
     */
    public function update($datos, $where) {
        $this->db->update('articulos', $datos, $where);
        return $this->db->affected_rows();
    }
    
    /*
     *  Articulos/agregar_ajax
     */
    public function set($array) {
        $this->db->insert('articulos', $array);
        return $this->db->insert_id();
    }


    /*
     *  Importaciones/agregar_items
     */
    public function gets_where_para_ajax($where, $limit)
    {
      $this->db->select('idarticulo as id, articulo as text, idmarca');
      $this->db->from('articulos');
      $this->db->like($where);
      $this->db->order_by('articulo');
      $this->db->limit($limit);

      $query = $this->db->get();
      return $query->result_array();
    }

    /*
     *  Listas_de_precios/ver_comparacion
     */
    public function get_sum_stock_por_idarticulo_generico($idarticulo_generico) {
        $this->db->select_sum('stock');
        $this->db->from('articulos');
        $this->db->where(array('idarticulo_generico' => $idarticulo_generico));

        $query = $this->db->get();
        return $query->row_array();
    }

    /*
     *  Articulos_genericos/finalizados
     */
    public function gets_where($where) {
        $this->db->select('*');
        $this->db->from('articulos');
        $this->db->join('lineas', 'articulos.idlinea = lineas.idlinea');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->join('articulos_genericos', 'articulos.idarticulo_generico = articulos_genericos.idarticulo_generico', 'left');
        $this->db->where($where);
        $this->db->order_by('articulo');

        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     *  Importaciones/agregar_items
     */
    public function gets_where_para_ajax_con_stock_y_precio($like, $where, $limit)
    {
      $this->db->select('idarticulo as id, articulo as text, idmarca, stock, precio');
      $this->db->from('articulos');
      $this->db->where($where);
      $this->db->like($like);
      $this->db->order_by('articulo');
      $this->db->limit($limit);

      $query = $this->db->get();
      return $query->result_array();
    }
}

?>
