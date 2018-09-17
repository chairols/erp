<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Condiciones_de_venta_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Condiciones_de_venta/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('condiciones_de_venta');
        $this->db->like($where);

        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Condiciones_de_venta/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('condiciones_de_venta');
        $this->db->like($where);
        $this->db->order_by('condicion_de_venta');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
}

?>
