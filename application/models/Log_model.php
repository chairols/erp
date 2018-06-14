<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //Codeigniter : Write Less Do More
    }
    
    /*
     *  Menu/agregar
     */
    public function set($array) {
        $this->db->insert('log', $array);
    }
    
    
    public function get_where($where) {
        $query = $this->db->get_where('log', $where);
        
        return $query->row_array();
    }
}
?>