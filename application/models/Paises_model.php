<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paises_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Proveedores/modificar
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('paises');
        $this->db->order_by('pais');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>