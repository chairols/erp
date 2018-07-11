<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos_genericos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Articulos_genericos/finalizados
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
}

?>
