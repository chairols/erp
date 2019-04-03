<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Corredores_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Corredores/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('corredores');
        $this->db->like($where);

        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Corredores/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('corredores');
        $this->db->like($where);
        $this->db->order_by('nombre, apellido');
        $this->db->limit($per_page, $pagina);

        $query = $this->db->get();
        return $query->result_array();
    }
}

?>