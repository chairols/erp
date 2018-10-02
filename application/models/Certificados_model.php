<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Certificados_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }

    /*
     *  Certificados/agregar
     */
    public function set($datos) {
        $this->db->insert('certificados', $datos);
        return $this->db->insert_id();
    }
    
    /*
     *  Certificados/listar
     */
    public function get_cantidad_where($where) {
        $this->db->select('*');
        $this->db->from('certificados');
        $this->db->like($where);
        
        $query = $this->db->count_all_results();
        return $query;
    }
    
    /*
     *  Certificados/listar
     */
    public function gets_where_limit($where, $per_page, $pagina) {
        $this->db->select('*');
        $this->db->from('certificados');
        $this->db->like($where);
        $this->db->order_by('fecha_hasta DESC');
        $this->db->limit($per_page, $pagina);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /*
     * 
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('certificados');
        $this->db->order_by('fecha_hasta DESC');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>
