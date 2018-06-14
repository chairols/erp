<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }
    
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('empresas');
        $this->db->like($where);
        $this->db->order_by('empresa');
        
        $query = $this->db->count_all_results();
        return $query;
    }

    public function get_cantidad_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('empresas');
        $this->db->join('empresas_tipos', 'empresas.idempresa_tipo = empresas_tipos.idempresa_tipo');
        $this->db->like($where);
        $this->db->order_by('empresa');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>
