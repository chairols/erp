<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Articulos/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('articulos');
        $this->db->join('lineas', 'articulos.idlinea = lineas.idlinea');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->join('articulos_genericos', 'articulos.idarticulo_generico = articulos_genericos.idarticulo_generico', 'left');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Articulos/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('articulos');
        $this->db->join('lineas', 'articulos.idlinea = lineas.idlinea');
        $this->db->join('marcas', 'articulos.idmarca = marcas.idmarca');
        $this->db->join('articulos_genericos', 'articulos.idarticulo_generico = articulos_genericos.idarticulo_generico', 'left');
        $this->db->like($where);
        $this->db->order_by('articulo');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    /*
     *  Importar/actualizar_articulos
     */
    public function get_where($where) {
        $query = $this->db->get_where('articulos', $where);
        
        return $query->row_array();
    }
    public function update($datos, $idarticulo) {
        $id = array('idarticulo' => $idarticulo);
        $this->db->update('articulos', $datos, $id);
    }
    public function set($array) {
        $this->db->insert('articulos', $array);
    }
}

?>
