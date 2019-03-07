<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dias_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Clientes/modificar
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('dias');
        $this->db->order_by('iddia');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>