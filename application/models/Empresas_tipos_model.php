<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas_tipos_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*
     *  Clientes/modificar
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('empresas_tipos');
        $this->db->order_by('empresa_tipo');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>