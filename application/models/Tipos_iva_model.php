<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Tipos_iva_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    /*
     *  Parametros/empresa
     */
    public function gets() {
        $this->db->select('*');
        $this->db->from('tipos_iva');
        $this->db->order_by('porcentaje');
        
        $query = $this->db->get();
        return $query->result_array();
    }
}

?>